<?php

namespace AppBundle\Form\Filter;

use AppBundle\Entity\Repository\TaxaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\CountryList;
use AppBundle\Entity\Repository\StationsRepository;
use AppBundle\Form\ChoiceList\StationsTypeList;
use AppBundle\Form\ChoiceList\TaxaList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObservationsFilterType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventDatetimeStart', 'filter_date', array(
            'required' => false,
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'));
        $builder->add('eventDatetimeStop', 'filter_date', array(
            'required' => false,
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'));
        $builder->add('country', 'filter_choice', array(
            'required' => false,
            'empty_value' => 'Country...',
            'choice_list' => new CountryList($this->doctrine)
        ));
        $builder->add('stationtype', 'filter_choice', array(
            'required' => false,
            'empty_value' => 'Station location...',
            'choice_list' => new StationsTypeList($this->doctrine)
        ));
        $builder->add('stnSeqno', 'filter_entity', array(
            'empty_value' => 'Station...',
            'required' => false,
            'class' => 'AppBundle:Stations',
            'property' => 'fullyQualifiedName',
            'query_builder' => function (StationsRepository $er) {
                return $er->getAllStationsPlaceQb();
            }
        ));
        $builder->add('txnSeqno', 'filter_entity', array(
            'empty_value' => 'Species...',
            'required' => false,
            'class' => 'AppBundle:Taxa',
            'property' => 'fullyQualifiedName',
            'query_builder' => function (TaxaRepository $er) {
                return $er->getAllTaxaQb();
            }
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }

    public function getName()
    {
        return 'observationsfiltertype';
    }
}