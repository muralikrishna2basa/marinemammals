<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\StationsRepository;
use AppBundle\Form\ObservationValuesType;
use AppBundle\Form\EventStatesType;

class ObservationsType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('latDeg', 'number', array(
            'required' => true,
            'precision'=>6
        ));
        $builder->add('lonDeg', 'number', array(
            'required' => true,
            'precision'=>6
        ));
        $builder->add('precisionFlag', 'choice', array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list' => new CgRefChoiceList($this->doctrine, 'COORD_PRECISION_FLAG')
        ));
        $builder->add('stnSeqno', 'entity', array(
            'empty_value' => 'Select...',
            'required' => true,
            'class' => 'AppBundle:Stations',
            'property' => 'fullyQualifiedName',
            'query_builder' => function (StationsRepository $er) {
                return $er->getAllStationsPlaceQb();
            }
        ));
        $builder->add('isconfidential', 'checkbox', array(
            'required' => false
        ));
        $builder->add('osnType', 'choice', array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list' => new CgRefChoiceList($this->doctrine, 'OSN_TYPE')
        ));
        $builder->add('samplingeffort', 'choice', array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list' => new CgRefChoiceList($this->doctrine, 'SAMPLINGEFFORT')
        ));
        $builder->add('webcommentsEn', 'textarea', array(
            'required' => false
        ));
        $builder->add('webcommentsNl', 'textarea', array(
            'required' => false
        ));
        $builder->add('webcommentsFr', 'textarea', array(
            'required' => false
        ));

        $builder->add('eseSeqno', new EventStatesType($this->doctrine), array('data_class' => 'AppBundle\Entity\EventStates'));

        $builder->add('observationValues', 'collection', array('type' => new ObservationValuesType($this->doctrine),
            'options' => array('data_class' => 'AppBundle\Entity\ObservationValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));
    }

    public function getName()
    {
        return 'observationstype';
    }
}