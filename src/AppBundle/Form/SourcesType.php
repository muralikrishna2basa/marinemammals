<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\SourcesTypeList;

class SourcesType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('name', 'text',array(
            'required' => true
        ));
        $builder->add('type', 'choice', array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list'=>new SourcesTypeList($this->doctrine,'SOURCE_TYPE')
        ));
    }

    public function getName()
    {
        return 'sourcestype';
    }
}