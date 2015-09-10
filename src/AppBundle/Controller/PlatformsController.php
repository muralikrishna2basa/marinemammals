<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlatformsController extends Controller
{

    public function newAction()
    {
        $cp=new ControllerFormSuccessPlugin($this,'AppBundle\Entity\Platforms',null,'platformstype',null,'AppBundle:Platforms',null,'AppBundle:Page:add-platforms.html.twig');
        return $cp->createEntitiesAndRenderForm('na');
    }

    public function createAction(Request $request)
    {
        $cp=new ControllerFormSuccessPlugin($this,'AppBundle\Entity\Platforms',null,'platformstype',null,'AppBundle:Platforms',null,'AppBundle:Page:add-platforms.html.twig');

        $a = $cp->createEntitiesFormsAndLists();

        $platform = $a['entity1'];
        $platforms = $a['entity1List'];
        $form = $a['form1'];

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($platform);
            $em->flush();

            return $cp->createEntitiesAndRenderForm('true');
        }
        return $cp->renderForm($form, $platforms,'false');
    }
}
