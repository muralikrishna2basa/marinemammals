<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class SpecimensSelectOrAddType extends AbstractType
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*         $builder
                    //reward selector (for selecting an existing)
                   ->add('SpecimensSelected','entity',array(
                        'class' => 'AppBundle:Specimens',
                        'property' => 'fullyQualifiedName'
                    ));*/

            //reward editor (for new option)
            //->add('AddNewReward','checkbox',array( 'label_render'  => false, 'help_inline' => 'Add a new reward'))

            //reward editor (for new option)
        $builder->add('SpecimensNew',new SpecimensType($this->doctrine));
//, array('data_class' => 'AppBundle\Entity\Specimens')

    }

    public function getName()
    {
        return 'specimensselectoraddtype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'AppBundle\Form\DataTransformer\SpecimensSelector',
            'validation_groups' =>  array('Creation'),
        ));
    }

}