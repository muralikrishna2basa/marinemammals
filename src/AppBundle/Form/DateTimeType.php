<?php

namespace AppBundle\Form;

use AppBundle\Validator\Constraints\DateRange;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use AppBundle\Form\DataTransformer\DateTimeToDateTimeArrayTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Time;

class DateTimeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', 'date', array(
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'model_timezone'=>'Europe/Paris'
        ));
        $builder->add('time', 'time', array(
            'input'  => 'datetime',
            'widget' => 'single_text',
            'required'=>false
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