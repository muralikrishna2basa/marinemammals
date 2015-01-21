<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use AppBundle\Form\ChoiceList\ParameterDomainList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntityValuesType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $required = ($options['required'] === 'true');
            $defaultValue = $options['default_value'];
            $sv = $event->getData();
            $form = $event->getForm();
            $pm = $sv->getPmdSeqno();
            $pd = $this
                ->doctrine->getRepository('AppBundle:ParameterDomains')->getParameterDomainsByMethodName($pm->getName());
            if ($pm->getVariabletype() === 'continuous') {
                $form->add('value', 'integer', array(
                    'required' => $required,
                    'attr' => array('placeholder' => $pm->getUnit())
                ));
            } elseif ($pd) {
                if ($options['radio'] === 'true') {
                    $form->add('value', 'choice', array(
                        'required' => $required,
                        'choice_list' => new ParameterDomainList($this->doctrine, $pm->getName()),
                        'expanded' => true,
                        'multiple' => false,
                        'attr'=>array('default_value'=>'unknown')
                    ));
                    //$sv->setValue($defaultValue); //causes problems with constraint that >1 animals can't have values!!!
                } else {
                    $form->add('value', 'choice', array(
                        'placeholder' => 'Select...',
                        'required' => $required,
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
            $required = ($options['required'] === 'true');
            $builder->add('valueFlag', 'choice', array(
                'placeholder' => 'Select...',
                'required' => $required,
                'choice_list' => new CgRefChoiceList($this->doctrine, 'VALUE_FLAG')
            ));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'AppBundle\Entity\EntityValues',
                'radio'=>'false',
                'required'=>'false',
                'default_value'=>'unknown'
            ));
    }

    public function getName()
    {
        return 'entityvaluestype';
    }
}