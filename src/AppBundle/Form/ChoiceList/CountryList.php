<?php

namespace AppBundle\Form\ChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class CountryList extends LazyChoiceList
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    protected function loadChoiceList()
    {
        $countries = $this
            ->doctrine->getRepository('AppBundle:Places')->getAllCountries();
        $values=array();
        $labels=array();
        foreach ($countries as $country) {
            $value = $country->getName();
            $label = $country->getName();
            array_push($values,$value);
            array_push($labels,$label);
        }
        $cl=new ChoiceList($values,$labels);
        return $cl;
    }
}