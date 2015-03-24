<?php

namespace AppBundle\Form;

use AppBundle\Entity\Repository\CgRefCodesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\StationsRepository;
use AppBundle\Entity\Repository\PlatformsRepository;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObservationsType extends AbstractType
{
    private $doctrine;
    private $additionalOptions;

    public function __construct($doctrine, $additionalOptions)
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
            'property' => 'typeCountryDescCode',
            'query_builder' => function (StationsRepository $er) {
                return $er->getAllStationsPlaceQb();
            }
        ));
        $builder->add('pfmSeqno', 'entity', array(
            'empty_value' => 'Select...',
            'required' => false,
            'class' => 'AppBundle:Platforms',
            'property' => 'name',
            'query_builder' => function (PlatformsRepository $er) {
                return $er->getAllPlatformsQb();
            }
        ));
        $builder->add('isconfidential', 'checkbox', array(
            'required' => false
        ));
        $builder->add('osnTypeRef', 'entity', array(
            'empty_value' => 'Select...',
            'required' => true,
            'class' => 'AppBundle:CgRefCodes',
            'property' => 'rvMeaning',
            'query_builder' => function (CgRefCodesRepository $er) {
                return $er->getRefCodesQb('OSN_TYPE');
            }
            //'choice_list' => new CgRefChoiceList($this->doctrine, 'OSN_TYPE')
        ));
        $builder->add('samplingeffortRef', 'entity', array(
            'empty_value' => 'Select...',
            'required' => true,
            'class' => 'AppBundle:CgRefCodes',
            'property' => 'rvMeaning',
            'query_builder' => function (CgRefCodesRepository $er) {
                return $er->getRefCodesQb('SAMPLINGEFFORT');
            }
            //'choice_list' => new CgRefChoiceList($this->doctrine, 'SAMPLINGEFFORT')
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

        $builder->add('eseSeqno', new EventStatesType($this->doctrine, $this->additionalOptions));

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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $this->initializeDefaults($event);
        });

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

    private function initializeDefaults(FormEvent $event)
    {
        $repo=$this->doctrine->getRepository('AppBundle:CgRefCodes');
        $o = $event->getData();
        $e = $o->getEseSeqno();

        if ($e->getEventDatetime() === null) {
            $e->setEventDatetime(new \Datetime()); //today
        }
        if ($e->getEventDatetimeFlagRef() === null) {
            $rcQb=$repo->getRefCodesQb('DATETIME_FLAG');
            $rcQb->andWhere("cgr.rvMeaning='acceptable'");
            $vfr = $rcQb->getQuery()->getOneOrNullResult();
            $e->setEventDatetimeFlagRef($vfr);
        }
        if ($o->getSamplingeffortRef() === null) {
            $rcQb=$repo->getRefCodesQb('SAMPLINGEFFORT');
            $rcQb->andWhere("cgr.rvMeaning='ad hoc observation'");
            $vfr = $rcQb->getQuery()->getOneOrNullResult();
            $o->setSamplingeffortRef($vfr);
        }
        if ($o->getSamplingeffortRef() === null) {
            $rcQb=$repo->getRefCodesQb('SAMPLINGEFFORT');
            $rcQb->andWhere("cgr.rvMeaning='ad hoc observation'");
            $vfr = $rcQb->getQuery()->getOneOrNullResult();
            $o->setSamplingeffortRef($vfr);
        }
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