<?php

namespace AppBundle\Controller;

class ControllerFormSuccessPlugin
{
    private $doctrine;
    private $type1;
    private $type2;
    private $formtype1;
    private $formtype2;
    private $typeRepo1;
    private $typeRepo2;

    public function __construct($controller, $type1, $type2 = null, $formtype1, $formtype2 = null, $typeRepo1, $typeRepo2 = null, $pageToRender)
    {
        $this->doctrine = $controller->getDoctrine()->getManager();
        $this->type1 = $type1;
        $this->type2 = $type2;
        $this->formtype1 = $formtype1;
        $this->formtype2 = $formtype2;
        $this->typeRepo1 = $typeRepo1;
        $this->typeRepo2 = $typeRepo2;
        $this->pageToRender = $pageToRender;
        $this->controller = $controller;
    }

    public function createEntitiesAndRenderForm($success1, $success2=null)
    {
        $a = $this->createEntitiesFormsAndLists();
        return $this->renderForm($a['form1'], $a['entity1List'], $success1, $a['form2'], $a['entity2List'], $success2);
    }

    public function createFormsAndLists($entity1, $entity2=null)
    {
        $a = array();
        $em = $this->doctrine;

        $entity1List = $em->getRepository($this->typeRepo1)
            ->getAll();
        //$entity1 = new $this->type1;

        $form1 = $this->controller->createForm($this->formtype1, $entity1);

        //$entity2 = null;
        $entity2List = null;
        $form2 = null;

        if ($this->type2 !== null && $this->formtype2 !== null && $this->typeRepo2 !== null) {
            $entity2List = $em->getRepository($this->typeRepo2)
                ->getAll();
            //$entity2 = new $this->type2;
            $form2 = $this->controller->createForm($this->formtype2, $entity2);
        }

        $a['entity1'] = $entity1;
        $a['entity1List'] = $entity1List;
        $a['form1'] = $form1;

        $a['entity2'] = $entity2;
        $a['entity2List'] = $entity2List;
        $a['form2'] = $form2;

        return $a;
    }

    public function createEntitiesFormsAndLists()
    {
        $a = array();
        $em = $this->doctrine;

        $entity1List = $em->getRepository($this->typeRepo1)
            ->getAll();
        $entity1 = new $this->type1;

        $form1 = $this->controller->createForm($this->formtype1, $entity1);

        $entity2 = null;
        $entity2List = null;
        $form2 = null;

        if ($this->type2 !== null && $this->formtype2 !== null && $this->typeRepo2 !== null) {
            $entity2List = $em->getRepository($this->typeRepo2)
                ->getAll();
            $entity2 = new $this->type2;
            $form2 = $this->controller->createForm($this->formtype2, $entity2);
        }

        $a['entity1'] = $entity1;
        $a['entity1List'] = $entity1List;
        $a['form1'] = $form1;

        $a['entity2'] = $entity2;
        $a['entity2List'] = $entity2List;
        $a['form2'] = $form2;

        return $a;
    }

    public function renderForm($form1, $entity1List, $success1, $form2=null, $entity2List=null, $success2=null)
    {
        if ($form2 === null && $entity2List === null && $success2 === null) {
            return $this->controller->render($this->pageToRender, array(
                'entity1List' => $entity1List,
                'form1' => $form1->createView(),
                'success1' => $success1
            ));
        } else {
            return $this->controller->render($this->pageToRender, array(
                'entity1List' => $entity1List,
                'form1' => $form1->createView(),
                'success1' => $success1,
                'entity2List' => $entity2List,
                'form2' => $form2->createView(),
                'success2' => $success2
            ));
        }
    }

}