<?php

namespace AppBundle\Form;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class ParameterDomainList extends LazyChoiceList
{

    private $doctrine;
    private $methodName;

    public function __construct($doctrine,$methodName)
    {
        $this->doctrine = $doctrine;
        $this->methodName = $methodName;
    }

    protected function loadChoiceList()
    {
        $types = $this
            ->doctrine->getRepository('AppBundle:ParameterDomains')->getParameterDomainsByMethodName($this->methodName);
        $values=array();
        $labels=array();
        foreach ($types as $type) {
            $value = $type->getCode();
            $label = $type->getCode();
            array_push($values,$value);
            array_push($labels,$label);
        }
        $cl=new ChoiceList($values,$labels);
        return $cl;
    }
}