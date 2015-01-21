<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


class Spec2EventsType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('scnSeqnoExisting', 'specimen_selector', array('property_path' => 'scnSeqno'));
        $builder->add('scnSeqnoNew', new SpecimensType($this->doctrine), array('property_path' => 'scnSeqno'));

        $builder->add('circumstantialValues', 'collection', array('type' => new EntityValuesType($this->doctrine),
            'options' => array('radio' => 'false', 'required' => 'true', 'data_class' => 'AppBundle\Entity\SpecimenValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));
        $builder->add('measurementValues', 'collection', array('type' => new EntityValuesType($this->doctrine),
            'options' => array('radio' => 'false', 'required' => 'false', 'data_class' => 'AppBundle\Entity\SpecimenValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));
        $builder->add('pathologyValues', 'collection', array('type' => new EntityValuesType($this->doctrine),
            'options' => array('radio' => 'true', 'required' => 'true', 'default_value' => 'unknown', 'data_class' => 'AppBundle\Entity\SpecimenValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($builder) {
            $s2e = $event->getData();
            $form = $event->getForm();

            if (null !== $form->get('scnSeqnoExisting')->getData()) {
                $specimen = $form->get('scnSeqnoExisting')->getData();
                $s2e->setScnSeqno($specimen);
                $this->doctrine->getManager()->persist($specimen);
            } elseif (null !== $form->get('scnSeqnoNew')->getData()) {
                //$specimen = new Specimens();
                $specimen = $form->get('scnSeqnoNew')->getData();
                $s2e->setScnSeqno($specimen);
                $this->doctrine->getManager()->persist($specimen);
            } else throw new \Symfony\Component\Form\Exception\LogicException('no specimen given');
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'AppBundle\Entity\Spec2Events',
            ));
    }

    public function getName()
    {
        return 'spec2eventstype';
    }
}