<?php

namespace AppBundle\Controller;

use AppBundle\Form\Filter\ObservationsFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\ControllerHelper\ObservationIndexPropertiesSet;
use AppBundle\ControllerHelper\MgmtObservationIndexPropertiesSet;

class ObservationsRetrievalController extends Controller
{

    private function generalFilterAction(Request $request, $page, $excludeConfidential, $onlyBelgium, $ps)
    {
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()), null, array('onlyBelgium' => $onlyBelgium));
        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));
            $filter = $form->getData();
            $filter['excludeConfidential']=$excludeConfidential;
            $observations = $this->get('observations_provider')->loadObservationsByFilter($filter);
            $results = array();
            foreach ($observations as $o) {
                array_push($results, $ps->getAll($o));
            }
            if ($request->query->has('export')) {
                return $this->export($results);
            } elseif ($request->query->has('submit')) {
                return $this->generalIndexAction($page, $form, $observations);
            }
        }
        /*$observations = $this->getIndexOfObservations($excludeConfidential, $excludeNonBelgian);
        return $this->generalIndexAction($page, $form, $observations);*/
    }

    private function generalIndexAction($page, $form, $observations)
    {
        $observations = $this->paginate($observations);
        //$observations=$this->get('observations_provider')->supplementCgDescriptionMultiple($observations);
        return $this->render($page, array('entities' => $observations, 'form' => $form->createView()));
    }

    public function mgmtIndexAction()
    {
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()), null, array('onlyBelgium' => false));
        $observations = $this->get('observations_provider')->loadObservations(false, false);
        return $this->generalIndexAction('AppBundle:Page:mgmt-list-observations.html.twig', $form, $observations);
    }

    public function mgmtFilterAction(Request $request)
    {
        $ps = new MgmtObservationIndexPropertiesSet();
        return $this->generalFilterAction($request, 'AppBundle:Page:mgmt-list-observations.html.twig', false, false, $ps);
    }

    public function indexAction()
    {
        $observations = $this->get('observations_provider')->loadObservations(true, true);
        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()), null, array('onlyBelgium' => true));
        return $this->generalIndexAction('AppBundle:Page:list-observations.html.twig', $form, $observations);
    }

    public function filterAction(Request $request)
    {
        $ps = new ObservationIndexPropertiesSet();
        return $this->generalFilterAction($request, 'AppBundle:Page:list-observations.html.twig', true, true, $ps);
    }

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

    private function generalViewAction($page,$id){
        $observation = $this->get('observations_provider')->loadObservation($id);

        return $this->render($page, array(
            'observation'=>$observation
        ));
    }

    public function mgmtViewAction($id){
        return $this->generalViewAction('AppBundle:Page:mgmt-view-observations-specimens.html.twig',$id);
    }

    public function viewAction($id){
        return $this->generalViewAction('AppBundle:Page:view-observations-specimens.html.twig',$id);
    }

    public function export($results)
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
}
