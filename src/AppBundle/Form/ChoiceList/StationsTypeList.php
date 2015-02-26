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
        $values = array();
        //$labels=array();
        $previousValue='';
        foreach ($types as $type) {
            if ($type['areaType'] !== null) {
                $value = $type['areaType'];
                if(strcasecmp($value, $previousValue) != 0) {
                    $values[$value] = $value;
                }
                $previousValue=$value;
            }
        }
        $cl = new ChoiceList($values, $values);
        return $cl;
    }
}