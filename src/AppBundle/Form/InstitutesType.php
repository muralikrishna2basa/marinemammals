<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class InstitutesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', 'text',array(
            'required' => true
        ));
        $builder->add('name', 'text',array(
            'required' => true
        ));
    }

    public function getName()
    {
        return 'institutestype';
    }
}