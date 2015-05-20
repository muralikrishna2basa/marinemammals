<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\RedirectResponse;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;
/*
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
*/
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

    private $repo;

    public function indexAction(Request $request)
    {
        //$currentPage=$request->query->get('page');
        //$pageSize=$request->query->get('pagesize');

        $this->repo = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Samples');
        //$samples =  $this->repo->getFastSamplesQb();
        /*$adapter = new DoctrineORMAdapter($samples);
        $pager =  new Pagerfanta($adapter);
        $pager->setMaxPerPage(10);
        if (!$page)    $page = 1;
        try  {
            $pager->setCurrentPage($page);
        }
        catch(NotValidCurrentPageException $e) {
            throw new NotFoundHttpException('Illegal page');
        }
        $data = $pager->getCurrentPageResults();
        $arr=iterator_to_array($data);
        \Doctrine\Common\Util\Debug::dump($arr);
        return $this->render('AppBundle:Page:list-samples.html.twig', array(
            'samples'=>$pager
        ));*/
        /*$paginator  = new \Doctrine\ORM\Tools\Pagination\Paginator($samples);

        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);

// now get one page's items:
        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($currentPage-1)) // set the offset
            ->setMaxResults($pageSize); // set the limit
        return $this->render('AppBundle:Page:list-samples.html.twig', array(
            'samples'=>$pager
        ));*/

        //order of items from database
        $order_by = array();
        //Using custom made database query function in LanguageRepository class
        $samplesCount = $this->repo->getSamplesCount();
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
        $samples = $this->repo->getSamplesListWithPagination($order_by, $paginator->getOffset(), $paginator->getLimit());
        //Finally - return array to templating engine for displaying data.
        //return array('samples' => $samples, 'sort_dir' => $sort_direction, 'paginator' => $strPaginator);

        return $this->render('AppBundle:Page:list-samples.html.twig', array(
            'samples' => $samples, 'sort_dir' => $sort_direction, 'paginator' => $strPaginator
        ));
    }
/*
    protected function getDoctrinePaginator(QueryBuilder $qb, $limit=10)
    {
        $page = $this->getRequest()->query->get("page", 1) ;
        $qb ->setFirstResult( ( $page-1 ) * $limit)->setMaxResults($limit) ;

        return new Paginator($qb);
    }*/

}