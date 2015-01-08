<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\PlacesRepository;

class PlacesType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text',array(
            'required' => true
        ));
        $builder->add('type', 'choice', array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list'=>new CgRefChoiceList($this->doctrine,'PLACE_TYPE')
        ));
        $builder->add('pceSeqno', 'entity', array(
            'empty_value' => 'Select...',
            'required' => true,
            'class' => 'AppBundle:Places',
            'property' => 'fullyQualifiedName',
            'query_builder'=> function(PlacesRepository $er){return $er->getAllPlacesParent();}
        ));
    }

    public function getName()
    {
        return 'placestype';
    }
}