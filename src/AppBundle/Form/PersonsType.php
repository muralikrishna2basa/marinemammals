<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PersonsType extends AbstractType
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', 'text', array('required' => true));
        $builder->add('lastName', 'text', array('required' => true));
        $builder->add('iteSeqno', 'entity', array(
            'class' => 'AppBundle:Institutes',
            'property' => 'code',
            'empty_value' => 'Select or leave empty...',
            'required' => false
        ));
        $builder->add('address', 'text', array('required' => false));
        $builder->add('phoneNumber', 'text', array('required' => false));
        $builder->add('email', 'text', array('required' => false));
        $builder->add('sex', 'choice',array('empty_value' => 'Select...','required' => true,'choice_list'=>new CgRefChoiceList($this->doctrine,'SEX')));
        $builder->add('title', 'choice',array('empty_value' => 'Select or leave empty...','required' => false,'choice_list'=>new CgRefChoiceList($this->doctrine,'PSN_TITLE')));
        $builder->add('idodId', 'text', array('required' => false));
    }

    public function getName()
    {
        return 'personstype';
    }
}