<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\StationsRepository;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObservationsType extends AbstractType
{
    private $doctrine;
    private $additionalOptions;

    public function __construct($doctrine,$additionalOptions)
    {
        $this->doctrine = $doctrine;
        $this->additionalOptions = $additionalOptions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$optionsChild = array();
        //$optionsChild['validation_groups']=
        //array_push($optionsChild, $options['validation_groups']);
        $builder->add('latDec', 'text', array(
            'required' => false,
            'attr' => array('maxlength' => 9)
        ));
        $builder->add('lonDec', 'text', array(
            'required' => false,
            'attr' => array('maxlength' => 10)
        ));
        $builder->add('precisionFlag', 'choice', array(
            'empty_value' => 'Select...',
            'required' => false,
            'choice_list' => new CgRefChoiceList($this->doctrine, 'COORDINATE_FLAG')
        ));
        $builder->add('stnSeqno', 'entity', array(
            'empty_value' => 'Select...',
            'required' => false,
            'class' => 'AppBundle:Stations',
            'property' => 'fullyQualifiedDescription',
            'query_builder' => function (StationsRepository $er) {
                return $er->getAllStationsPlaceQb();
            }
        ));
        $builder->add('isconfidential', 'checkbox', array(
            'required' => false
        ));
        $builder->add('osnType', 'choice', array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list' => new CgRefChoiceList($this->doctrine, 'OSN_TYPE')
        ));
        $builder->add('samplingeffort', 'choice', array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list' => new CgRefChoiceList($this->doctrine, 'SAMPLINGEFFORT')
        ));
        $builder->add('webcommentsEn', 'textarea', array(
            'required' => false
        ));
        $builder->add('webcommentsNl', 'textarea', array(
            'required' => false
        ));
        $builder->add('webcommentsFr', 'textarea', array(
            'required' => false
        ));

        $builder->add('eseSeqno', new EventStatesType($this->doctrine,$this->additionalOptions));

        $builder->add('values', 'collection', array('type' => new EntityValuesType($this->doctrine),
            'options' => array('radio' => false, 'data_class' => 'AppBundle\Entity\ObservationValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));
        $builder->add('singleSource', 'entity', array(
            'empty_value' => 'Select or leave empty...',
            'required' => false,
            'class' => 'AppBundle:Sources',
            'property' => 'name'
        ));
        $builder->add('pfmSeqno', 'entity', array(
            'empty_value' => 'Select or leave empty...',
            'required' => false,
            'class' => 'AppBundle:Platforms',
            'property' => 'name'
        ));
        $builder->add('cpnCode', 'text', array('required' => false));

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $o = $event->getData();
            $form = $event->getForm();
            $sre = $form->get('singleSource')->getData();
            /* if(null ===  $o->getIsconfidential()){
                 $o->setIsconfidential(false);
             }*/
            if (null === $sre) {
                // $this->doctrine->getManager()->remove($sre);
            } else {
                $o->setSingleSource($sre);
                $sre->addOsnSeqno($o);
                $this->doctrine->getManager()->persist($sre);
            }
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'error_mapping' => array(
                'stationOrCoordLegal' => 'stnSeqno',
                'coordLegal' => 'lonDec'
            ),
            'validation_groups' => array()
        ));
    }

    public function getName()
    {
        return 'observationstype';
    }
}