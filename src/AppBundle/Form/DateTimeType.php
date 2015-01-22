<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\DataTransformer\DateTimeToDateTimeArrayTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateTimeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', 'date', array(
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'error_bubbling' => true
        ));
        $builder->add('time', 'time', array(
            'input'  => 'datetime',
            'widget' => 'single_text',
            'error_bubbling' => true
        ));
        $builder->addViewTransformer(new DateTimeToDateTimeArrayTransformer());
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