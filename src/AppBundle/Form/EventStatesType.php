<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use AppBundle\Entity\EventStates;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class EventStatesType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventDatetime', new DateTimeType(), array());
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
            'by_reference' => false,
            'prototype_name'=>'__observers_name__'
        ));
        $builder->add('gatherers', 'collection', array('type' => new Event2PersonsType($this->doctrine),
            'options' => array('data_class' => 'AppBundle\Entity\Event2Persons'),
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'by_reference' => false,
            'prototype_name'=>'__gatherers_name__'
        ));
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $e = $event->getData();
            $form = $event->getForm();
            $observers = $form->get('observers')->getData();
            foreach ($observers as $ob) {
                $ob->setE2pType(EventStates::OBSERVED);
                $ob->setEseSeqno($e);
            }
            $gatherers = $form->get('gatherers')->getData();
            foreach ($gatherers as $gb) {
                $gb->setE2pType(EventStates::GATHERED);
                $gb->setEseSeqno($e);
            }
        });
        $builder->add('spec2events', new Spec2EventsType($this->doctrine));
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