<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StationsController extends Controller
{

    public function newAction()
    {
        $cp=new ControllerFormSuccessPlugin($this,'AppBundle\Entity\Stations','AppBundle\Entity\Places','stationstype','placestype','AppBundle:Stations','AppBundle:Places','AppBundle:Page:add-stations.html.twig');
        return $cp->createEntitiesAndRenderForm('na', 'na');
    }

    public function createAction(Request $request)
    {
        $cp=new ControllerFormSuccessPlugin($this,'AppBundle\Entity\Stations','AppBundle\Entity\Places','stationstype','placestype','AppBundle:Stations','AppBundle:Places','AppBundle:Page:add-stations.html.twig');

        $a = $cp->createEntitiesFormsAndLists();

        $station = $a['entity1'];
        $stations = $a['entity1List'];
        $sform = $a['form1'];

        $place = $a['entity2'];
        $places = $a['entity2List'];
        $pform = $a['form2'];

        $sform->handleRequest($request);
        if ($sform->isSubmitted()) {
            if ($sform->isValid()) {

                $em = $this->getDoctrine()
                    ->getEntityManager();
                $em->persist($station);
                $em->flush();
                return $cp->createEntitiesAndRenderForm('true', 'na');

            } else {
                return $cp->renderForm($sform, $stations, 'false', $pform, 'na', $places);
            }
        }

        $pform->handleRequest($request);
        if ($pform->isSubmitted()) {
            if ($pform->isValid()) {

                $em = $this->getDoctrine()
                    ->getEntityManager();
                $em->persist($place);
                $em->flush();
                return $cp->createEntitiesAndRenderForm('na', 'true');

            } else {
                return $cp->renderForm($sform, $stations, 'na', $pform, 'false', $places);
            }
        }
    }
}
