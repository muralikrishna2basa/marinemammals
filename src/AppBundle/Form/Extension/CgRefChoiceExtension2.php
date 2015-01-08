<?php
namespace AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\View\ChoiceView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use \Symfony\Component\Validator\Constraints\Choice;
use \Symfony\Component\Validator\Constraints\NotBlank;
use \Symfony\Component\Validator\Constraints\Collection;

use Symfony\Component\Form\FormEvents;

class CgRefChoiceExtension2 extends AbstractTypeExtension
{


    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getExtendedType()
    {
        return 'choice';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //$resolver->setDefaults(array('domain'=>null));
        $resolver->setOptional(array('domain'));
/*        $resolver->setDefaults(array(
            'validation_groups' => false,
            'validation_constraint' => false,
        ));
*/
        $collectionConstraint = new Collection(array(
            'areaType' => array(
                new Choice(array(
                        'choices' => array('At sea','Beach','Harbour','Inland waters'),
                        'message' => 'form.quiz.falscheantwort',
                        'strict' => true,
                    )
                ),
                new NotBlank()
            )
        ));

        $resolver->setDefaults(array(
            'validation_constraint' => $collectionConstraint,
            'csrf_protection' => false,
            'validation_groups' => function(){
                    return array('At sea','Beach','Harbour','Inland waters');
            },
            'choices'=>array('At sea','Beach','Harbour','Inland waters')
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SUBMIT, function ($event) {
            $event->stopPropagation();
        }, 900); // Always set a higher priority than ValidationListener
        $builder->add('choices',array('At sea','Beach','Harbour','Inland waters'));


    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('domain', $options)) {
                $types = $this
                    ->doctrine->getRepository('AppBundle:CgRefCodes')->getRefCodes($options['domain']);
                $i = 0;
                $choices=array();
                foreach ($types as $type) {
                    $data = $type->getRvLowValue();
                    $value = $type->getRvLowValue();
                    $label = $type->getRvMeaning();
                    $cv=new ChoiceView($data,$value,$label); //data,value,label
                    $choices[$i]=$cv;
                    $i++;
                }
            $options['choices']=$view->vars['choices'];
                \Doctrine\Common\Util\Debug::dump($choices);
                \Doctrine\Common\Util\Debug::dump('<br /><br />');
                \Doctrine\Common\Util\Debug::dump($view->vars['choices']);
                $view->vars['choices'] = array_merge($choices, $view->vars['choices']);
                \Doctrine\Common\Util\Debug::dump('<br /><br />');
                \Doctrine\Common\Util\Debug::dump($view->vars['choices']);
        }
    }
}