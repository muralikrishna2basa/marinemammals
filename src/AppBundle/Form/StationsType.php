<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\PlacesRepository;
use AppBundle\Form\ChoiceList\CgRefChoiceList;

class StationsType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', 'text',array(
            'required' => true
        ));
        $builder->add('areaType', 'choice', array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list'=>new CgRefChoiceList($this->doctrine,'STN_AREA_TYPE')
        ));
        $builder->add('description', 'text',array(
            'required' => false
        ));
        $builder->add('latDec', 'text',array(
            'required' => true,
            'attr'=>array('maxlength'=>9)
        ));
        $builder->add('lonDec', 'text',array(
            'required' => true,
            'attr'=>array('maxlength'=>10)
        ));
        $builder->add('pceSeqno', 'entity', array(
            'empty_value' => 'Select...',
            'required' => true,
            'class' => 'AppBundle:Places',
            'property' => 'fullyQualifiedName',
            'query_builder'=> function(PlacesRepository $er){return $er->getAllPlacesParentQb();}

        ));
    }

    public function getName()
    {
        return 'stationstype';
    }
}