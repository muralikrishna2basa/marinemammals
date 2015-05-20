<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use AppBundle\Entity\RequestLoans;
use AppBundle\Entity\User2Requests;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/*use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;*/

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

use AppBundle\ControllerHelper\Paginator;


class RequestLoansController extends Controller
{
    public function indexAction()
    {
        $currentUser = $this->getUser();
        $request = $this->get('requestloans_provider')->prepareNewRequestLoan($currentUser);
        $requests = $this->get('requestloans_provider')->loadUserRequests($currentUser);

        $sampleRepo = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Samples');
        $sample=$sampleRepo->findBySeqno(19233);
        $request->addSpeSeqno($sample);
        return $this->render('AppBundle:Page:add-edit-requests.html.twig', array(
            'previous_requests' => $requests, 'request' => $request));
    }
}