<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\DataTransformer\SeqnoToSpecimenTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpecimensSelectorType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new SeqnoToSpecimenTransformer($this->doctrine);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected specimen does not exist', //'attr'=>array('min'=>'0')
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'specimen_selector';
    }
}