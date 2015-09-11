<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use AppBundle\Entity\Repository\SamplesRepository;
use AppBundle\Form\DataTransformer\SeqnoJSONArrayToSampleArrayTransformer;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RequestLoansType extends AbstractType
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder->add('speSeqno', 'entity', array(
            'class' => 'AppBundle:Samples',
            'property' => 'seqno',
            'label'=>'Seqno',
            'empty_value' => 'Select...',
            'required' => true//,
            //'query_builder' => function (SamplesRepository $er) {
            //    return $er->getPartialSamplesQb();
            //}
        ));*/
        $builder->add('studyDescription', 'textarea', array(
            'required' => true
        ));
        $builder->add('user2Requests', new User2RequestsType($this->doctrine));
      /*  $builder->add('speSeqno', 'collection', array('type' => new SamplesSelectorType($this->doctrine),
            'options' => array('data_class' => null),
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'by_reference' => false,
            'prototype_name' => '__samples_name__'
        ));*/

        //$transformer = new SeqnoJSONArrayToSampleArrayTransformer($this->doctrine);
        /*$builder->add($builder->create('speSeqno', 'hidden', array())->addViewTransformer($transformer)
        );*/

        /*$builder->add('seqnoString', 'hidden', array(
        ));
        $builder->addModelTransformer($transformer);

        $builder->addViewTransformer($transformer);*/

        /*$builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($doctrine) {
            $requestLoan = $event->getData();
            $form = $event->getForm();
            $requestLoan->
        });*/
    }

    public function getName()
    {
        return 'requestloanstype';
    }
}