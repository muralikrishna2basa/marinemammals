<?php

namespace AppBundle\Form\ChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class StationsTypeList extends LazyChoiceList
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    protected function loadChoiceList()
    {
        $types = $this
            ->doctrine->getRepository('AppBundle:Stations')->getAllStationsTypes();
        $values=array();
        $labels=array();
        foreach ($types as $type) {
            $value = $type;
            $label = $type;
            array_push($values,$value);
            array_push($labels,$label);
        }
        $cl=new ChoiceList($values,$labels);
        return $cl;
    }
}