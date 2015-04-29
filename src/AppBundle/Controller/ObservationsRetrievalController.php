<?php

namespace AppBundle\Controller;

use AppBundle\Form\Filter\ObservationsFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\ControllerHelper\ObservationIndexPropertiesSet;
use AppBundle\ControllerHelper\ObservationIndexArrayPropertiesSet;
use AppBundle\ControllerHelper\MgmtObservationIndexPropertiesSet;

class ObservationsRetrievalController extends Controller
{

    private function generalFilterAction(Request $request, $page, $excludeConfidential, $onlyBelgium, $ps, $resultIsSimple)
    {
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()), null, array('onlyBelgium' => $onlyBelgium));
        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));
            $filter = $form->getData();
            $filter['excludeConfidential'] = $excludeConfidential;
            $observations = $this->get('observations_provider')->loadObservationsByFilter($filter, $resultIsSimple);
            $results = array();
            foreach ($observations as $o) {
                 array_push($results, $ps->getAll($o));
            }
            if ($request->query->has('export')) {
                return $this->excelExport($results);
            } elseif ($request->query->has('json')) {
                return $this->jsonExport($results);
            } elseif ($request->query->has('submit') && $page !== null) {
                return $this->generalIndexAction($page, $form, $observations);
            }
        }
        /*$observations = $this->getIndexOfObservations($excludeConfidential, $excludeNonBelgian);
        return $this->generalIndexAction($page, $form, $observations);*/
    }

    public function mgmtJsonExportAction(Request $request)
    {
        $ps = new MgmtObservationIndexPropertiesSet();
        $request->query->add(array('json' => true));
        return new JsonResponse($this->generalFilterAction($request, null, false, false, $ps, false), Response::HTTP_OK, array('Content-Type' => 'application/json'));
    }

    public function jsonExportAction(Request $request)
    {
        $ps = new ObservationIndexPropertiesSet();
        $request->query->add(array('json' => true));
        return new JsonResponse($this->generalFilterAction($request, null, true, true, $ps, false), Response::HTTP_OK, array('Content-Type' => 'application/json'));
    }

    private function generalIndexAction($page, $form, $observations)
    {
        $observations = $this->paginate($observations);
        //$observations=$this->get('observations_provider')->supplementCgDescriptionMultiple($observations);
        return $this->render($page, array('entities' => $observations, 'form' => $form->createView()));
    }

    /*--------------------------------------*/

    public function indexAction()
    {
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()), null, array('onlyBelgium' => true));
        $observations = $this->get('observations_provider')->loadObservations(true, true, true);
        return $this->generalIndexAction('AppBundle:Page:list-observations.html.twig', $form, $observations);
    }

    public function mgmtIndexAction()
    {
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()), null, array('onlyBelgium' => false));
        $observations = $this->get('observations_provider')->loadObservations(false, false, false);
        return $this->generalIndexAction('AppBundle:Page:mgmt-list-observations.html.twig', $form, $observations);
    }

    public function filterAction(Request $request)
    {
        $ps = new ObservationIndexArrayPropertiesSet();
        return $this->generalFilterAction($request, 'AppBundle:Page:list-observations.html.twig', true, true, $ps, true);
    }

    public function mgmtFilterAction(Request $request)
    {
        $ps = new MgmtObservationIndexPropertiesSet();
        return $this->generalFilterAction($request, 'AppBundle:Page:mgmt-list-observations.html.twig', false, false, $ps, false);
    }

    /*--------------------------------------*/

    public function ajaxIndexSpecimenAction()
    {
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()), null, array('onlyBelgium' => false));
        $observations = array();//$this->get('observations_provider')->loadObservations(false, false,false);
        return $this->generalIndexAction('AppBundle:Page:ajax-list-observed-specimens.html.twig', $form, $observations);
    }

    public function ajaxFilterSpecimenAction(Request $request)
    {
        $ps = new MgmtObservationIndexPropertiesSet();
        if ($request->isMethod('GET')) {
            $request->query->add(array('submit' => true));
            return $this->generalFilterAction($request, 'AppBundle:Page:ajax-list-observed-specimens.html.twig', false, false, $ps, false);
        }
    }

    /*--------------------------------------*/
    private function paginate($array)
    {
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $array,
            $this->get('request')->query->get('page', 1)/*page number*/,
            500/*limit per page*/
        );
        return $pagination;
    }

    private function generalViewAction($page, $id)
    {
        $observation = $this->get('observations_provider')->loadObservation($id);

        return $this->render($page, array(
            'observation' => $observation
        ));
    }

    public function mgmtViewAction($id)
    {
        return $this->generalViewAction('AppBundle:Page:mgmt-view-observations-specimens.html.twig', $id);
    }

    public function viewAction($id)
    {
        return $this->generalViewAction('AppBundle:Page:view-observations-specimens.html.twig', $id);
    }

    public function excelExport($results)
    {
        $today = new \DateTime();
        $todayString = $today->format('Y-m-d');

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        $phpExcelObject->getProperties()->setCreator("Belgian Marine Data Center")
            ->setLastModifiedBy("Belgian Marine Data Center")
            ->setTitle("Marine Mammals export " . $todayString)
            ->setSubject("Occurence data of Belgian marine mammals")
            ->setDescription("An export of the Belgian marine mammals database, located at www.marinemammals.be");
        $phpExcelObject->setActiveSheetIndex(0);
        foreach ($results as $i => $row) {
            $startCell = 'A' . ($i + 2);
            if ($i == 0) {
                $keys = array_keys($row);
                $phpExcelObject->getActiveSheet()->fromArray($keys, NULL, 'A1');
            }
            $phpExcelObject->getActiveSheet()->fromArray($row, NULL, $startCell);
        }
        $phpExcelObject->getActiveSheet()->setTitle('export ' . $todayString);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=mm_export_' . $todayString . '.xlsx');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    private function jsonExport($results)
    {
        $a = json_encode($results);
        return $a;
    }
}
