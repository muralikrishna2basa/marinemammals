<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\CgRefChoiceList;

class SpecimensType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('scnNumber', 'integer',array(
            'required' => true
        ));
        $builder->add('sex', 'choice',array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list'=>new CgRefChoiceList($this->doctrine,'SEX')
        ));
        $builder->add('rbinsTag', 'text',array(
            'required' => false
        ));
        $builder->add('necropsyTag', 'text',array(
            'required' => false
        ));
        $builder->add('specieFlag', 'checkbox', array(
            'required' => false
        ));
        $builder->add('txnSeqno', 'entity', array(
            'empty_value' => 'Select...',
            'required' => true,
            'class' => 'AppBundle:Taxa',
            'property' => 'canonicalName'
        ));
    }

    public function getName()
    {
        return 'specimenstype';
    }
}