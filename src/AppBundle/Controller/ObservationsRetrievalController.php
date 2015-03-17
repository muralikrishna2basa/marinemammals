<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observations;
use AppBundle\Entity\ObservationValues;
use AppBundle\Entity\EventStates;
use AppBundle\Entity\Event2Persons;
use AppBundle\Entity\Spec2Events;
use AppBundle\Entity\SpecimenValues;
use AppBundle\Entity\EntityValues;
use AppBundle\Entity\ValueAssignable;
use AppBundle\Form\ObservationsType;
use AppBundle\Form\Filter\ObservationsFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\DateTime;

class ObservationsRetrievalController extends Controller
{
    private function getFilteredObservations($filter, $excludeConfidential, $excludeNonBelgian)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observations');
        $filterBuilder = $repo->getCompleteObservationsQb();

        $eventDatetimeStart = $filter['eventDatetimeStart'];
        $eventDatetimeStop = $filter['eventDatetimeStop'];
        $stationstype = $filter['stationstype'];
        $stn = $filter['stnSeqno'];
        $txn = $filter['txnSeqno'];
        $osnType = $filter['osnType'];
        $generalPlace = $filter['generalPlace'];
        $place = $filter['place'];
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
        if ($place) {
            $stations = $this->getDoctrine()
                ->getEntityManager()->getRepository('AppBundle:Stations')
                ->getAllStationsBelongingToPlaceQb($place)->getQuery()->getResult();
            $this->filterByStation($stations, $filterBuilder);
        }
        if ($generalPlace) {
            $stations = $this->getDoctrine()
                ->getEntityManager()->getRepository('AppBundle:Stations')
                ->getAllStationsBelongingToPlaceDeepQb($generalPlace)->getQuery()->getResult();
            $this->filterByStation($stations, $filterBuilder);
        }

        $observations = $filterBuilder->getQuery()->getResult();

        if ($excludeConfidential) {
            $observations = $this->excludeConfidentialObservations($observations);
        }

        if ($excludeNonBelgian) {
            $observations = $this->excludeNonBelgianObservations($observations);
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

    private function getIndexOfObservations($excludeConfidential, $excludeNonBelgian)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observations');
        $observations = $repo->getCompleteObservationsQb()->getQuery()->getResult();

        if ($excludeConfidential) {
            $observations = $this->excludeConfidentialObservations($observations);
        }
        if ($excludeNonBelgian) {
            $observations = $this->excludeNonBelgianObservations($observations);
        }
        return $observations;
    }

    private function generalFilterAction(Request $request, $page, $excludeConfidential, $excludeNonBelgian, $ps)
    {
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()), null, array('hasCountryDropdown' => !$excludeNonBelgian));
        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));
            $filter = $form->getData();
            $observations = $this->getFilteredObservations($filter, $excludeConfidential, $excludeNonBelgian);
            if ($request->query->has('export')) {
                $results = array();
                foreach ($observations as $o) {
                    array_push($results,$ps->toArray($o));
                }
                return $this->export($results);
            } elseif ($request->query->has('submit')) {
                return $this->generalIndexAction($page, $form, $observations);
            }
        }
        /*$observations = $this->getIndexOfObservations($excludeConfidential, $excludeNonBelgian);
        return $this->generalIndexAction($page, $form, $observations);*/
    }

    private function generalIndexAction($page, $form, $observations)
    {
        $observations = $this->paginate($observations);
        return $this->render($page, array('entities' => $observations, 'form' => $form->createView()));
    }

    public function mgmtIndexAction()
    {
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()), null, array('hasCountryDropdown' => true));
        $observations = $this->getIndexOfObservations(false, false);
        return $this->generalIndexAction('AppBundle:Page:mgmt-list-observations.html.twig', $form, $observations);
    }

    public function mgmtFilterAction(Request $request)
    {
        $ps = new MgmtObservationIndexPropertiesSet();
        return $this->generalFilterAction($request, 'AppBundle:Page:mgmt-list-observations.html.twig', false, false, $ps);
    }

    public function indexAction()
    {
        $observations = $this->getIndexOfObservations(true, true);
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()), null, array('hasCountryDropdown' => false));
        return $this->generalIndexAction('AppBundle:Page:list-observations.html.twig', $form, $observations);
    }

    public function filterAction(Request $request)
    {
        $ps = new ObservationIndexPropertiesSet();
        return $this->generalFilterAction($request, 'AppBundle:Page:list-observations.html.twig', true, true, $ps);
    }

    public function export($results)
    {
        $today = new \DateTime();
        $todayString=$today->format('Y-m-d');

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        $phpExcelObject->getProperties()->setCreator("Belgian Marine Data Center")
            ->setLastModifiedBy("Belgian Marine Data Center")
            ->setTitle("Marine Mammals export ".$todayString)
            ->setSubject("Occurence data of Belgian marine mammals")
            ->setDescription("An export of the Belgian marine mammals database, located at www.marinemammals.be");
        $phpExcelObject->setActiveSheetIndex(0);
        foreach ($results as $i=>$row) {
            $startCell='A'.($i+2);
            if($i==0){
                $keys=array_keys($row);
                $phpExcelObject->getActiveSheet()->fromArray($keys, NULL, 'A1');
            }
             $phpExcelObject->getActiveSheet()->fromArray($row, NULL, $startCell);
        }
        $phpExcelObject->getActiveSheet()->setTitle('export ' .$todayString);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=mm_export_'.$todayString.'.xlsx');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    private function paginate($array)
    {
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $array,
            $this->get('request')->query->get('page', 1)/*page number*/,
            500/*limit per page*/
        );
        return $pagination;
    }
}
