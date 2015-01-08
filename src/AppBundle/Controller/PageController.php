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
    
    public function aboutAction()
    {
    	return $this->render('AppBundle:Page:about.html.twig');
    }

}