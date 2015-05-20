<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\DataTransformer\SeqnoToSampleTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SamplesSelectorType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new SeqnoToSampleTransformer($this->doctrine);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected sample does not exist', //'attr'=>array('min'=>'0')
            'required'=>false,
            'validation_groups' => array()
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'sample_selector';
    }
}