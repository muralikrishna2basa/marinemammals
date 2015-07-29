<?php

namespace AppBundle\Form;

use AppBundle\Entity\Repository\TaxaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class SpecimensType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('scnNumber', 'integer',array(
            'required' => true,
            'attr'=>array('min'=>'0')
        ));
        $builder->add('sex', 'choice',array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list'=>new CgRefChoiceList($this->doctrine,'SEX')
        ));
        $builder->add('rbinsTag', 'text',array(
            'required' => false
        ));
        $builder->add('necropsyTag', 'text',array(
            'required' => false
        ));
        $builder->add('otherTag', 'text',array(
            'required' => false
        ));
        $builder->add('name', 'text',array(
            'required' => false
        ));
        $builder->add('identificationCertainty', 'checkbox', array(
            'required' => false
        ));
        $builder->add('txnSeqno', 'entity', array(
            'empty_value' => 'Select...',
            'required' => true,
            'class' => 'AppBundle:Taxa',
            'query_builder'=> function(TaxaRepository $er){return $er->getAllEuropeanTaxaQb();},
            'property' => 'canonicalName'
        ));
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($builder) {
            $form = $event->getForm();
            $form->get('identificationCertainty')->getData();
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Specimens',
            'cascade_validation' => true,
            'error_bubbling' => false,
            'error_mapping'=>array('scnNumberLegal'=>'scnNumber','sexLegal'=>'sex')
        ));
    }

    public function getName()
    {
        return 'specimenstype';
    }
}