<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Platforms;
use AppBundle\Form\PlatformsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlatformsController extends Controller
{

    public function newAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $platforms = $em->getRepository('AppBundle:Platforms')
            ->getAllPlatforms();
        $platform=new Platforms();
        $form   = $this->createForm(new PlatformsType($this->getDoctrine()), $platform);
        return $this->render('AppBundle:Page:add-platforms.html.twig',array(
            'platforms' => $platforms,
            'form'   => $form->createView(),
        ));
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $platforms = $em->getRepository('AppBundle:Platforms')
            ->getAllPlatforms();
        $platform=new Platforms();
        $form   = $this->createForm(new PlatformsType($this->getDoctrine()), $platform);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($platform);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('AppBundle:Page:add-platforms.html.twig',array(
            'platforms' => $platforms,
            'form'   => $form->createView(),
        ));
    }
}
