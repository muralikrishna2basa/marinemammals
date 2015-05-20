<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\RequestLoansType;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

use AppBundle\ControllerHelper\Paginator;


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

    private $sampleRepo;

    public function indexAction()
    {

        $this->sampleRepo = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Samples');
        //order of items from database
        $order_by = array();
        //Using custom made database query function in LanguageRepository class
        $samplesCount = $this->sampleRepo->getSamplesCount();
        //When creating new paginator object it takes care for pages and items
        //organization based on numbers of items from database and limit variable in $_GET

        $paginator = new Paginator($samplesCount);
        //get returned HTML string from Paginator to render paginator HTML
        //elements in the template
        $strPaginator = $paginator->RenderPaginator();

        //If we have POST variable defined, than it is defined order of items
        //from inside form (clicking on sorting column for example)
        if ('POST' === $this->get('request')->getMethod()) {
            $order_by = array($_POST['filter_order'] => $_POST['filter_order_Dir']);
            $sort_direction = $_POST['filter_order_Dir'] == 'asc' ? 'desc' : 'asc';
        } else {
            //We know that nothing is changed for ordering columns -
            //this is alse default order of items when page is first opened
            //$order_by = array('sort_order' => 'asc', 'seqno' => 'asc');
            $sort_direction = 'desc';
        }
        //To fill $languages for forwarding it to the template, we first call database function
        //with $offset and $limit to get items we wanted
        $samples = $this->sampleRepo->getSamplesListWithPagination($order_by, $paginator->getOffset(), $paginator->getLimit());
        //Finally - return array to templating engine for displaying data.
        //return array('samples' => $samples, 'sort_dir' => $sort_direction, 'paginator' => $strPaginator);

        $currentUser = $this->getUser();
        $request = $this->get('requestloans_provider')->prepareNewRequestLoan($currentUser);

        $sample=$this->sampleRepo->findBySeqno(19233);
        $request->addSpeSeqno($sample);

        $requests = $this->get('requestloans_provider')->loadUserRequests($currentUser);
        $form = $this->createForm(new RequestLoansType($this->getDoctrine()), $request);

        return $this->render('AppBundle:Page:list-samples.html.twig', array(
            'samples' => $samples, 'sort_dir' => $sort_direction, 'paginator_html' => $strPaginator, 'paginator' => $paginator, 'previous_requests' => $requests, 'request' => $request, 'request_form' => $form->createView()
        ));
    }
}