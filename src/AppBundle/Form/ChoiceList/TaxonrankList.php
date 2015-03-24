<?php

namespace AppBundle\Form\ChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class TaxonrankList extends LazyChoiceList
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    protected function loadChoiceList()
    {
        $list = $this
            ->doctrine->getRepository('AppBundle:Taxa')->getAllTaxonranks();
        $values=array();
        $labels=array();
        foreach ($list as $i=>$e) {
            $value = $list[$i]['taxonrank'];
            $label = $list[$i]['taxonrank'];
            array_push($values,$value);
            array_push($labels,$label);
        }
        $cl=new ChoiceList($values,$labels);
        return $cl;
    }
}