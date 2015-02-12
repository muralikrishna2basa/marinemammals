<?php

namespace AppBundle\Form\ChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class StationsList extends LazyChoiceList
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    protected function loadChoiceList()
    {
        $stations = $this
            ->doctrine->getRepository('AppBundle:Stations')->getAllStations();
        $values=array();
        $labels=array();
        foreach ($stations as $station) {
            $value = $station->getExtendedName();
            $label = $station->getExtendedName();
            array_push($values,$value);
            array_push($labels,$label);
        }
        $cl=new ChoiceList($values,$labels);
        return $cl;
    }
}