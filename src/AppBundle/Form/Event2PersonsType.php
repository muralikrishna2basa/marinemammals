<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\PersonsRepository;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Event2PersonsType extends AbstractType
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('psnSeqno', 'entity', array(
            'class' => 'AppBundle:Persons',
            'property' => 'fullyQualifiedName',
            'empty_value' => 'Select or leave empty...',
            'required' => false,
            'query_builder' => function (PersonsRepository $er) {
                return $er->getAllPersonsQb();
            }
        ));
       /* $builder->add('e2pType', 'choice', array(
            'empty_value' => 'Select or leave empty...',
            'required' => false,
            'choice_list'=>new CgRefChoiceList($this->doctrine,'TYPE_EVENT2PERSON')
        ));*/
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event2Persons'
        ));
    }

    public function getName()
    {
        return 'event2personstype';
    }
}