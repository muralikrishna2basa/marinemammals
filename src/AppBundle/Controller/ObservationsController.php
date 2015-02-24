<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observations;
use AppBundle\Entity\ObservationValues;
use AppBundle\Entity\EventStates;
use AppBundle\Entity\Event2Persons;
use AppBundle\Entity\Spec2Events;
use AppBundle\Entity\SpecimenValues;
use AppBundle\Entity\EntityValues;
use AppBundle\Entity\ValueAssignable;
use AppBundle\Form\ObservationsType;
use AppBundle\Form\Filter\ObservationsFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpFoundation\Request;

class ObservationsController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new ObservationsFilterType($this->getDoctrine()));

        if ($request->query->has($form->getName())) {
            // manually bind values from the request
            $form->submit($request->query->get($form->getName()));
            // initialize a query builder
            $filterBuilder = $em->getRepository('AppBundle:Observations')->createQueryBuilder('e');
            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
            //var_dump($filterBuilder->getDql());
            //this is the place where everything happen, the $filterBuilder only creates the query for the filters but can't get the
            //objects by itself so we need to "getQuery()" and then "getArrayResult()", thats all, the filtered have been loaded
            $resultQuery = $filterBuilder->getQuery();
            $filteredEntities = $resultQuery->getArrayResult();
            $filteredAndPaginatedEntities = $this->paginate($filteredEntities);
            return $this->render('AppBundle:Page:list-observations.html.twig', array(
                'entities' => $filteredAndPaginatedEntities
            ));
        }
        $observations = $em->getRepository('AppBundle:Observations')
            ->getCompleteObservation();
        $paginatedEntities = $this->paginate($observations);
        return $this->render('AppBundle:Page:list-observations.html.twig', array('entities' => $paginatedEntities, 'form' => $form->createView()));
    }

    private function paginate($array)
    {
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $array,
            $this->get('request')->query->get('page', 1)/*page number*/,
            2000/*limit per page*/
        );
        return $pagination;
    }

    public function newAction()
    {
        $observation = $this->prepareNewObservation();
        $form = $this->createForm(new ObservationsType($this->getDoctrine()), $observation);
        return $this->render('AppBundle:Page:add-observations-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'na',
            'errors' => array('')
        ));
    }

    public function createAction(Request $request)
    {
        $observation = $this->prepareNewObservation();
        $event = $observation->getEseSeqno();
        $s2e = $event->getSpec2Events();

        $form = $this->createForm(new ObservationsType($this->getDoctrine()), $observation);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getEntityManager();
            $em->persist($event);
            $em->persist($observation);
            $em->persist($s2e);
            foreach ($observation->getValues() as $ov) {
                $this->persistOrRemoveEntityValue($ov, $observation);
            }
            foreach ($s2e->getValues() as $sv) {
                $this->persistOrRemoveEntityValue($sv, $s2e);
            }
            foreach ($event->getEvent2Persons() as $e2p) {
                $this->persistOrRemoveEvent2Persons($e2p, $event);
            }
            $em->flush();
            $observation2 = $this->prepareNewObservation();
            $form2 = $this->createForm(new ObservationsType($this->getDoctrine()), $observation2);
            return $this->render('AppBundle:Page:add-observations-specimens.html.twig', array(
                'form' => $form2->createView(),
                'success' => 'true',
                'errors' => array('')
            ));
        }

        $errors = $form->getErrors(true, false);
        $errors2 = array();
        $errors2 = $this->getErrorList($errors, $errors2);

        return $this->render('AppBundle:Page:add-observations-specimens.html.twig', array(
            'form' => $form->createView(),
            'success' => 'false',
            'errors' => $errors2
        ));
    }

    private function getErrorList(FormErrorIterator $fei, $return)
    {
        $parentFormName=$fei->getForm()->getName();
        foreach ($fei as $error) {
            $cl=get_class($error);
                //$current = $error->current();
            //if ($current->valid()) {
                if ($cl==='Symfony\Component\Form\FormErrorIterator') {
                    $return = $this->getErrorList($error, $return);
                } elseif($cl==='Symfony\Component\Form\FormError') {
                    $message = $error->getMessage();
                    $property = $error->getCause()->getPropertyPath();
                    $property=str_replace(".children", "", $property);
                    $property=str_replace("children", $parentFormName, $property);
                    $return[$property] = $message;
                }
           // }
        }
        return $return;
    }

    function array_flatten($array, $return)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $return = $this->array_flatten($value, $return);
            } elseif ($value) {
                $return[$key] = $value;
            }
        }
        return $return;
    }

    private function getErrorMessages(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        if ($form->count() > 0) {
            foreach ($form->getIterator() as $child) {
                if (!$child->isValid()) {
                    $errors[$child->getName()] = $this->getErrorMessages($child);
                }
            }
        } else {
            foreach ($form->getErrors(true, false) as $key => $error) {
                $errors[$key] = $error->getMessage();
            }
        }

        return $errors;
    }

    private function persistOrRemoveEntityValue(EntityValues $ev, ValueAssignable $va)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();
        if ($ev->getValue() === null) { //empty values are allowed
            $va->removeValue($ev);
            $em->remove($ev);
        } else {
            $em->persist($ev);
        }
    }

    private function persistOrRemoveEvent2Persons(Event2Persons $e2p, EventStates $e)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();
        if ($e2p->getPsnSeqno() === null) {
            $e->removeEvent2Persons($e2p);
            $em->remove($e2p);
        } else {
            $em->persist($e2p);
        }
    }

    private function prepareNewObservation()
    {
        $observation = new Observations();
        $event = new EventStates();
        $observation->setEseSeqno($event);

        $event2Persons1 = new Event2Persons();
        $event2Persons1->setEseSeqno($event);
        $event2Persons1->setE2pType(EventStates::OBSERVED);
        $event->getEvent2Persons()->add($event2Persons1);

        $event2Persons2 = new Event2Persons();
        $event2Persons2->setEseSeqno($event);
        $event2Persons2->setE2pType(EventStates::GATHERED);
        $event->getEvent2Persons()->add($event2Persons2);

        $evcfoc = new EntityValuesCollectionForOC($this->getDoctrine()->getManager());

        $evcfoc->allObservationValues->supplementEntityValues($observation);

        $s2e = new Spec2Events();
        //$specimen=new Specimens();
        $event->setSpec2Events($s2e);
        //$s2e->setEseSeqno($event); //TODO: check if this can be deleted. shoudle be now that this is truly bidirectional
        //$s2e->setScnSeqno($specimen);

        $evcfoc->allSpecimenValues->supplementEntityValues($s2e);

        return $observation;
    }

    public function editAction($id)
    {
        $observation = $this->loadObservation($id);
        $form = $this->createForm(new ObservationsType($this->getDoctrine()), $observation);
        return $this->render('AppBundle:Page:add-observations-specimens.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function updateAction(Request $request, $id)
    {
        $observation = $this->loadObservation($id);
        $form = $this->createForm(new ObservationsType($this->getDoctrine()), $observation);
        $form->handleRequest($request);
        if ($form->isValid()) {
            // updating stuff here ...
            return $this->redirect($this->generateUrl('some_edit_route', array('id' => $id)));
        }
        return array('observation' => $observation);
    }

    private function loadObservation($id)
    {
        $observation = $this->getDoctrine()->getRepository('AppBundle:Observations')->find($id);
        $evcfoc = new EntityValuesCollectionForOC($this->getDoctrine()->getManager());
        $evcfoc->allObservationValues->supplementEntityValues($observation);
        $s2e = $observation->getEseSeqno()->getSpec2Events();
        $evcfoc->allSpecimenValues->supplementEntityValues($s2e);

        if (!$observation) {
            throw $this->createNotFoundException(sprintf('omg this observation could not be loaded: %s', $id));
        }
        return $observation;
    }


    public function testAction()
    {
        $t = new \AppBundle\Tests\Entity\ObservationValidationTest();
        $to = $t->generateTestObject();

        $validator = $this->get('validator');
        $errors = $validator->validate($to['sv']);

        if (count($errors) > 0) {
            $errorsString = (string)$errors;
            return new \Symfony\Component\HttpFoundation\Response($errorsString);
        }
        return new \Symfony\Component\HttpFoundation\Response('The observation is valid! Yes!');
    }
}
