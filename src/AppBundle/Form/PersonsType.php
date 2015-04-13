<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\GroupsRepository;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class PersonsType extends AbstractType
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', 'text', array('required' => true));
        $builder->add('lastName', 'text', array('required' => true));
        $builder->add('iteSeqno', 'entity', array(
            'class' => 'AppBundle:Institutes',
            'property' => 'code',
            'empty_value' => 'Select or leave empty...',
            'required' => false
        ));
        $builder->add('address', 'text', array('required' => false));
        $builder->add('phoneNumber', 'text', array('required' => false));
        $builder->add('email', 'text', array('required' => false));
        $builder->add('sex', 'choice', array('empty_value' => 'Select...', 'required' => true, 'choice_list' => new CgRefChoiceList($this->doctrine, 'SEX')));
        $builder->add('title', 'choice', array('empty_value' => 'Select or leave empty...', 'required' => false, 'choice_list' => new CgRefChoiceList($this->doctrine, 'PSN_TITLE')));
        $builder->add('idodId', 'integer', array('required' => false));
        /*$builder->add('grpName', 'collection', array('type' => 'group_select',
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true
        ));*/
        $builder->add('grpName', 'entity', array(
            'class' => 'AppBundle:Groups',
            'property' => 'name',
            'label'=>'Group',
            'empty_value' => 'Select...',
            'multiple' => true,
            'expanded' => true,
            'required' => true,
            /*'query_builder' => function (GroupsRepository $er) {
                return $er->getAllGroupsQb();
            }*/
        ));
        /*$builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($builder) {
            $form = $event->getForm();
            $p = $event->getData();
            $grp=$form->get('grpName')->getData();
            $p->addGrpName($grp);
        });*/
    }

    public function getName()
    {
        return 'personstype';
    }
}