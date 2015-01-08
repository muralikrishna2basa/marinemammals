<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Persons;
use AppBundle\Form\PersonsType;
use AppBundle\Entity\Institutes;
use AppBundle\Form\InstitutesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ObservationsController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $observations = $em->getRepository('AppBundle:Observations')
            ->getCompleteObservation();

        return $this->render('AppBundle:Page:list-observations.html.twig',array(
            'observations' => $observations,
        ));
    }
}
