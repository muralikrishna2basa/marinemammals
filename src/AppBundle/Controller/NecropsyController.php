<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Necropsies;
use AppBundle\Entity\LesionValues;
use AppBundle\Entity\EventStates;
use AppBundle\Entity\Event2Persons;
use AppBundle\Entity\Spec2Events;
use AppBundle\Entity\SpecimenValues;
use AppBundle\Entity\EntityValues;
use AppBundle\Entity\ValueAssignable;
//use AppBundle\Form\NecropsiesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

class NecropsyController extends Controller
{

    public function newAction()
    {
        $necropsy = $this->prepareNewNecropsy();
        $form = null; //$this->createForm(new NecropsiesType($this->getDoctrine(), $necropsy);
        return $this->render('AppBundle:Page:add-necropsies-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'na',
            'errors' => array()
        ));
    }

    public function createAction(Request $request)
    {
    }

    private function persistOrRemoveEntityValue(EntityValues $ev, ValueAssignable $va)
    {
        $em = $this->getDoctrine()
            ->getManager();
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
            ->getManager();
        if ($e2p->getPsnSeqno() === null) {
            $e->removeEvent2Persons($e2p);
            $em->remove($e2p);
        } else {
            $em->persist($e2p);
        }
    }

    private function prepareNewNecropsy()
    {
        $necropsy = new Necropsies();
        $event = new EventStates();
        $necropsy->setEseSeqno($event);

       // $necropsyEntityValuesCollection = new EntityValuesCollectionAtNecropsyCreation($this->getDoctrine()->getManager());

        $s2e = new Spec2Events();
        $event->setSpec2Events($s2e);

        //$necropsyEntityValuesCollection->allSpecimenValues->supplementEntityValues($s2e);
        //$necropsyEntityValuesCollection->allLesionValues->supplementEntityValues($s2e);

        return $necropsy;
    }
}
