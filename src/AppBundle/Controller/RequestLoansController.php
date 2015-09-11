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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

class RequestLoansController extends Controller
{

    public $localStorageDataKey = 'current-samples-request';
public $sampleRepo;
    public function viewCurrentAction(Request $request)
    {
        $currentUser = $this->getUser();
        $sampleRequest = $this->get('requestloans_provider')->prepareNewRequestLoan($currentUser);
        $currentRequest = json_decode($request->cookies->get($this->localStorageDataKey));

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

    public function createAction(Request $request)
    {
        $currentUser = $this->getUser();
        $sampleRequest = $this->get('requestloans_provider')->prepareNewRequestLoan($currentUser);
        $currentRequest = json_decode($request->cookies->get($this->localStorageDataKey));

        $this->sampleRepo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Samples');

        $sampleRequest->setDateRequest(new \DateTime('now'));
        $sampleRequest->setStatus(0);//pending
        foreach ($currentRequest->samples as $sample) {
            $seqno=$sample->seqno;
            $sample=$this->sampleRepo->findBySeqno($seqno);
            $sampleRequest->addSpeSeqno($sample);
        }
        if (isset($currentRequest->studyDescription)) {
            $sampleRequest->studyDescription = $currentRequest->studyDescription;
        }
        if (isset($currentRequest->p2rType)) {
            $sampleRequest->getSingleUser2Requests()->setP2rType($currentRequest->p2rType);
        }
        //$sampleRepo = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Samples');
        //$sample=$sampleRepo->findBySeqno(19233);
        //$request->addSpeSeqno($sample);

        $requests = $this->get('requestloans_provider')->loadUserRequests($currentUser);

        $form = $this->createForm(new RequestLoansType($this->getDoctrine()), $sampleRequest);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($sampleRequest);
            //$em->persist($observation);
            //$em->persist($s2e);

            $em->flush();

            //$request2 = $this->get('observations_provider')->prepareNewObservation();
            //$form2 = $this->createForm(new RequestLoansType($this->getDoctrine()));
            return $this->redirect($this->generateUrl('mm_samples_view'));
        }
        return $this->redirect($this->generateUrl('mm_samples_view'));
    }

}