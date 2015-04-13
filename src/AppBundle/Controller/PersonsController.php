<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Groups;
use AppBundle\Entity\Persons;
use AppBundle\Entity\Institutes;

class PersonsController extends Controller
{

    public function newAction()
    {
        $cp = new ControllerFormSuccessPlugin($this, 'AppBundle\Entity\Persons', 'AppBundle\Entity\Institutes', 'personstype', 'institutestype', 'AppBundle:Persons', 'AppBundle:Institutes', 'AppBundle:Page:add-persons.html.twig');
        //return $cp->createEntitiesAndRenderForm('na', 'na');
        //$group = $this->getDoctrine()->getManager()->getRepository('AppBundle:Groups')->findByName('OBSERVER');
        //$group = new Groups();
        $person = new Persons();
        //$person->addGrpName($group);
        $institute = new Institutes();

        $a = $cp->createFormsAndLists($person, $institute);

        return $cp->renderForm($a['form1'], $a['entity1List'], 'na', $a['form2'], $a['entity2List'], 'na');
    }

    public function createAction(Request $request)
    {
        $cp = new ControllerFormSuccessPlugin($this, 'AppBundle\Entity\Persons', 'AppBundle\Entity\Institutes', 'personstype', 'institutestype', 'AppBundle:Persons', 'AppBundle:Institutes', 'AppBundle:Page:add-persons.html.twig');

        $group = new Groups();
        $person = new Persons();
        $person->addGrpName($group);
        $institute = new Institutes();

        $a = $cp->createFormsAndLists($person, $institute);

        $person = $a['entity1'];
        $persons = $a['entity1List'];
        $pform = $a['form1'];

        /* $group = new Groups();
         $person->addGrpName($group);*/

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
                return $cp->renderForm($pform, $persons, 'false', $iform, $institutes, 'na');
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
                return $cp->renderForm($pform, $persons, 'na', $iform, $institutes, 'false');
            }
        }
    }
}
