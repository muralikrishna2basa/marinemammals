<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

use AppBundle\Form\Filter\NecropsiesFilterType;


use AppBundle\ControllerHelper\Paginator;

use Symfony\Component\HttpFoundation\Request;

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
        /*$response= new Response($this->render('AppBundle::import.html.php'));

        $response->headers->set('Content-Type', 'text/html; charset=UTF-8');
        return $response;*/
        return $this->render('AppBundle::import.html.php');
        //return new RedirectResponse('/legacy/Import.php',301);
    }

    private $necropsyRepo;

    private function generalIndexAction(Request $request, $form)
    {
        $filter = $form->getData();

        $this->necropsyRepo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Necropsies');
        $order_by = array();
        $necropsies =$this->necropsyRepo->getPartialNecropsiesNativeQuery();
        //$qb = $this->necropsyRepo->getPartialNecropsiesQb();
        $qb = $this->get('necropsies_provider')->extendQbByFilter($qb, $filter);

        $samplesCount = $this->necropsyRepo->getNecropsyCount($qb);
        $paginator = new Paginator($samplesCount, 1);

       /* $qb = $this->necropsyRepo->getPartialNecropsiesQb();
        $qb = $this->get('necropsies_provider')->extendQbByFilter($qb, $filter);*/

        if ('POST' === $this->get('request')->getMethod()) {
            $order_by = array($_POST['filter_order'] => $_POST['filter_order_Dir']);
            $sort_direction = $_POST['filter_order_Dir'] == 'asc' ? 'desc' : 'asc';
        } else {
            $sort_direction = 'desc';
        }

        $qb = $this->get('necropsies_provider')->extendQbByPagination($qb, $order_by, $paginator->getOffset(), $paginator->getLimit(), $filter);

        $necropsies = $qb->getQuery()->getScalarResult();

        $strPaginator = $paginator->RenderPaginator('necropsyfilterform');

        return $this->render('AppBundle:Page:list-necropsies.html.twig', array(
            'necropsies' => $necropsies, 'sort_dir' => $sort_direction, 'paginator_html' => $strPaginator, 'paginator' => $paginator, 'filter_form' => $form->createView()
        ));
    }


    public function indexAction(Request $request)
    {
        $filterForm = $this->createForm(new NecropsiesFilterType($this->getDoctrine()));
        return $this->generalIndexAction($request, $filterForm);
    }

    public function filterAction(Request $request)
    {
        $filterForm = $this->createForm(new NecropsiesFilterType($this->getDoctrine()));

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->get($filterForm->getName()));
            return $this->generalIndexAction($request, $filterForm);
        } else {
            return $this->generalIndexAction($request, null, null);
        }
    }

}