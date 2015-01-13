<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Spec2EventsType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('scnSeqno', new SpecimensType($this->doctrine), array('data_class' => 'AppBundle\Entity\Specimens'));

        $builder->add('specimenValues', 'collection', array('type' => new SpecimenValuesType($this->doctrine),
            'options' => array('data_class' => 'AppBundle\Entity\SpecimenValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));
    }

    public function getName()
    {
        return 'spec2eventstype';
    }
}