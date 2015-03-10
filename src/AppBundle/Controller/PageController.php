<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Page:index.html.twig');
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