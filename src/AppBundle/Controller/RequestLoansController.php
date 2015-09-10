<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use AppBundle\Form\RequestLoansType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

use AppBundle\ControllerHelper\Paginator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

class RequestLoansController extends Controller
{
    public function viewCurrentAction(Request $request)
    {

        $currentUser = $this->getUser();
        $sampleRequest = $this->get('requestloans_provider')->prepareNewRequestLoan($currentUser);

        $currentRequest = json_decode($request->cookies->get('current-samples-request'));

        /*foreach($currentRequest->samples as $seqno=>$samplestats){
            $sample=$this->sampleRepo->findBySeqno($seqno);
            $sampleRequest->addSpeSeqno($sample);
        }*/

        if (isset($currentRequest->studyDescription)) {
            $sampleRequest->studyDescription = $currentRequest->studyDescription;
        }
        if (isset($currentRequest->p2rType)) {
            $sampleRequest->p2rType = $currentRequest->p2rType;
        }

        $requests = $this->get('requestloans_provider')->loadUserRequests($currentUser);
        $form = $this->createForm(new RequestLoansType($this->getDoctrine()), $sampleRequest);
        return $this->render('AppBundle:Bare:add-edit-requests.html.twig', array(
            'previous_requests' => $requests, 'request' => $sampleRequest, 'currentRequest' => $currentRequest, 'request_form' => $form->createView()
        ));

       // return $this->render('AppBundle:Page:ajax-add-requests.html.twig', array('currentRequest' => $currentRequest));

    }

    public function viewAction($id)
    {

    }


    public function createAction()
    {
        /*$currentUser = $this->getUser();
        $request = $this->get('requestloans_provider')->prepareNewRequestLoan($currentUser);
        $requests = $this->get('requestloans_provider')->loadUserRequests($currentUser);

        //$sampleRepo = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Samples');
        //$sample=$sampleRepo->findBySeqno(19233);
        //$request->addSpeSeqno($sample);
        return $this->render('AppBundle:Page:add-edit-requests.html.twig', array(
            'previous_requests' => $requests, 'request' => $request));*/
    }

}