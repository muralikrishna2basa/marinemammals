<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SourcesController extends Controller
{

    public function newAction()
    {
        $cp=new ControllerFormSuccessPlugin($this,'AppBundle\Entity\Sources',null,'sourcestype',null,'AppBundle:Sources',null,'AppBundle:Page:add-sources.html.twig');
        return $cp->createEntitiesAndRenderForm('na');
    }

    public function createAction(Request $request)
    {
        $cp=new ControllerFormSuccessPlugin($this,'AppBundle\Entity\Sources',null,'sourcestype',null,'AppBundle:Sources',null,'AppBundle:Page:add-sources.html.twig');

        $a = $cp->createEntitiesFormsAndLists();

        $source = $a['entity1'];
        $sources = $a['entity1List'];
        $form = $a['form1'];

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($source);
            $em->flush();

            return $cp->createEntitiesAndRenderForm('true');
        }
        return $cp->renderForm($form, $sources,'false');
    }
}
