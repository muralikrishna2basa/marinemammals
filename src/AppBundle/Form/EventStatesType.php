<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventStatesType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder->add('eventDatetime', 'date', array(
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'
        ));*/
        $builder->add('eventDatetime', new DateTimeType(), array());
//TODO: add time
        $builder->add('eventDatetimeFlag', 'choice',array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list'=>new CgRefChoiceList($this->doctrine,'DATETIME_FLAG')
        ));
        $builder->add('description', 'textarea', array(
            'required' => false
        ));
        $builder->add('observers', 'collection', array('type' => new Event2PersonsType($this->doctrine),
            'options' => array('data_class' => 'AppBundle\Entity\Event2Persons'),
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'by_reference' => false
        ));
        $builder->add('gatherers', 'collection', array('type' => new Event2PersonsType($this->doctrine),
            'options' => array('data_class' => 'AppBundle\Entity\Event2Persons'),
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'by_reference' => false
        ));


        $builder->add('spec2event', new Spec2EventsType($this->doctrine));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'AppBundle\Entity\EventStates',
            ));
    }

    public function getName()
    {
        return 'eventstatestype';
    }
}