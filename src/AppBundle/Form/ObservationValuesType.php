<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


class ObservationValuesType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $ov = $event->getData();
            $form = $event->getForm();

            $pm=$ov->getPmdSeqno();
            $pd= $this
                ->doctrine->getRepository('AppBundle:ParameterDomains')->getParameterDomainsByMethodName($pm->getName());

            if($pm->getVariabletype() == 'continuous'){
                $form->add('value', 'integer',array(
                    'required' => false,
                    'attr'=>array('placeholder'=>$pm->getUnit())
                ));
            }
            elseif($pd){
                $form->add('value', 'choice',array(
                    'empty_value' => 'Select...',
                    'required' => false,
                    'choice_list'=>new ParameterDomainList($this->doctrine,$pm->getName())
                ));
            }
            else{
                $form->add('value', 'text',array(
                    'required' => false
                ));
            }

        });
        $builder->add('valueFlag', 'choice',array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list'=>new CgRefChoiceList($this->doctrine,'VALUE_FLAG')
        ));
    }

    public function getName()
    {
        return 'observationvaluestype';
    }
}