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

        $extpath1=$this->instantiateSpecimenValues('Fresh external lesions::Fresh bite marks',$s2e);
        $extpath2=$this->instantiateSpecimenValues('Fresh external lesions::Opened abdomen',$s2e);
        $extpath3=$this->instantiateSpecimenValues('Fresh external lesions::Stabbing wound',$s2e);
        $extpath4=$this->instantiateSpecimenValues('Fresh external lesions::Parallel cuts',$s2e);
        $extpath5=$this->instantiateSpecimenValues('Fresh external lesions::Broken bones',$s2e);
        $extpath6=$this->instantiateSpecimenValues('Fresh external lesions::Hypothema',$s2e);
        $extpath7=$this->instantiateSpecimenValues('Fresh external lesions::Fin amputation',$s2e);
        $extpath8=$this->instantiateSpecimenValues('Fresh external lesions::Encircling lesion',$s2e);
        $extpath15=$this->instantiateSpecimenValues('Fresh external lesions::Other fresh external lesions',$s2e);
        $extpath9=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Tail',$s2e);
        $extpath10=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Pectoral fin',$s2e);
        $extpath11=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Snout',$s2e);
        $extpath12=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Mouth',$s2e);
        $extpath13=$this->instantiateSpecimenValues('Fresh external lesions::Scavenger traces::Picks',$s2e);
        $extpath14=$this->instantiateSpecimenValues('Fresh external lesions::Scavenger traces::Bites',$s2e);
        $extpath16=$this->instantiateSpecimenValues('Healing/healed lesions::Bites',$s2e);
        $extpath17=$this->instantiateSpecimenValues('Healing/healed lesions::Pox-like lesions',$s2e);
        $extpath18=$this->instantiateSpecimenValues('Healing/healed lesions::Open warts',$s2e);
        $extpath19=$this->instantiateSpecimenValues('Healing/healed lesions::Cuts',$s2e);
        $extpath20=$this->instantiateSpecimenValues('Healing/healed lesions::Line/net impressions',$s2e);
        $extpath21=$this->instantiateSpecimenValues('Fishing activities::Static gear on beach nearby',$s2e);
        $extpath22=$this->instantiateSpecimenValues('Fishing activities::Static gear at sea nearby',$s2e);
        $extpath23=$this->instantiateSpecimenValues('Other characteristics::External parasites',$s2e);
        $extpath24=$this->instantiateSpecimenValues('Other characteristics::Froth from airways',$s2e);
        $extpath25=$this->instantiateSpecimenValues('Other characteristics::Fishy smell',$s2e);
        $extpath26=$this->instantiateSpecimenValues('Other characteristics::Prey remains in mouth',$s2e);
        $extpath27=$this->instantiateSpecimenValues('Other characteristics::Remains of nets, ropes, plastic, etc.',$s2e);
        $extpath28=$this->instantiateSpecimenValues('Other characteristics::Oil remains on skin',$s2e);
        $extpath29=$this->instantiateSpecimenValues('Nutritional condition',$s2e);
        $extpath30=$this->instantiateSpecimenValues('Stomach Content',$s2e);
        $extpath31=$this->instantiateSpecimenValues('Other remarks',$s2e);

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

    //do this in a handler
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
        //$specimen=new Specimens();
        $event->setSpec2event($s2e);
        $s2e->setEseSeqno($event);
        //$s2e->setScnSeqno($specimen);

        $biSv=$this->instantiateSpecimenValues('Before intervention',$s2e);
        $diSv=$this->instantiateSpecimenValues('During intervention',$s2e);
        $cSv=$this->instantiateSpecimenValues('Collection',$s2e);
        $dcSv=$this->instantiateSpecimenValues('Decomposition Code',$s2e);
        $blPm=$this->instantiateSpecimenValues('Body length',$s2e);
        $bwPm=$this->instantiateSpecimenValues('Body weight',$s2e);
        $aPm=$this->instantiateSpecimenValues('Age',$s2e);
        $nsPm=$this->instantiateSpecimenValues('Nutritional Status',$s2e);

        $extpath1=$this->instantiateSpecimenValues('Fresh external lesions::Fresh bite marks',$s2e);
        $extpath2=$this->instantiateSpecimenValues('Fresh external lesions::Opened abdomen',$s2e);
        $extpath3=$this->instantiateSpecimenValues('Fresh external lesions::Stabbing wound',$s2e);
        $extpath4=$this->instantiateSpecimenValues('Fresh external lesions::Parallel cuts',$s2e);
        $extpath5=$this->instantiateSpecimenValues('Fresh external lesions::Broken bones',$s2e);
        $extpath6=$this->instantiateSpecimenValues('Fresh external lesions::Hypothema',$s2e);
        $extpath7=$this->instantiateSpecimenValues('Fresh external lesions::Fin amputation',$s2e);
        $extpath8=$this->instantiateSpecimenValues('Fresh external lesions::Encircling lesion',$s2e);
        $extpath15=$this->instantiateSpecimenValues('Fresh external lesions::Other fresh external lesions',$s2e);
        $extpath9=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Tail',$s2e);
        $extpath10=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Pectoral fin',$s2e);
        $extpath11=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Snout',$s2e);
        $extpath12=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Mouth',$s2e);
        $extpath13=$this->instantiateSpecimenValues('Fresh external lesions::Scavenger traces::Picks',$s2e);
        $extpath14=$this->instantiateSpecimenValues('Fresh external lesions::Scavenger traces::Bites',$s2e);
        $extpath16=$this->instantiateSpecimenValues('Healing/healed lesions::Bites',$s2e);
        $extpath17=$this->instantiateSpecimenValues('Healing/healed lesions::Pox-like lesions',$s2e);
        $extpath18=$this->instantiateSpecimenValues('Healing/healed lesions::Open warts',$s2e);
        $extpath19=$this->instantiateSpecimenValues('Healing/healed lesions::Cuts',$s2e);
        $extpath20=$this->instantiateSpecimenValues('Healing/healed lesions::Line/net impressions',$s2e);
        $extpath21=$this->instantiateSpecimenValues('Fishing activities::Static gear on beach nearby',$s2e);
        $extpath22=$this->instantiateSpecimenValues('Fishing activities::Static gear at sea nearby',$s2e);
        $extpath23=$this->instantiateSpecimenValues('Other characteristics::External parasites',$s2e);
        $extpath24=$this->instantiateSpecimenValues('Other characteristics::Froth from airways',$s2e);
        $extpath25=$this->instantiateSpecimenValues('Other characteristics::Fishy smell',$s2e);
        $extpath26=$this->instantiateSpecimenValues('Other characteristics::Prey remains in mouth',$s2e);
        $extpath27=$this->instantiateSpecimenValues('Other characteristics::Remains of nets, ropes, plastic, etc.',$s2e);
        $extpath28=$this->instantiateSpecimenValues('Other characteristics::Oil remains on skin',$s2e);
        $extpath29=$this->instantiateSpecimenValues('Nutritional condition',$s2e);
        $extpath30=$this->instantiateSpecimenValues('Stomach Content',$s2e);
        $extpath31=$this->instantiateSpecimenValues('Other remarks',$s2e);

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
            //$em->persist($specimen);
            $em->persist($s2e);
            foreach($s2e->getValues() as $sv) {
                $this->persistOrRemoveEntityValue($sv,$s2e);
            }
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('AppBundle:Page:add-observations-specimens.html.twig',array(
            'form'   => $form->createView()
        ));
    }
}
