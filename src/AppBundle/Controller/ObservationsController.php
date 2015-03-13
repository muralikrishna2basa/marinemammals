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

class ObservationsController extends Controller
{
    private function generalFilterAction(Request $request, $page, $excludeConfidential)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observations');

        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()));

        if ($request->query->has($form->getName())) {
            // manually bind values from the request
            $form->submit($request->query->get($form->getName()));
            if($excludeConfidential){
                $filterBuilder = $repo->getCompleteObservationsQbExcludeConfidential();
            }
            else{
                $filterBuilder = $repo->getCompleteObservationsQb();
            }
            $fd = $form->getData();
            $eventDatetimeStart = $fd['eventDatetimeStart'];
            $eventDatetimeStop = $fd['eventDatetimeStop'];
            $stationstype = $fd['stationstype'];
            $stn = $fd['stnSeqno'];
            $txn = $fd['txnSeqno'];
            $osnType = $fd['osnType'];
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
            //$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
            $q = $filterBuilder->getQuery();
            $filteredEntities = $q->getResult();

            $filteredAndPaginatedEntities = $this->paginate($filteredEntities);
            return $this->render('AppBundle:Page:list-observations.html.twig', array(
                'entities' => $filteredAndPaginatedEntities, 'form' => $form->createView()
            ));
        }
        $observations = $repo->getCompleteObservations();
        $paginatedEntities = $this->paginate($observations);
        return $this->render($page, array('entities' => $paginatedEntities, 'form' => $form->createView()));
    }

    private function generalIndexAction($page, $excludeConfidential){
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()));
        $q = $em->getRepository('AppBundle:Observations')
            ->getCompleteObservationsQb()->getQuery();
        $observations = $q->getResult();
        //$observations = $em->getRepository('AppBundle:Observations')->getCompleteObservations();
        $observations = $this->paginate($observations);
        return $this->render($page, array('entities' => $observations, 'form' => $form->createView()));
    }

    public function mgmtIndexAction()
    {
        return $this->generalIndexAction('AppBundle:Page:mgmt-list-observations.html.twig');
    }

    public function mgmtFilterAction(Request $request){
        return $this->generalFilterAction($request, 'AppBundle:Page:mgmt-list-observations.html.twig',false);
    }

    public function indexAction()
    {
        return $this->generalIndexAction('AppBundle:Page:list-observations.html.twig');
    }

    public function filterAction(Request $request){
        return $this->generalFilterAction($request, 'AppBundle:Page:list-observations.html.twig', true);
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

    public function newAction()
    {
        $observation = $this->prepareNewObservation();
        $form = $this->createForm(new ObservationsType($this->getDoctrine(), array('validation_groups' => array('ObservationCreation'))), $observation);
        return $this->render('AppBundle:Page:add-observations-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'na',
            'errors' => array()
        ));
    }

    public function createAction(Request $request)
    {
        $observation = $this->prepareNewObservation();
        $event = $observation->getEseSeqno();
        $s2e = $event->getSpec2Events();

        $form = $this->createForm(new ObservationsType($this->getDoctrine(), array('validation_groups' => array('ObservationCreation'))), $observation);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($event);
            $em->persist($observation);
            $em->persist($s2e);
            foreach ($observation->getValues() as $ov) {
                $this->persistOrRemoveEntityValue($ov, $observation);
            }
            foreach ($s2e->getValues() as $sv) {
                $this->persistOrRemoveEntityValue($sv, $s2e);
            }
            foreach ($event->getEvent2Persons() as $e2p) {
                $this->persistOrRemoveEvent2Persons($e2p, $event);
            }
            $em->flush();
            $observation2 = $this->prepareNewObservation();
            $form2 = $this->createForm(new ObservationsType($this->getDoctrine(), array('validation_groups' => array('ObservationCreation'))), $observation2);
            return $this->render('AppBundle:Page:add-observations-specimens.html.twig', array(
                'form' => $form2->createView(),
                'success' => 'true',
                'errors' => array()
            ));
        }

        $errors = $form->getErrors(true, false);
        $errors2 = array();
        $errors2 = $this->getErrorList($errors, $errors2);

        return $this->render('AppBundle:Page:add-observations-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'false',
            'errors' => $errors2
        ));
    }

    private function getErrorList(FormErrorIterator $fei, $return)
    {
        $parentFormName = $fei->getForm()->getName();
        foreach ($fei as $error) {
            $cl = get_class($error);
            //$current = $error->current();
            //if ($current->valid()) {
            if ($cl === 'Symfony\Component\Form\FormErrorIterator') {
                $return = $this->getErrorList($error, $return);
            } elseif ($cl === 'Symfony\Component\Form\FormError') {
                $message = $error->getMessage();
                if ($error->getCause() !== null) {
                    $property = $error->getCause()->getPropertyPath();
                } else {
                    $property = 'error_wo_propertypath';
                }
                $property = str_replace(".children", "", $property);
                $property = str_replace("children", $parentFormName, $property);
                $return[$property] = $message;
            }
            // }
        }
        return $return;
    }

    private function persistOrRemoveEntityValue(EntityValues $ev, ValueAssignable $va)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();
        if ($ev->getValue() === null) { //empty values are allowed
            $va->removeValue($ev);
            $em->remove($ev);
        } else {
            $em->persist($ev);
        }
    }

    private function persistOrRemoveEvent2Persons(Event2Persons $e2p, EventStates $e)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();
        if ($e2p->getPsnSeqno() === null) {
            $e->removeEvent2Persons($e2p);
            $em->remove($e2p);
        } else {
            $em->persist($e2p);
        }
    }

    private function prepareNewObservation()
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

        $evcfoc = new EntityValuesCollectionAtObservationCreation($this->getDoctrine()->getManager());

        $evcfoc->allObservationValues->supplementEntityValues($observation);

        $s2e = new Spec2Events();
        //$specimen=new Specimens();
        $event->setSpec2Events($s2e);
        //$s2e->setEseSeqno($event); //TODO: check if this can be deleted. shoudle be now that this is truly bidirectional
        //$s2e->setScnSeqno($specimen);

        $evcfoc->allSpecimenValues->supplementEntityValues($s2e);

        return $observation;
    }

    public function editAction($id)
    {
        $observation = $this->loadObservation($id);
        $form = $this->createForm(new ObservationsType($this->getDoctrine(), array('validation_groups' => array('ObservationModification'))), $observation);
        return $this->render('AppBundle:Page:edit-observations-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'na',
            'errors' => array(),
            'id' => $id
        ));
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();
        $observation = $this->loadObservation($id);
        $event = $observation->getEseSeqno();
        $s2e = $event->getSpec2Events();
        $specimen = $s2e->getScnSeqno();

        $form = $this->createForm(new ObservationsType($this->getDoctrine(), array('validation_groups' => array('ObservationModification'))), $observation);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($event);
            $em->persist($observation);
            $em->persist($s2e);
            foreach ($observation->getValues() as $ov) {
                $this->persistOrRemoveEntityValue($ov, $observation);
            }
            foreach ($s2e->getValues() as $sv) {
                $this->persistOrRemoveEntityValue($sv, $s2e);
            }
            foreach ($event->getEvent2Persons() as $e2p) {
                $this->persistOrRemoveEvent2Persons($e2p, $event);
            }
            try {
                $em->flush();
                return $this->indexAction();
            } catch (\Doctrine\DBAL\DBALException $e) {
            }
            $msg = $e->getMessage();
            if (strpos($msg, 'ORA-02292') !== false && strpos($msg, 'SVE_S2E_FK') !== false) {
                //$regex = "/[a-zA-Z]+ (\d+)/";
                $patt="/UPDATE SPEC2EVENTS SET SCN_SEQNO = \? WHERE SCN_SEQNO = \? AND ESE_SEQNO = \?' with params \[(\d+), \"?(\d+)\"?, \"?(\d+)\"?\]/";
                if(preg_match($patt, $msg, $matches)){
                    $newScn=$matches[1];
                    $oldScn=$matches[2];
                    $ese=$matches[3];
                    $error = new FormError("It is not possible to replace specimen ".$oldScn." with another (".$newScn.") as it has specimen values attached to it.");
                }
                else{
                    $error = new FormError("It is not possible to replace a specimen with another as it has specimen values attached to it.");
                }
                $form->get('eseSeqno')->get('spec2events')->get('scnSeqnoExisting')->addError($error);
            }

        }
        $errors = $form->getErrors(true, false);
        $errors2 = array();
        $errors2 = $this->getErrorList($errors, $errors2);

        return $this->render('AppBundle:Page:edit-observations-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'false',
            'errors' => $errors2,
            'id' => $id
        ));
    }

    private function loadObservation($id)
    {
        $observation = $this->getDoctrine()->getRepository('AppBundle:Observations')->find($id);
        $evc = new EntityValuesCollectionAtObservationUpdate($this->getDoctrine()->getManager());
        $evc->allObservationValues->supplementEntityValues($observation);
        $s2e = $observation->getEseSeqno()->getSpec2Events();
        $evc->allSpecimenValues->supplementEntityValues($s2e);

        if (!$observation) {
            throw $this->createNotFoundException(sprintf('This observation does not exist: %s', $id));
        }
        return $observation;
    }
}
