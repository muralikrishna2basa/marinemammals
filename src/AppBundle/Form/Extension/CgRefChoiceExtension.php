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
use \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

use Symfony\Component\Form\FormEvents;

class CgRefChoiceExtension extends AbstractTypeExtension
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
            $options['choices']=$choices;
            $options['choice_list']=$cl;
/*            $builder->getForm()->getParent()->add('areaType', 'choice', array(
                'empty_value' => $options['empty_value'],
                'required' => $options['required'],
                'choice_list'=>$cl));
            $builder->add('areaType', 'choice', array(
                'empty_value' => $options['empty_value'],
                'required' => $options['required'],
                'choice_list'=>$cl
            ));*/
}
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

            \Doctrine\Common\Util\Debug::dump($choices);
            \Doctrine\Common\Util\Debug::dump('<br /><br />');
            \Doctrine\Common\Util\Debug::dump($view->vars['choices']);
            $view->vars['choices'] = array_merge($choices, $view->vars['choices']);
            $options['choices']=$view->vars['choices'];


            \Doctrine\Common\Util\Debug::dump('<br /><br />');
            \Doctrine\Common\Util\Debug::dump($view->vars['choices']);
        }
    }
    }