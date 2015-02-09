<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use AppBundle\Form\DataTransformer\DateTimeToDateTimeArrayTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateTimeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', 'date', array(
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'
        ));
        $builder->add('time', 'time', array(
            'input'  => 'datetime',
            'widget' => 'single_text'
        ));
        $builder->addViewTransformer(new DateTimeToDateTimeArrayTransformer());
       /* $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
            $timeField=$event->getForm()->get('time');
            //if(\Appbundle\Entity\EventStates::isTime($timeField->getData())){\Symfony\Component\Validator\Constraints\TimeValidator
            if(\Appbundle\Entity\EventStates::isTime($timeField->getData())){
            $e =new FormError('This value should be a valid time');
                $timeField->addError($e);
            }
        });*/
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'error_bubbling' => false
            ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'datetimetype';
    }
}