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

    private function buildBasicForm(FormEvent $event, array $options)
    {
        $options2 = array();

        $ev = $event->getData();
        if($ev->getValueRequired() !== null){
            $valueRequired = $ev->getValueRequired();
        }
       /* else{
            $valueRequired =true;
        }*/
        if($ev->getHasFlag() !== null){
            $hasFlag = $ev->getHasFlag();
        }
        /*else{
            $hasFlag=true;
        }*/
        $valueFlagRequired=($hasFlag && $valueRequired);
        //if ($valueRequired && $options['required']) {
        if ($valueRequired) {
            $options2['required'] = true;
        }
        else{
            $options2['required'] = false;
        }
        $form = $event->getForm();
        $pm = $ev->getPmdSeqno();
        $pd = $this
            ->doctrine->getRepository('AppBundle:ParameterDomains')->getParameterDomainsByMethodName($pm->getName());
        if ($pm->getVariabletype() === 'continuous') {
            $options2 = array_merge($options2, array(
                'attr' => array('placeholder' => $pm->getUnit(), 'min' => 0)
            ));
            $form->add('value', 'integer', $options2);
        } elseif ($pd) {
            if ($options['radio'] === true) {
                $options2 = array_merge($options2, array(
                    'choice_list' => new ParameterDomainList($this->doctrine, $pm->getName()),
                    'expanded' => true,
                    'multiple' => false
                ));
                $form->add('value', 'choice', $options2);

            } else {
                $options2 = array_merge($options2, array(
                    'placeholder' => 'Select...',
                    'choice_list' => new ParameterDomainList($this->doctrine, $pm->getName())));
                $form->add('value', 'choice', $options2);
            }
            if($ev->getValue() === null){
                $ev->setValue($options['default_value']);
            }
        } else {
            $form->add('value', 'text', array(
                'required' => false
            ));
        }
        if ($hasFlag === true) {
            $form->add('valueFlag', 'choice', array(
                'placeholder' => 'Select...',
                'required' => $valueFlagRequired,
                'choice_list' => new CgRefChoiceList($this->doctrine, 'VALUE_FLAG')
            ));
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $this->buildBasicForm($event, $options);
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'AppBundle\Entity\EntityValues',
                'radio' => false,
               // 'required' => false,
                'default_value' => 'unknown',
                'error_bubbling' => false,
                'error_mapping' => array('valueFlagLegal' => 'valueFlag', 'valueUnwantedLegal' => 'value', 'valueLegal' => 'value','valueUnwantedLegal2' => 'value')
            ));
    }

    public function getName()
    {
        return 'entityvaluestype';
    }
}