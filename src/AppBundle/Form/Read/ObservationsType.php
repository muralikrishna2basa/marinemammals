<?php

namespace AppBundle\Form\Read;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\CountryList;
use AppBundle\Form\ChoiceList\StationsList;
use AppBundle\Form\ChoiceList\StationsTypeList;
use AppBundle\Form\ChoiceList\TaxaList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObservationsType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventDatetimeStart', 'date', array(
            'required' => false,
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'));
        $builder->add('eventDatetimeStop', 'date', array(
            'required' => false,
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'));
        $builder->add('country', 'choice', array(
            'required' => false,
            'empty_value' => 'Country...',
            'choice_list' => new CountryList($this->doctrine)
        ));
        $builder->add('stationtype', 'choice', array(
            'required' => false,
            'empty_value' => 'Station location...',
            'choice_list' => new StationsTypeList($this->doctrine)
        ));
        $builder->add('station', 'choice', array(
            'required' => false,
            'empty_value' => 'Station...',
            'choice_list' => new StationsList($this->doctrine)
        ));
        $builder->add('species', 'choice', array(
            'required' => false,
            'empty_value' => 'Species...',
            'choice_list' => new TaxaList($this->doctrine)
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array());
    }

    public function getName()
    {
        return 'observationsreadtype';
    }
}