<?php

namespace AppBundle\Form\ChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class ParameterDomainList extends LazyChoiceList
{

    private $doctrine;
    private $methodName;
    private $pmd;

    public function __construct($doctrine,$methodName)
    {
        $this->doctrine = $doctrine;
        $this->methodName = $methodName;
    }

    protected function loadChoiceList()
    {
       // $types = $this->doctrine->getRepository('AppBundle:ParameterDomains')->getParameterDomainsByMethodName($this->methodName);
        $this->pmd=$this->doctrine->getRepository('AppBundle:ParameterDomains')->getParameterDomainsByMethodName($this->methodName);
        $values=array();
        $labels=array();
        foreach ($this->pmd as $pmd) {
            $value = $pmd->getCode();
            $label = $pmd->getCode();
            array_push($values,$value);
            array_push($labels,$label);
        }
        $cl=new ChoiceList($values,$labels);
        return $cl;
    }

    protected function loadDescription()
    {
        $description=array();
        foreach ($this->pmd as $pmd) {
            $description[$pmd->getCode()] =$pmd->getDescription();
        }
        return $description;
    }
}