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
        $this->pmd=$this->doctrine->getRepository('AppBundle:ParameterDomains')->getParameterDomainsByMethodName($this->methodName);
    }

    protected function loadChoiceList()
    {
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

    public function getDescription()
    {
        $description=array();
        foreach ($this->pmd as $pmd) {
            $desc=$pmd->getDescription();
            if($desc !== null && $desc !== ''){
                $description[$pmd->getCode()] =$pmd->getDescription();
            }
        }
        return $description;
    }

    public function getDescriptionAsString()
    {
        $a=$this->getDescription();
        if(count($a)>0){
            return $this->array2ul($this->getDescription());
        }
        else return null;
    }

    private function array2ul($array) {
        $output = '<ul style="margin-left:0; padding-left:1em;">';
        foreach ($array as $key => $value) {
            $function = is_array($value) ? __FUNCTION__ : 'htmlspecialchars';
            $output .= '<li><strong>' . $key . '</strong>: ' . $function($value) . '</li>';
        }
        return $output . '</ul>';
    }
}