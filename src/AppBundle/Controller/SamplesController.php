<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\RedirectResponse;
//use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

class SamplesController extends Controller
{
    public function indexOldAction()
    {

// legacy application configures session
        /*        ini_set('session.save_handler', 'files');
                ini_set('session.save_path', '/tmp');
                session_start();*/

// Get Symfony to interface with this existing session
        //$session = new Session(new PhpBridgeSessionStorage());

// symfony will now interface with the existing PHP session
        //$session->start();
        //return $this->forward()
        return $this->render('AppBundle::samples.html.php');
        //return new RedirectResponse('/legacy/Import.php',301);
    }

    private $repo;

    public function indexAction()
    {
        $this->repo = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Samples');
        $samples =  $this->repo->getFastSamples();
        return $this->render('AppBundle:Page:list-samples.html.twig', array(
            'samples'=>$samples
        ));
    }
}