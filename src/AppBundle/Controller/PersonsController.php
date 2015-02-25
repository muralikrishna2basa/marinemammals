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
        $cp = new ControllerFormSuccessPlugin($this, 'AppBundle\Entity\Persons', 'AppBundle\Entity\Institutes', 'personstype', 'institutestype', 'AppBundle:Persons', 'AppBundle:Institutes', 'AppBundle:Page:add-persons.html.twig');
        return $cp->createEntitiesAndRenderForm('na', 'na');
        /*
                $em = $this->getDoctrine()->getEntityManager();

                $persons = $em->getRepository('AppBundle:Persons')
                    ->getAllPersons();
                $person=new Persons();
                $pform   = $this->createForm(new PersonsType($this->getDoctrine()), $person);

                $institutes = $em->getRepository('AppBundle:Institutes')
                    ->getAllInstitutes();
                $institute=new Institutes();
                $iform   = $this->createForm( new InstitutesType(), $institute);

                return $this->render('AppBundle:Page:add-persons.html.twig',array(
                    'persons' => $persons,
                    'pform'   => $pform->createView(),
                    'institutes' => $institutes,
                    'iform'   => $iform->createView()
                ));*/
    }

    public function createAction(Request $request)
    {
        /* $em = $this->getDoctrine()->getEntityManager();

         $persons = $em->getRepository('AppBundle:Persons')
             ->getAllPersons();
         $person=new Persons();
         $pform   = $this->createForm(new PersonsType($this->getDoctrine()), $person);

         $institutes = $em->getRepository('AppBundle:Institutes')
             ->getAllInstitutes();
         $institute=new Institutes();
         $iform   = $this->createForm(new InstitutesType(), $institute);
 */
        $cp = new ControllerFormSuccessPlugin($this, 'AppBundle\Entity\Persons', 'AppBundle\Entity\Institutes', 'personstype', 'institutestype', 'AppBundle:Persons', 'AppBundle:Institutes', 'AppBundle:Page:add-persons.html.twig');

        $a = $cp->createEntitiesFormsAndLists();

        $person = $a['entity1'];
        $persons = $a['entity1List'];
        $pform = $a['form1'];

        $institute = $a['entity2'];
        $institutes = $a['entity2List'];
        $iform = $a['form2'];

        $pform->handleRequest($request);
        if ($pform->isSubmitted()) {
            if ($pform->isValid()) {

                $em = $this->getDoctrine()
                    ->getEntityManager();
                $em->persist($person);
                $em->flush();

                return $cp->createEntitiesAndRenderForm('true', 'na');
            } else {
                return $cp->renderForm($pform, $iform, 'false', 'na', $persons, $institutes);
            }
        }

        $iform->handleRequest($request);
        if ($iform->isSubmitted()) {
            if ($iform->isValid()) {

                $em = $this->getDoctrine()
                    ->getEntityManager();
                $em->persist($institute);
                $em->flush();

                return $cp->createEntitiesAndRenderForm('na', 'true');
            } else {
                return $cp->renderForm($pform, $iform, 'na', 'false', $persons, $institutes);
            }
        }
    }
}
