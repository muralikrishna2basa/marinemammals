<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\StationsRepository;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ObservationsType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('latDec', 'number', array(
            'required' => true,
            'precision' => 6
        ));
        $builder->add('lonDec', 'number', array(
            'required' => true,
            'precision' => 6
        ));
        $builder->add('precisionFlag', 'choice', array(
            'empty_value' => 'Select...',
            'required' => true,
            'choice_list' => new CgRefChoiceList($this->doctrine, 'COORD_PRECISION_FLAG')
        ));
        $builder->add('stnSeqno', 'entity', array(
            'empty_value' => 'Select...',
            'required' => true,
            'class' => 'AppBundle:Stations',
            'property' => 'fullyQualifiedName',
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

        $builder->add('eseSeqno', new EventStatesType($this->doctrine));

        $builder->add('values', 'collection', array('type' => new EntityValuesType($this->doctrine),
            'options' => array('radio' => 'false', 'required' => 'false', 'data_class' => 'AppBundle\Entity\ObservationValues'),
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
            $sre=$form->get('singleSource')->getData();
            if (null ===  $sre) {
               // $this->doctrine->getManager()->remove($sre);
            }
            else{
                $o->setSingleSource($sre);
                $sre->addOsnSeqno($o);
                $this->doctrine->getManager()->persist($sre);
            }
        });
    }

    public function getName()
    {
        return 'observationstype';
    }
}