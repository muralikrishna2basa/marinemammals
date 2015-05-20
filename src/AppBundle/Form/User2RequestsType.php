<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\CgRefChoiceList;

class User2RequestsType extends AbstractType
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('p2rType', 'choice', array('empty_value' => 'Select...', 'required' => true, 'choice_list' => new CgRefChoiceList($this->doctrine, 'P2R_TYPE')));
    }

    public function getName()
    {
        return 'user2requeststype';
    }
}