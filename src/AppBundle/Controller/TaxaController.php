<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaxaController extends Controller
{

    public function newAction()
    {
        $cp=new ControllerFormSuccessPlugin($this,'AppBundle\Entity\Taxa',null,'taxatype',null,'AppBundle:Taxa',null,'AppBundle:Page:add-taxa.html.twig');
        return $cp->createEntitiesAndRenderForm('na');
    }

    public function createAction(Request $request)
    {
        $cp=new ControllerFormSuccessPlugin($this,'AppBundle\Entity\Taxa',null,'taxatype',null,'AppBundle:Taxa',null,'AppBundle:Page:add-taxa.html.twig');

        $a = $cp->createEntitiesFormsAndLists();

        $taxon = $a['entity1'];
        $taxa = $a['entity1List'];
        $form = $a['form1'];

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($taxon);
            $em->flush();

            return $cp->createEntitiesAndRenderForm('true');
        }
        return $cp->renderForm($form, $taxa,'false');
    }
}
