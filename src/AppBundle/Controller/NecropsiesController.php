<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

class NecropsiesController extends Controller
{
    public function neweditAction()
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
        return $this->render('AppBundle:Legacy:import.html.php');
        //return new RedirectResponse('/legacy/Import.php',301);
    }
}