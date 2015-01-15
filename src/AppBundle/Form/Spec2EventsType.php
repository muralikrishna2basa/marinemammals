<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\DataTransformer\SeqnoToSpecimenTransformer;
use AppBundle\Form\DataTransformer\SpecimensTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class Spec2EventsType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new SpecimensTransformer($this->doctrine->getManager());

        $builder
            ->add(
                $builder->create('scnSeqno',new SpecimensSelectOrAddType( $this->doctrine))
                    ->addViewTransformer($transformer));
        //$builder->add('scnSeqno', 'specimen_selector');
        //$builder->add('scnSeqno', new SpecimensType($this->doctrine), array('data_class' => 'AppBundle\Entity\Specimens'));

        //$builder->add('values', 'collection', array('type' => new SpecimenValuesType($this->doctrine),
        //    'options' => array('data_class' => 'AppBundle\Entity\SpecimenValues'),
        //    'allow_delete' => true,
        //    'delete_empty' => true
        //));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'AppBundle\Entity\Specimens',
            ));
    }

    public function getName()
    {
        return 'spec2eventstype';
    }
}