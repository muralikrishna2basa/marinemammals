<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sources;
use AppBundle\Form\SourcesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SourcesController extends Controller
{

    public function newAction()
    {
        $cp=new ControllerFormSuccessPlugin($this,'AppBundle\Entity\Sources',null,'sourcestype',null,'AppBundle:Sources',null,'AppBundle:Page:add-sources.html.twig');
        return $cp->createEntitiesAndRenderForm('na');

        /*$em = $this->getDoctrine()->getEntityManager();

        $sources = $em->getRepository('AppBundle:Sources')
            ->getAllSources();
        $source=new Sources();
        $form   = $this->createForm(new SourcesType($this->getDoctrine()), $source);
        return $this->render('AppBundle:Page:add-sources.html.twig',array(
            'sources' => $sources,
            'form'   => $form->createView(),
        ));*/
    }

    public function createAction(Request $request)
    {
        /*$em = $this->getDoctrine()->getEntityManager();

        $sources = $em->getRepository('AppBundle:Sources')
            ->getAllSources();
        $source=new Sources();
        $form   = $this->createForm(new SourcesType($this->getDoctrine()), $source);
*/
        $cp=new ControllerFormSuccessPlugin($this,'AppBundle\Entity\Sources',null,'sourcestype',null,'AppBundle:Sources',null,'AppBundle:Page:add-sources.html.twig');

        $a = $cp->createEntitiesFormsAndLists();

        $source = $a['entity1'];
        $sources = $a['entity1List'];
        $form = $a['form1'];

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($source);
            $em->flush();

            return $cp->createEntitiesAndRenderForm('true');
        }
        return $cp->renderForm($form, 'false', $sources);
    }
}
