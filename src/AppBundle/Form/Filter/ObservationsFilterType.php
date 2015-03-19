<?php

namespace AppBundle\Form\Filter;

use AppBundle\Entity\Repository\TaxaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use AppBundle\Entity\Repository\StationsRepository;
use AppBundle\Entity\Repository\PlacesRepository;
use AppBundle\Form\ChoiceList\StationsTypeList;
use AppBundle\Form\ChoiceList\CountryList;
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
        $onlyBelgium=$options['onlyBelgium'];
        if($onlyBelgium){
            $generalPlaces=$this->doctrine->getRepository("AppBundle:Places")->getAllBelgianPlacesAtLevel2();
            $level3Places=$this->doctrine->getRepository("AppBundle:Places")->getAllBelgianPlacesAtLevel3();
            $level4Places=$this->doctrine->getRepository("AppBundle:Places")->getAllBelgianPlacesAtLevel4WithAStation();
        }
        else{
            $generalPlaces=$this->doctrine->getRepository("AppBundle:Places")->getAllPlacesAtLevel3();
            $level3Places=$this->doctrine->getRepository("AppBundle:Places")->getAllPlacesAtLevel4();
            $level4Places=$this->doctrine->getRepository("AppBundle:Places")->getAllPlacesAtLevel5WithAStation();
        }
        $places=array_merge($level3Places,$level4Places);
        $allPlaces=array_merge($generalPlaces,$places);

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
        if(!$onlyBelgium){
            $builder->add('country', 'filter_choice', array(
                'required' => false,
                'empty_value' => 'Country...',
                'choice_list' => new CountryList($this->doctrine)
            ));
        }
        $builder->add('generalPlace', 'filter_entity', array(
            'empty_value' => 'General place...',
            'required' => false,
            'class' => 'AppBundle:Places',
            'property' => 'placeName',
            'choices' =>$generalPlaces
        ));
        $builder->add('place', 'filter_entity', array(
            'empty_value' => 'Place...',
            'required' => false,
            'class' => 'AppBundle:Places',
            'property' => 'placeName',
            'choices' =>$places
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
            'onlyBelgium'=>true
        ));
    }

    public function getName()
    {
        return 'observationsfiltertype';
    }
}