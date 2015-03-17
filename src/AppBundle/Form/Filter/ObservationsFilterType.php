<?php

namespace AppBundle\Form\Filter;

use AppBundle\Entity\Repository\TaxaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use AppBundle\Entity\Repository\StationsRepository;
use AppBundle\Entity\Repository\PlacesRepository;
use AppBundle\Form\ChoiceList\StationsTypeList;
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
        $level2Places=$this->doctrine->getRepository("AppBundle:Places")->getAllBelgianPlacesAtLevel2WithAStation();
        $level3Places=$this->doctrine->getRepository("AppBundle:Places")->getAllBelgianPlacesAtLevel3WithAStation();
        $allPlaces=array_merge($level2Places,$level3Places);

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
        $builder->add('osnType', 'filter_choice', array(
            'required' => false,
            'empty_value' => 'Observations type...',
            'choice_list' => new CgRefChoiceList($this->doctrine, 'OSN_TYPE')
        ));
        $builder->add('stationstype', 'filter_choice', array(
            'required' => false,
            'empty_value' => 'Location type...',
            'choice_list' => new StationsTypeList($this->doctrine)
        ));
        $builder->add('generalPlace', 'filter_entity', array(
            'empty_value' => 'General place...',
            'required' => false,
            'class' => 'AppBundle:Places',
            'property' => 'placeName',
            'choices' =>$level2Places
        ));
        $builder->add('place', 'filter_entity', array(
            'empty_value' => 'Place...',
            'required' => false,
            'class' => 'AppBundle:Places',
            'property' => 'placeName',
            'choices' =>$level3Places
        ));
        $builder->add('stnSeqno', 'filter_entity', array(
            'empty_value' => 'Location...',
            'required' => false,
            'class' => 'AppBundle:Stations',
            'property' => 'placeNameDesc',
            'query_builder' => function (StationsRepository $er) use ($allPlaces) {
                return $er->getAllStationsBelongingToPlacesQb($allPlaces);
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
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
            'has-country'=>false
        ));
    }

    public function getName()
    {
        return 'observationsfiltertype';
    }
}