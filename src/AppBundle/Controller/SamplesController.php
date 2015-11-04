<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\RequestLoansType;
use AppBundle\Form\Filter\SamplesFilterType;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

use AppBundle\ControllerHelper\Paginator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

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

    private function generalIndexAction(Request $request, $form)
    {
        $filter = $form->getData();
        $currentUser = $this->getUser();
        $sampleRequest = $this->get('requestloans_provider')->prepareNewRequestLoan($currentUser);
        $currentRequest = json_decode($request->cookies->get('current-samples-request'));
        if ($currentRequest != null) {
            if (!array_key_exists('samples', $currentRequest)) {
                $i = 0;
                $currentRequest['samples'] = null;
                foreach ($currentRequest as $sample) {
                    $currentRequest['samples'][$i] = $sample;
                    unset($currentRequest[$i]);
                    $i++;
                }
            }
        }
        $requests = $this->get('requestloans_provider')->loadUserRequests($currentUser);
        $requestForm = $this->createForm(new RequestLoansType($this->getDoctrine()), $sampleRequest);


        $this->sampleRepo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Samples');
        $order_by = array();

        $qb = $this->sampleRepo->getPartialSamplesQb();
        $qb = $this->get('samples_provider')->extendQbByFilter($qb, $filter);

        $samplesCount = $this->sampleRepo->getSamplesCountByQb($qb);
        $paginator = new Paginator($samplesCount, 1);

        $qb = $this->sampleRepo->getPartialSamplesQb();
        $qb = $this->get('samples_provider')->extendQbByFilter($qb, $filter);

        if ('POST' === $this->get('request')->getMethod()) {
            $order_by = array($_POST['filter_order'] => $_POST['filter_order_Dir']);
            $sort_direction = $_POST['filter_order_Dir'] == 'asc' ? 'desc' : 'asc';
        } else {
            $sort_direction = 'desc';
        }

        $qb = $this->get('samples_provider')->extendQbByPagination($qb, $order_by, $paginator->getOffset(), $paginator->getLimit(), $filter);

        $samples = $qb->getQuery()->getScalarResult();


        if (isset($currentRequest->studyDescription)) {
            $sampleRequest->studyDescription = $currentRequest->studyDescription;
        }
        if (isset($currentRequest->p2rType)) {
            $sampleRequest->p2rType = $currentRequest->p2rType;
        }

        $strPaginator = $paginator->RenderPaginator('samplefilterform');

        return $this->render('AppBundle:Page:list-samples.html.twig', array(
            'samples' => $samples, 'sort_dir' => $sort_direction, 'paginator_html' => $strPaginator, 'paginator' => $paginator, 'previous_requests' => $requests, 'request' => $sampleRequest, 'currentRequest' => $currentRequest, 'request_form' => $requestForm->createView(), 'filter_form' => $form->createView()
        ));
    }


    public function indexAction(Request $request)
    {
        $filterForm = $this->createForm(new SamplesFilterType($this->getDoctrine()));
        return $this->generalIndexAction($request, $filterForm);
    }

    public function filterAction(Request $request)
    {
        $filterForm = $this->createForm(new SamplesFilterType($this->getDoctrine()));

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->get($filterForm->getName()));
            return $this->generalIndexAction($request, $filterForm);
        } else {
            return $this->generalIndexAction($request, null, null);
        }
    }


    /*--------------------------------------*/


}