<?php

namespace AppBundle\Form;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class CgRefChoiceList extends LazyChoiceList
{

    private $doctrine;
    private $domain;

    public function __construct($doctrine,$domain)
    {
        $this->doctrine = $doctrine;
        $this->domain = $domain;
    }

    protected function loadChoiceList()
    {
        $types = $this
            ->doctrine->getRepository('AppBundle:CgRefCodes')->getRefCodes($this->domain);
        $choices=array();
        $labels=array();
        foreach ($types as $type) {
            //$data = $type->getRvLowValue();
            $value = $type->getRvLowValue();
            $label = $type->getRvMeaning();
            array_push($choices,$value);
            array_push($labels,$label);
        }
        $cl=new ChoiceList($choices,$labels);
        return $cl;
    }
}