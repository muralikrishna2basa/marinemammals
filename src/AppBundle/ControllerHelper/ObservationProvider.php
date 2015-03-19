<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 18/03/15
 * Time: 16:21
 */

namespace AppBundle\ControllerHelper;

use AppBundle\Entity\Observations;
use AppBundle\Entity\EventStates;
use AppBundle\Entity\Event2Persons;
use AppBundle\Entity\Spec2Events;

class ObservationProvider
{

    private $doctrine;
    private $repo;
    private $cgRefCodesPropertiesSet;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repo = $this->doctrine->getRepository('AppBundle:Observations');
        $this->cgRefCodesPropertiesSet = new CgRefCodesPropertiesSet($doctrine);
    }

    public function loadAndSupplementObservation($id)
    {
        $observation = $this->loadObservation($id);
        $evc = new EntityValuesCollectionAtObservationUpdate($this->doctrine);
        $evc->allObservationValues->supplementEntityValues($observation);
        $s2e = $observation->getEseSeqno()->getSpec2Events();
        $evc->allSpecimenValues->supplementEntityValues($s2e);
        return $observation;
    }

    public function loadObservation($id) //todo make cg desc supplemnt not automatic
    {
        $observation = $this->repo->find($id);
        if (!$observation) {
            throw $this->createNotFoundException(sprintf('The observation with seqno %s does not exist.', $id));
        }

        $this->supplementCgDescriptionSingle($observation);
        return $observation;
    }

    public function prepareNewObservation()
    {
        $observation = new Observations();
        $event = new EventStates();
        $observation->setEseSeqno($event);

        $event2Persons1 = new Event2Persons();
        $event2Persons1->setEseSeqno($event);
        $event2Persons1->setE2pType(EventStates::OBSERVED);
        $event->getEvent2Persons()->add($event2Persons1);

        $event2Persons2 = new Event2Persons();
        $event2Persons2->setEseSeqno($event);
        $event2Persons2->setE2pType(EventStates::GATHERED);
        $event->getEvent2Persons()->add($event2Persons2);

        $event2Persons2 = new Event2Persons();
        $event2Persons2->setEseSeqno($event);
        $event2Persons2->setE2pType(EventStates::INFORMED);
        $event->getEvent2Persons()->add($event2Persons2);

        $evcfoc = new EntityValuesCollectionAtObservationCreation($this->doctrine);

        $evcfoc->allObservationValues->supplementEntityValues($observation);

        $s2e = new Spec2Events();
        //$specimen=new Specimens();
        $event->setSpec2Events($s2e);
        //$s2e->setEseSeqno($event); //TODO: check if this can be deleted. shoudle be now that this is truly bidirectional
        //$s2e->setScnSeqno($specimen);

        $evcfoc->allSpecimenValues->supplementEntityValues($s2e);

        return $observation;
    }

    public function loadObservationsByFilter($filter, $excludeConfidential)
    {
        $filterBuilder = $this->repo->getCompleteObservationsQb();

        $eventDatetimeStart = $filter['eventDatetimeStart'];
        $eventDatetimeStop = $filter['eventDatetimeStop'];
        $stationstype = $filter['stationstype'];
        $stn = $filter['stnSeqno'];
        $txn = $filter['txnSeqno'];
        $osnType = $filter['osnType'];
        $generalPlace = $filter['generalPlace'];
        $place = $filter['place'];
        $country = '';
        if (array_key_exists('country', $filter)) {
            $country = $filter['country'];
        }
        if ($eventDatetimeStart && $eventDatetimeStop) {
            $filterBuilder->andWhere('e.eventDatetime>=:eventDatetimeStart and e.eventDatetime<=:eventDatetimeStop');
            $filterBuilder->setParameter('eventDatetimeStart', $eventDatetimeStart);
            $filterBuilder->setParameter('eventDatetimeStop', $eventDatetimeStop);
        }
        if ($stationstype) {
            $filterBuilder->andWhere('st.areaType=:areaType');
            $filterBuilder->setParameter('areaType', $stationstype);
        }
        if ($stn) {
            $filterBuilder->andWhere('o.stnSeqno=:stnSeqno');
            $filterBuilder->setParameter('stnSeqno', $stn);
        }
        if ($txn) {
            $filterBuilder->andWhere('t.canonicalName=:canonicalName');
            $filterBuilder->setParameter('canonicalName', $txn->getCanonicalName());
        }
        if ($osnType) {
            $filterBuilder->andWhere('o.osnType=:osnType');
            $filterBuilder->setParameter('osnType', $osnType);
        }
        if ($excludeConfidential) {
            $filterBuilder->andWhere('o.isconfidential=null');
            //$filterBuilder->setParameter('osnType', $osnType);
        }
        if ($place) {
            $stations = $this->doctrine->getRepository('AppBundle:Stations')
                ->getAllStationsBelongingToPlaceDeepQb($place)->getQuery()->getResult();
            $this->filterByStation($stations, $filterBuilder);
        }
        if ($generalPlace) {
            $stations = $this->doctrine->getRepository('AppBundle:Stations')
                ->getAllStationsBelongingToPlaceDeepQb($generalPlace)->getQuery()->getResult();
            $this->filterByStation($stations, $filterBuilder);
        }
        $observations = $filterBuilder->getQuery()->getResult();

        /*if ($excludeConfidential) {
            $observations = $this->excludeConfidentialObservations($observations);
        }*/

        if ($country) {
            $observations = $this->filterByCountry($country, $observations);
        }
        /*if ($excludeNonBelgian) {
            $observations = $this->excludeNonBelgianObservations($observations);
        }*/

        //$res=$this->supplementCgDescriptionMultiple($observations);
        return $observations;
    }

    public function loadObservations($excludeConfidential, $excludeNonBelgian)
    {
        //$observations = $this->repo->getCompleteObservationsQb()->getQuery()->getResult();
        $q = $this->repo->getCompleteObservationsQb();
        if ($excludeConfidential) {
            $q = $q->andWhere('o.isconfidential=null');
            //$observations = $this->excludeConfidentialObservations($observations);
        }
        $observations = $q->getQuery()->getResult();
        if ($excludeNonBelgian) {
            $observations = $this->excludeNonBelgianObservations($observations);
        }
        //$start=microtime(true);
        //$res=$this->supplementCgDescriptionMultiple($observations);
        //$end=microtime(true);
        return $observations;
    }

    public function supplementCgDescriptionMultiple($observations)
    {
        foreach ($observations as $o) {
            $this->supplementCgDescriptionSingle($o);
        }
        return $observations;
    }

    private function supplementCgDescriptionSingle(Observations &$o)
    {
        $this->cgRefCodesPropertiesSet->setAll($o);
    }

    private function filterByCountry($country, $observations)
    {
        if ($country !== '' and $country !== null) {
            return array_filter($observations, function ($o) use ($country) {
                if ($o->getStnSeqno() !== null) {
                    return $o->getStnSeqno()->getCountry() === $country;
                } else return false;

            });
        }
        return $observations;
    }

    private function filterByStation($stations, $filterBuilder)
    {
        if (null !== $stations and count($stations) > 0) {
            $filterBuilder->andWhere('o.stnSeqno IN (:stations)');
            $filterBuilder->setParameter('stations', $stations);
        } else {
            $filterBuilder->andWhere("o.osnType='THISGIVESNORESULTS'");
        }
        return $filterBuilder;
    }

    private function excludeConfidentialObservations($observations)
    {
        return array_filter($observations, function ($o) {
            return $o->getIsconfidential() === null;
        });
    }

    private function excludeNonBelgianObservations($observations)
    {
        return array_filter($observations, function ($e) {
            if ($e->getStnSeqno() !== null) {
                return $e->getStnSeqno()->getCountry() === 'BE';
            } else return false;
        });
    }
}