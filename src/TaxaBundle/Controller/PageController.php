<?php

namespace TaxaBundle\Controller;

use AppBundle\Entity\Taxa;
use TaxaBundle\Form\TaxaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
		$taxa = $em->getRepository('AppBundle:Taxa')
                  ->getAllTaxa();

        return $this->render('TaxaBundle:Page:index.html.twig',array(
            'taxa' => $taxa
        ));
    }

    public function newAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $taxa = $em->getRepository('AppBundle:Taxa')
            ->getAllTaxa();

        $taxon=new Taxa();
        $form   = $this->createForm(new TaxaType(), $taxon);

        return $this->render('TaxaBundle:Page:add.html.twig',array(
            'taxa' => $taxa,
            'form'   => $form->createView()
        ));
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $taxa = $em->getRepository('AppBundle:Taxa')
            ->getAllTaxa();

        $taxon=new Taxa();
        $form   = $this->createForm(new TaxaType(), $taxon);

//        $form->bindRequest($request);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($taxon);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('TaxaBundle:Page:add.html.twig',array(
            'taxa' => $taxa,
            'form'   => $form->createView()
        ));
    }

/*    public function allTaxaAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
		$taxa = $em->getRepository('AppBundle:Taxa')
                  ->getAllTaxa();

        return $this->render('TaxaBundle:Bare:list.html.twig',array(
            'taxa' => $taxa
        ));
    }*/
}
