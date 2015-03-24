<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        $filter['excludeConfidential']=true;
        $filter['country']='BE';
        $filter['topNLatest']=10;

        $observations = $this->get('observations_provider')->loadObservationsByFilter($filter);
        return $this->render('AppBundle:Page:index.html.twig', array(
            'observations'=>$observations
        ));
    }

    public function aboutObservationsAction()
    {
    	return $this->render('AppBundle:Page:about-observations.html.twig');
    }

    public function aboutNecropsiesAction()
    {
        return $this->render('AppBundle:Page:about-necropsies.html.twig');
    }

}