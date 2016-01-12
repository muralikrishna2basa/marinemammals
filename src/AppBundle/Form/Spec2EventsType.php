<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


class Spec2EventsType extends AbstractType
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
        $vd = $this->additionalOptions['validation_groups'];
        $builder->add('scnSeqnoExisting', new SpecimensSelectorType($this->doctrine), array('property_path' => 'scnSeqno', 'validation_groups' => $vd));
        //$builder->add('scnSeqnoNew', new SpecimensType($this->doctrine), array('property_path' => 'scnSeqno','mapped'=>false));

        $builder->add('circumstantialValues', 'collection', array('type' => new EntityValuesType($this->doctrine),
            'options' => array('radio' => false, 'data_class' => 'AppBundle\Entity\SpecimenValues', 'default_flag_value' => 'good value'), //required=true
            'allow_delete' => true,
            'delete_empty' => true
        ));
        $builder->add('measurementValues', 'collection', array('type' => new EntityValuesType($this->doctrine),
            'options' => array('radio' => false, 'data_class' => 'AppBundle\Entity\SpecimenValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));
        $builder->add('pathologyValues', 'collection', array('type' => new EntityValuesType($this->doctrine),
            'options' => array('radio' => false, 'default_value' => 'unknown', 'data_class' => 'AppBundle\Entity\SpecimenValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));
        $builder->add('causeOfDeathValues', 'collection', array('type' => new EntityValuesType($this->doctrine),
            'options' => array('radio' => false, 'data_class' => 'AppBundle\Entity\SpecimenValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));
        $builder->add('bycatchProbabilityValues', 'collection', array('type' => new EntityValuesType($this->doctrine),
            'options' => array('radio' => false, 'data_class' => 'AppBundle\Entity\SpecimenValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));
        $doctrine = $this->doctrine;
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($doctrine) {
            $form = $event->getForm();
            $s2e = $event->getData();
            $form->add('scnSeqnoNew', new SpecimensType($doctrine), array('property_path' => 'scnSeqno', 'mapped' => false));
            $scnSeqnoNew = $form->get('scnSeqnoNew');
            $scnSeqnoNew->setData(null);


            /* $s2e = $event->getData();
             $form = $event->getForm();
             $scnSeqnoNew = $form->get('scnSeqnoNew');
             $scnSeqnoNewData = $scnSeqnoNew->getData();
             if (null !== $scnSeqnoNewData) {
                 if($scnSeqnoNewData['txnSeqno'] === null){
                     $scnSeqnoNew->setData(null);
                 }
             } else throw new LogicException('no specimen given');*/
        });
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($doctrine) {
            //set mapped option to false
            $s2e = $event->getData();
            $form = $event->getForm();
            $existingScnSeqno = $s2e['scnSeqnoExisting'];
            $newTxnSeqno = $s2e['scnSeqnoNew']['txnSeqno'];
            if ($existingScnSeqno !== null && $existingScnSeqno !== '') {
                $form->add('scnSeqnoNew', new SpecimensType($doctrine), array('property_path' => 'scnSeqno', 'validation_groups' => false, 'mapped' => false));
            } elseif ($newTxnSeqno !== null && $newTxnSeqno !== '') {
                $form->add('scnSeqnoNew', new SpecimensType($doctrine), array('property_path' => 'scnSeqno', 'mapped' => true));
                $form->add('scnSeqnoExisting', new SpecimensSelectorType($doctrine), array('property_path' => 'scnSeqno', 'validation_groups' => false));
            }
        });
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($doctrine) {
            $s2e = $event->getData();
            $form = $event->getForm();
            $scnSeqnoNew = $form->get('scnSeqnoNew');
            $scnSeqnoExisting = $form->get('scnSeqnoExisting');
            if (null !== $scnSeqnoExisting->getData()) {
                $specimen = $scnSeqnoExisting->getData();
                //$form->remove('scnSeqnoNew');
                if ($specimen->getScnNumber() === null) {
                    $seqno = $specimen->getSeqno();
                    $dt = new DataTransformer\SeqnoToSpecimenTransformer($doctrine);
                    $specimen = $dt->reverseTransform($seqno);
                }
                $s2e->setScnSeqno($specimen);
                // $s2e->setUsesExistingSpecimen(true);
                //$this->doctrine->getManager()->persist($specimen);
            } elseif (null !== $scnSeqnoNew->getData()) {
                //$specimen = new Specimens();
                $specimen = $scnSeqnoNew->getData();
                //$form->remove('scnSeqnoExisting');
                $s2e->setScnSeqno($specimen);
                // $s2e->setUsesExistingSpecimen(false);
                $this->doctrine->getManager()->persist($specimen);
            } else throw new LogicException('no specimen given');
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'cascade_validation' => true,
                'error_bubbling' => false,
                'data_class' => 'AppBundle\Entity\Spec2Events',
                'error_mapping' => array('scnSeqnoExisting' => 'scnSeqnoExisting'),
                'validation_groups' => array()
            ));
    }

    public function getName()
    {
        return 'spec2eventstype';
    }
}