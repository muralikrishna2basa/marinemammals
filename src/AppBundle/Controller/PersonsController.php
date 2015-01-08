<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Persons;
use AppBundle\Form\PersonsType;
use AppBundle\Entity\Institutes;
use AppBundle\Form\InstitutesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonsController extends Controller
{

    public function newAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $persons = $em->getRepository('AppBundle:Persons')
            ->getAllPersons();
        $person=new Persons();
        $pform   = $this->createForm(new PersonsType($this->getDoctrine()), $person);

        $institutes = $em->getRepository('AppBundle:Institutes')
            ->getAllInstitutes();
        $institute=new Institutes();
        $iform   = $this->createForm(new InstitutesType(), $institute);

        return $this->render('AppBundle:Page:add-persons.html.twig',array(
            'persons' => $persons,
            'pform'   => $pform->createView(),
            'institutes' => $institutes,
            'iform'   => $iform->createView()
        ));
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $persons = $em->getRepository('AppBundle:Persons')
            ->getAllPersons();
        $person=new Persons();
        $pform   = $this->createForm(new PersonsType($this->getDoctrine()), $person);

        $institutes = $em->getRepository('AppBundle:Institutes')
            ->getAllInstitutes();
        $institute=new Institutes();
        $iform   = $this->createForm(new InstitutesType(), $institute);

        $pform->handleRequest($request);
        if ($pform->isValid()) {

            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($person);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        $iform->handleRequest($request);
        if ($iform->isValid()) {

            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($institute);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('AppBundle:Page:add-persons.html.twig',array(
            'persons' => $persons,
            'pform'   => $pform->createView(),
            'institutes' => $institutes,
            'iform'   => $iform->createView()
        ));
    }
}
