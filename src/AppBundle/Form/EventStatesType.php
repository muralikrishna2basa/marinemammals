<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EventStatesType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventDatetime', 'date', array(
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'
        ));
//add time
        $builder->add('eventDatetimeFlag', 'choice',array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list'=>new CgRefChoiceList($this->doctrine,'DATETIME_FLAG')
        ));
        $builder->add('description', 'textarea', array(
            'required' => false
        ));

        $builder->add('spec2event', new Spec2EventsType($this->doctrine), array('data_class' => 'AppBundle\Entity\Spec2Events'));

    }

    public function getName()
    {
        return 'eventstatestype';
    }
}