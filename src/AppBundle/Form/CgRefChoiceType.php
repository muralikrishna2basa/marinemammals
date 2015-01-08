<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use \Symfony\Component\Validator\Constraints\Choice;
use \Symfony\Component\Validator\Constraints\NotBlank;
use \Symfony\Component\Validator\Constraints\Collection;

use Symfony\Component\Form\FormEvents;

class CgRefChoiceType extends AbstractType
//Extension
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getName()
    {
        return 'CgRefChoice';
    }

    public function getParent()
    {
        return 'choice';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //$resolver->setDefaults(array('domain'=>null));
        $resolver->setOptional(array('domain','empty_value','required'));
/*        $resolver->setDefaults(array(
            'validation_groups' => false,
            'validation_constraint' => false,
        ));

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
*/
/*        $resolver->setDefaults(array(
            'compound' => true,
        ));*/
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (array_key_exists('domain', $options)) {
            $types = $this
                ->doctrine->getRepository('AppBundle:CgRefCodes')->getRefCodes($options['domain']);
            //$i = 0;
            $choices=array();
            $labels=array();
            foreach ($types as $type) {
                //$data = $type->getRvLowValue();
                $value = $type->getRvLowValue();
                $label = $type->getRvMeaning();
                array_push($choices,$value);
                array_push($labels,$label);
            }
            $cl=new ChoiceList($choices,$labels);
/*            $builder->add('areaType', 'choice', array(
                'empty_value' => $options['empty_value'],
                'required' => $options['required'],
                'choices'=>$choices
            ));
*/
            \Doctrine\Common\Util\Debug::dump($cl);
            \Doctrine\Common\Util\Debug::dump('<br /><br />');
            \Doctrine\Common\Util\Debug::dump($builder->getAttributes());
            \Doctrine\Common\Util\Debug::dump($options);

            $builder->setAttribute('choices',$cl);
            $options['choices']=$choices;

            \Doctrine\Common\Util\Debug::dump($options['choices']);
/*
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($choices,$options) {
                $form = $event->getForm();
                $form->add('areaType', 'choice', array(
                    'empty_value' => $options['empty_value'],
                    'required' => $options['required'],
                    'choices'=>$choices
                ));
            });
*/
        }
    }
/*
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
    }*/
}