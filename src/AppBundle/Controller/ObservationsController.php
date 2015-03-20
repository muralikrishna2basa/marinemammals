<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observations;
use AppBundle\Entity\EventStates;
use AppBundle\Entity\Event2Persons;
use AppBundle\Entity\Spec2Events;
use AppBundle\Entity\EntityValues;
use AppBundle\Entity\ValueAssignable;
use AppBundle\Form\ObservationsType;
use AppBundle\ControllerHelper\ObservationProvider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ObservationsController extends Controller
{

    /**
     * Deletes a Observations entity.
     *
     * @Route("/delete/{id}", name="mm_observations_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $keepSpecimen = $form->get('keepSpecimen')->getData();

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $observation = $this->get('observations_provider')->loadObservation($id);
            $event = $observation->getEseSeqno();
            $s2e = $event->getSpec2Events();
            $specimen = $s2e->getScnSeqno();
            $s2eColl = $specimen->getSpec2Events();

            $em->remove($observation);
            $em->remove($event);
            $em->remove($s2e);
            foreach ($s2e->getValues() as $ev) {
                $em->remove($ev);
            }
            //$s2e->removeAllValues();
            if ($s2eColl->count() > 1) {
                $keepSpecimen = true;
            }
            if (!$keepSpecimen) {
                $em->remove($specimen);
            }
            $em->flush();
        }
        return $this->redirect($this->generateUrl('mm_observations_mgmtindex'));
    }

    /**
     * Creates a form to delete a Observations entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mm_observations_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('keepSpecimen', 'checkbox', array('required' => false))
            ->getForm();
    }

    public function newAction()
    {
        $observation = $this->get('observations_provider')->prepareNewObservation();
        $form = $this->createForm(new ObservationsType($this->getDoctrine(), array('validation_groups' => array('ObservationCreation'))), $observation);
        return $this->render('AppBundle:Page:add-observations-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'na',
            'errors' => array()
        ));
    }

    public function createAction(Request $request)
    {
        $observation = $this->get('observations_provider')->prepareNewObservation();
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
            $observation2 = $this->get('observations_provider')->prepareNewObservation();
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

    public function editAction($id)
    {
        $observation = $this->get('observations_provider')->loadAndSupplementObservation($id);
        $deleteForm = $this->createDeleteForm($id);
        $form = $this->createForm(new ObservationsType($this->getDoctrine(), array('validation_groups' => array('ObservationModification'))), $observation);
        return $this->render('AppBundle:Page:edit-observations-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'na',
            'errors' => array(),
            'id' => $id,
            'delete_form' => $deleteForm->createView()
        ));
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();
        $observation = $this->get('observations_provider')->loadAndSupplementObservation($id);
        $event = $observation->getEseSeqno();
        $s2e = $event->getSpec2Events();
        $specimen = $s2e->getScnSeqno();

        $deleteForm = $this->createDeleteForm($id);
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
                return $this->redirect($this->generateUrl('mm_observations_mgmtindex'));
            } catch (\Doctrine\DBAL\DBALException $e) {
            }
            $msg = $e->getMessage();
            if (strpos($msg, 'ORA-02292') !== false && strpos($msg, 'SVE_S2E_FK') !== false) {
                //$regex = "/[a-zA-Z]+ (\d+)/";
                $patt = "/UPDATE SPEC2EVENTS SET SCN_SEQNO = \? WHERE SCN_SEQNO = \? AND ESE_SEQNO = \?' with params \[(\d+), \"?(\d+)\"?, \"?(\d+)\"?\]/";
                if (preg_match($patt, $msg, $matches)) {
                    $newScn = $matches[1];
                    $oldScn = $matches[2];
                    $ese = $matches[3];
                    $error = new FormError("It is not possible to replace specimen " . $oldScn . " with another (" . $newScn . ") as it has specimen values attached to it.");
                } else {
                    $error = new FormError("It is not possible to replace a specimen with another as it has specimen values attached to it.");
                }

            }
            else{
                $error =$e->getMessage();
            }
            $form->get('eseSeqno')->get('spec2events')->get('scnSeqnoExisting')->addError($error);
        }
        $errors = $form->getErrors(true, false);
        $errors2 = array();
        $errors2 = $this->getErrorList($errors, $errors2);

        return $this->render('AppBundle:Page:edit-observations-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'false',
            'errors' => $errors2,
            'id' => $id,
            'delete_form' => $deleteForm->createView()
        ));
    }

}
