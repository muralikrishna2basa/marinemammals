<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use AppBundle\Form\ChoiceList\ParameterDomainList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpecimenValuesType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $sv = $event->getData();
            $form = $event->getForm();

            $pm = $sv->getPmdSeqno();
            $pd = $this
                ->doctrine->getRepository('AppBundle:ParameterDomains')->getParameterDomainsByMethodName($pm->getName());
            if ($pm->getVariabletype() === 'continuous') {
                $form->add('value', 'integer', array(
                    'required' => false,
                    'attr' => array('placeholder' => $pm->getUnit())
                ));
            } elseif ($pd) {
                if ($options['radio'] === 'true') {
                    $form->add('value', 'choice', array(
                        'required' => true,
                        'choice_list' => new ParameterDomainList($this->doctrine, $pm->getName()),
                        'expanded' => true,
                        'multiple' => false
                    ));
                } else {
                    $form->add('value', 'choice', array(
                        'empty_value' => 'Select...',
                        'required' => false,
                        'choice_list' => new ParameterDomainList($this->doctrine, $pm->getName())
                    ));
                }
            } else {
                $form->add('value', 'text', array(
                    'required' => false
                ));
            }

        });
        if ($options['radio'] === 'false') {
            $builder->add('valueFlag', 'choice', array(
                'empty_value' => 'Select...',
                'required' => false,
                'choice_list' => new CgRefChoiceList($this->doctrine, 'VALUE_FLAG')
            ));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'AppBundle\Entity\SpecimenValues',
                'radio'=>'false'
            ));
    }

    public function getName()
    {
        return 'specimenvaluestype';
    }
}