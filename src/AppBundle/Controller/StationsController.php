<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Stations;
use AppBundle\Form\StationsType;
use AppBundle\Entity\Places;
use AppBundle\Form\PlacesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StationsController extends Controller
{

    public function newAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $stations = $em->getRepository('AppBundle:Stations')
            ->getAllStations();
        $station=new Stations();
        $sform   = $this->createForm(new StationsType($this->getDoctrine()), $station);

        $places = $em->getRepository('AppBundle:Places')
            ->getAllPlaces();
        $place=new Places();
        $pform   = $this->createForm(new PlacesType($this->getDoctrine()), $place);

        return $this->render('AppBundle:Page:add-stations.html.twig',array(
            'stations' => $stations,
            'sform'   => $sform->createView(),
            'places' => $places,
            'pform'   => $pform->createView()
        ));
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $stations = $em->getRepository('AppBundle:Stations')
            ->getAllStations();
        $station=new Stations();
        $sform   = $this->createForm(new StationsType($this->getDoctrine()), $station);

        $places = $em->getRepository('AppBundle:Places')
            ->getAllPlaces();
        $place=new Places();
        $pform   = $this->createForm(new PlacesType($this->getDoctrine()), $place);

        $sform->handleRequest($request);
        if ($sform->isValid()) {

            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($station);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        $pform->handleRequest($request);
        if ($pform->isValid()) {

            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($place);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('AppBundle:Page:add-stations.html.twig',array(
            'stations' => $stations,
            'sform'   => $sform->createView(),
            'places' => $places,
            'pform'   => $pform->createView()
        ));
    }

    protected function getInstitute($iteSeqno)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $institute = $em->getRepository('AppBundle:Institutes')->find($iteSeqno);

        if (!$institute) {
            throw $this->createNotFoundException('Unable to find Institute.');
        }

        return $institute;
    }
}
