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

    //private $cgRefCodesPropertiesSet;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repo = $this->doctrine->getRepository('AppBundle:Observations');
        //$this->cgRefCodesPropertiesSet = new CgRefCodesPropertiesSet($doctrine);
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
        //$this->supplementCgDescriptionSingle($observation);
        return $observation;
    }

    public function prepareNewObservation()
    {
        $observation = new Observations();
        $event = new EventStates();
        $observation->setEseSeqno($event);

        $event2Persons2 = new Event2Persons();
        $event2Persons2->setEseSeqno($event);
        $event2Persons2->setE2pType(EventStates::INFORMED);
        $event->getEvent2Persons()->add($event2Persons2);

        $event2Persons1 = new Event2Persons();
        $event2Persons1->setEseSeqno($event);
        $event2Persons1->setE2pType(EventStates::OBSERVED);
        $event->getEvent2Persons()->add($event2Persons1);

        $event2Persons2 = new Event2Persons();
        $event2Persons2->setEseSeqno($event);
        $event2Persons2->setE2pType(EventStates::EXAMINED);
        $event->getEvent2Persons()->add($event2Persons2);

        $event2Persons2 = new Event2Persons();
        $event2Persons2->setEseSeqno($event);
        $event2Persons2->setE2pType(EventStates::COLLECTED);
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

    public function loadObservationsByFilter($filter,$fast)
    {
        if($fast){
            $filterBuilder = $this->repo->getFastObservationsQb();
        }
        else{
            $filterBuilder = $this->repo->getCompleteObservationsQb();
        }

        $excludeConfidential=null;
        $country = null;
        $topNLatest = null;
        $eventDatetimeStart = null;
        $eventDatetimeStop = null;
        $stationstype = null;
        $stn = null;
        $txn = null;
        $osnTypeRef = null;
        $generalPlace = null;
        $place = null;
        if (array_key_exists('excludeConfidential', $filter)) {
            $excludeConfidential = $filter['excludeConfidential'];
        }
        if (array_key_exists('country', $filter)) {
            $country = $filter['country'];
        }
        if (array_key_exists('topNLatest', $filter)) {
            $topNLatest = $filter['topNLatest'];
        }
        if (array_key_exists('eventDatetimeStart', $filter)) {
            $eventDatetimeStart = $filter['eventDatetimeStart'];
        }
        if (array_key_exists('eventDatetimeStop', $filter)) {
            $eventDatetimeStop = $filter['eventDatetimeStop'];
        }
        if (array_key_exists('generalPlace', $filter)) {
            $generalPlace = $filter['generalPlace'];
        }
        if (array_key_exists('place', $filter)) {
            $generalPlace = null; //if a more specified place exists, us that one instead of the generalPlace
            $place = $filter['place'];
        }
        if (array_key_exists('stationstype', $filter)) {
            $stationstype = $filter['stationstype'];
        }
        if (array_key_exists('stnSeqno', $filter)) {
            $generalPlace = null; //if a station exists, us that instead of the generalPlace
            $place = null; //if a station exists, us that one instead of the place
            $stn = $filter['stnSeqno'];
        }
        if (array_key_exists('txnSeqno', $filter)) {
            $txn = $filter['txnSeqno'];
        }
        if (array_key_exists('osnTypeRef', $filter)) {
            $osnTypeRef = $filter['osnTypeRef'];
        }
        $osnType = null;
        if ($country) {
            $filterBuilder->andWhere('p1.name=:country or p2.name=:country or p3.name=:country or p4.name=:country');
            $filterBuilder->setParameter('country', $country);
        }
        if ($topNLatest) {
            $filterBuilder->orderBy('e.eventDatetime', 'DESC');
            $filterBuilder->setMaxResults($topNLatest);
        }
        if ($osnTypeRef !== null) {
            $osnType = $osnTypeRef->getRvLowValue();
        }
        if ($excludeConfidential) {
            $filterBuilder->andWhere('o.isconfidential is null');
        }
        if ($txn) {
            $filterBuilder->andWhere('t.canonicalName=:canonicalName');
            $filterBuilder->setParameter('canonicalName', $txn->getCanonicalName());
        }
        if ($osnType) {
            $filterBuilder->andWhere('cg1.rvLowValue=:osnType');
            $filterBuilder->setParameter('osnType', $osnType);
        }
        if ($eventDatetimeStart && $eventDatetimeStop) {
            $filterBuilder->andWhere('e.eventDatetime>=:eventDatetimeStart and e.eventDatetime<=:eventDatetimeStop');
            $filterBuilder->setParameter('eventDatetimeStart', $eventDatetimeStart);
            $filterBuilder->setParameter('eventDatetimeStop', $eventDatetimeStop);
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
        if ($stationstype) {
            $filterBuilder->andWhere('st.areaType=:areaType');
            $filterBuilder->setParameter('areaType', $stationstype);
        }
        if ($stn) {
            $filterBuilder->andWhere('o.stnSeqno=:stnSeqno');
            $filterBuilder->setParameter('stnSeqno', $stn);
        }

        if($fast){
            return $filterBuilder->getQuery()->getScalarResult();
        }
        else{
            return $filterBuilder->getQuery()->getResult();
        }
    }

    public function loadObservations($excludeConfidential, $excludeNonBelgian,$fast)
    {
        if($fast){
            $qb = $this->repo->getFastObservationsQb();
        }
        else{
            $qb = $this->repo->getCompleteObservationsQb();
        }
        if ($excludeConfidential) {
            $qb = $qb->andWhere('o.isconfidential is null');
        }
        if ($excludeNonBelgian) {
            $qb = $qb->andWhere("p1.name='BE' or p2.name='BE' or p3.name='BE' or p4.name='BE'");
        }
        if($fast){
            return $qb->getQuery()->getScalarResult();
        }
        else{
            return $qb->getQuery()->getResult();
        }
    }

    private function filterByStation($stations, $filterBuilder)
    {
        if (null !== $stations and count($stations) > 0) {
            $filterBuilder->andWhere('o.stnSeqno IN (:stations)');
            $filterBuilder->setParameter('stations', $stations);
        } else {
            $filterBuilder->andWhere("o.creUser='THISGIVESNORESULTS'");
        }
        return $filterBuilder;
    }
}