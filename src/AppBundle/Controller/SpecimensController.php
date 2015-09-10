<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Specimens;
use AppBundle\Entity\EventStates;
use AppBundle\Entity\Event2Persons;
use AppBundle\Entity\Spec2Events;
use AppBundle\Entity\EntityValues;
use AppBundle\Entity\ValueAssignable;
use AppBundle\Form\SpecimensType;
use AppBundle\ControllerHelper\SpecimenProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class SpecimensController extends Controller
{

    private $specimenRepo;


    /**
     * Deletes a Specimens entity.
     *
     * @Route("specimens/delete/{id}", name="mm_specimens_delete")
     * @Method("DELETE")
     */
    /*public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->specimenRepo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Specimens');
            $specimen = $this->loadSpecimen($id);
            if ($specimen->getEvents()->count()==0){
                $em->remove($specimen);
                $em->flush();
            }
            else{

            }

        }
        return $this->redirect($this->generateUrl('mm_observations_mgmtindex'));
    }*/

    /**
     * Creates a form to delete a Specimens entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    /*private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mm_specimens_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm();
    }*/

    public function loadSpecimen($id)
    {
        $specimen = $this->specimenRepo->find($id);
        if (!$specimen) {
            throw $this->createNotFoundException(sprintf('The specimen with seqno %s does not exist.', $id));
        }
        return $specimen;
    }

    public function editAction($id)
    {
        $this->specimenRepo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Specimens');
        $specimen = $this->loadSpecimen($id);
        //$deleteForm = $this->createDeleteForm($id);
        $form = $this->createForm(new SpecimensType($this->getDoctrine(), array('validation_groups' => array('SpecimenUpdate'))), $specimen);
        return $this->render('AppBundle:Page:edit-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'na',
            'id'=>$id,
            //'delete_form' => $deleteForm->createView()
        ));
    }

    public function updateAction(Request $request, $id)
    {
        $this->specimenRepo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Specimens');
        $specimen = $this->loadSpecimen($id);
        //$deleteForm = $this->createDeleteForm($id);
        $form = $this->createForm(new SpecimensType($this->getDoctrine(), array('validation_groups' => array('SpecimenUpdate'))), $specimen);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($specimen);
            $em->flush();
            return $this->redirect($this->generateUrl('mm_observations_mgmtindex'));
        }
        return $this->render('AppBundle:Page:edit-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'false',
            'id'=>$id,
            //'delete_form' => $deleteForm->createView()
        ));
    }

}
