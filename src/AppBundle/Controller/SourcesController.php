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
        $em = $this->getDoctrine()->getEntityManager();

        $sources = $em->getRepository('AppBundle:Sources')
            ->getAllSources();
        $source=new Sources();
        $form   = $this->createForm(new SourcesType($this->getDoctrine()), $source);
        return $this->render('AppBundle:Page:add-sources.html.twig',array(
            'sources' => $sources,
            'form'   => $form->createView(),
        ));
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $sources = $em->getRepository('AppBundle:Sources')
            ->getAllSources();
        $source=new Sources();
        $form   = $this->createForm(new SourcesType($this->getDoctrine()), $source);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($source);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('AppBundle:Page:add-sources.html.twig',array(
            'sources' => $sources,
            'form'   => $form->createView(),
        ));
    }
}
