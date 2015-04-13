<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\GroupsRepository;
use AppBundle\Form\ChoiceList\GroupsList;
use AppBundle\Form\DataTransformer\SeqnoToGroupTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupsSelectType extends AbstractType
{

    private $doctrine;
    private $choices;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;

        $groups = $this->doctrine->getRepository('AppBundle:Groups')->getAll();
        foreach ($groups as $group)
        {
            // choices[key] = label
            $this->choices[$group->getName()] = $group->getName();
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'entity', array(
            'class' => 'AppBundle:Groups',
            'property' => 'name',
            'label'=>'Group',
            'empty_value' => 'Select...',
            'required' => true,
            'query_builder' => function (GroupsRepository $er) {
                return $er->getAllGroupsQb();
            }
        ));
        /*$builder->add('name', 'choice', array(
            'label'=>'Group',
            'empty_value' => 'Select...',
            'required' => true,
            'choices' => $this->choices
        ))*/
        ;
        /*$transformer = new SeqnoToGroupTransformer($this->doctrine);
        $builder->addModelTransformer($transformer);*/
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Groups'
        ));
        /*$resolver->setDefaults(array(
            'choices' => $this->choices,
        ));*/
        /*$resolver->setDefaults(array(
            'choice_list' => new GroupsList($this->doctrine)
        ));*/
    }

    public function getName()
    {
        return 'group_select';
    }

    /*public function getParent()
    {
        return 'choice';
    }*/
}