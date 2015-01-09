<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observations;
use AppBundle\Entity\ObservationValues;
use AppBundle\Entity\EventStates;
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

        $em = $this->getDoctrine()->getManager();

        $wdPm = $em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName('Wind direction');
        $wsPm = $em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName('Wind speed');
        $ssPm = $em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName('Seastate');

        $wdOv=new ObservationValues();
        $wdOv->setPmdSeqno($wdPm);
        $wdOv->setEseSeqno($observation);
        $observation->getObservationValues($wdOv)->add($wdOv);

        \Doctrine\Common\Util\Debug::dump($wdOv);

        $wsOv=new ObservationValues();
        $wsOv->setPmdSeqno($wsPm);
        $wsOv->setEseSeqno($observation);
        $observation->getObservationValues($wdOv)->add($wsOv);

        $ssOv=new ObservationValues();
        $ssOv->setPmdSeqno($ssPm);
        $ssOv->setEseSeqno($observation);
        $observation->getObservationValues($wdOv)->add($ssOv);

        $form   = $this->createForm(new ObservationsType($this->getDoctrine()), $observation);
        return $this->render('AppBundle:Page:add-observations.html.twig',array(
            'form'   => $form->createView()
        ));
    }

    public function createAction(Request $request)
    {
        $observation=new Observations();
        $event=new EventStates();

        $em = $this->getDoctrine()->getManager();

        $wdPm = $em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName('Wind direction');
        $wsPm = $em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName('Wind speed');
        $ssPm = $em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName('Seastate');

        $wdOv=new ObservationValues();
        $wdOv->setPmdSeqno($wdPm);
        $wdOv->setEseSeqno($observation);

        $wsOv=new ObservationValues();
        $wsOv->setPmdSeqno($wsPm);
        $wsOv->setEseSeqno($observation);

        $ssOv=new ObservationValues();
        $ssOv->setPmdSeqno($ssPm);
        $ssOv->setEseSeqno($observation);

        $observation->setEseSeqno($event);
        $form   = $this->createForm(new ObservationsType($this->getDoctrine()), $observation);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($event);
            $em->persist($observation);
            $em->persist($wdOv);
            $em->persist($wsOv);
            $em->persist($ssOv);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('AppBundle:Page:add-observations.html.twig',array(
            'form'   => $form->createView()
        ));
    }
}
