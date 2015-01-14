<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observations;
use AppBundle\Entity\ObservationValues;
use AppBundle\Entity\EventStates;
use AppBundle\Entity\Spec2Events;
use AppBundle\Entity\Specimens;
use AppBundle\Entity\SpecimenValues;
use AppBundle\Entity\EntityValues;
use AppBundle\Entity\ValueAssignable;
use AppBundle\Form\ObservationsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ObservationsController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $observations = $em->getRepository('AppBundle:Observations')
            ->getCompleteObservation();

        return $this->render('AppBundle:Page:list-observations.html.twig',array(
            'observations' => $observations,
        ));
    }

    public function newAction()
    {
        $observation=new Observations();
        $event=new EventStates();
        $observation->setEseSeqno($event);

        $wdOv=$this->instantiateObservationValues('Wind direction',$observation);
        $wsOv=$this->instantiateObservationValues('Wind speed',$observation);
        $ssOv=$this->instantiateObservationValues('Seastate',$observation);

        $s2e=new Spec2Events();
        $specimen=new Specimens();
        $event->setSpec2event($s2e);
        $s2e->setEseSeqno($event);
        $s2e->setScnSeqno($specimen);

        $biSv=$this->instantiateSpecimenValues('Before intervention',$s2e);
        $diSv=$this->instantiateSpecimenValues('During intervention',$s2e);
        $cSv=$this->instantiateSpecimenValues('Collection',$s2e);
        $dcSv=$this->instantiateSpecimenValues('Decomposition Code',$s2e);
        $blPm=$this->instantiateSpecimenValues('Body length',$s2e);
        $bwPm=$this->instantiateSpecimenValues('Body weight',$s2e);
        $aPm=$this->instantiateSpecimenValues('Age',$s2e);
        $nsPm=$this->instantiateSpecimenValues('Nutritional Status',$s2e);

        $form   = $this->createForm(new ObservationsType($this->getDoctrine()), $observation);
        return $this->render('AppBundle:Page:add-observations-specimens.html.twig',array(
            'form'   => $form->createView()
        ));
    }

    private function instantiateObservationValues($pmName,&$observation){
        $em = $this->getDoctrine()->getManager();
        $pm = $em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName($pmName);
        $ov=new ObservationValues();
        $ov->setPmdSeqno($pm);
        $ov->setEseSeqno($observation);
        $observation->getValues()->add($ov);
        return $ov;
    }

    private function instantiateSpecimenValues($pmName,&$s2e){
        $em = $this->getDoctrine()->getManager();
        $pm = $em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName($pmName);
        $sv=new SpecimenValues();
        $sv->setPmdSeqno($pm);
        $sv->setS2eScnSeqno($s2e);
        $s2e->getValues()->add($sv);
        return $sv;
    }

    private function persistOrRemoveObservationValues($ov,$observation){
        $em = $this->getDoctrine()
            ->getEntityManager();
        if($ov->getValue() ==='' or $ov->getValue() === null){
            $observation->removeValue($ov);
            $em->remove($ov);
        }
        else{
            $em->persist($ov);
        }
    }

    private function persistOrRemoveSpecimenValues($sv,$s2e){
        $em = $this->getDoctrine()
            ->getEntityManager();
        if($sv->getValue() ==='' or $sv->getValue() === null){
            $s2e->removeValue($sv);
            $em->remove($sv);
        }
        else{
            $em->persist($sv);
        }
    }

    private function persistOrRemoveEntityValue(EntityValues $ev,ValueAssignable $va){
        $em = $this->getDoctrine()
            ->getEntityManager();
        if($ev->getValue() ==='' or $ev->getValue() === null){
            $va->removeValue($ev);
            $em->remove($ev);
        }
        else{
            $em->persist($ev);
        }
    }

    public function createAction(Request $request)
    {
        $observation=new Observations();
        $event=new EventStates();
        $observation->setEseSeqno($event);

        $wdOv=$this->instantiateObservationValues('Wind direction',$observation);
        $wsOv=$this->instantiateObservationValues('Wind speed',$observation);
        $ssOv=$this->instantiateObservationValues('Seastate',$observation);

        $s2e=new Spec2Events();
        $specimen=new Specimens();
        $event->setSpec2event($s2e);
        $s2e->setEseSeqno($event);
        $s2e->setScnSeqno($specimen);

        $biSv=$this->instantiateSpecimenValues('Before intervention',$s2e);
        $diSv=$this->instantiateSpecimenValues('During intervention',$s2e);
        $cSv=$this->instantiateSpecimenValues('Collection',$s2e);
        $dcSv=$this->instantiateSpecimenValues('Decomposition Code',$s2e);
        $blPm=$this->instantiateSpecimenValues('Body length',$s2e);
        $bwPm=$this->instantiateSpecimenValues('Body weight',$s2e);
        $aPm=$this->instantiateSpecimenValues('Age',$s2e);
        $nsPm=$this->instantiateSpecimenValues('Nutritional Status',$s2e);

        $form   = $this->createForm(new ObservationsType($this->getDoctrine()), $observation);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($event);
            $em->persist($observation);
            $this->persistOrRemoveEntityValue($wdOv,$observation);
            $this->persistOrRemoveEntityValue($wsOv,$observation);
            $this->persistOrRemoveEntityValue($ssOv,$observation);
            $em->persist($specimen);
            $em->persist($s2e);
            $this->persistOrRemoveEntityValue($biSv,$s2e);
            $this->persistOrRemoveEntityValue($diSv,$s2e);
            $this->persistOrRemoveEntityValue($cSv,$s2e);
            $this->persistOrRemoveEntityValue($dcSv,$s2e);
            $this->persistOrRemoveEntityValue($blPm,$s2e);
            $this->persistOrRemoveEntityValue($bwPm,$s2e);
            $this->persistOrRemoveEntityValue($aPm,$s2e);
            $this->persistOrRemoveEntityValue($nsPm,$s2e);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('AppBundle:Page:add-observations-specimens.html.twig',array(
            'form'   => $form->createView()
        ));
    }
}
