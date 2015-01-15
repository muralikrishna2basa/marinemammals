<?php

namespace AppBundle\Form;

use AppBundle\Entity\Specimens;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Exception\LogicException;
//use AppBundle\Form\DataTransformer\SeqnoToSpecimenTransformer;
//use AppBundle\Form\DataTransformer\SpecimensTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


class Spec2EventsType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$transformer = new SpecimensTransformer($this->doctrine->getManager());

        /*$builder
            ->add(
                $builder->create('scnSeqno',new SpecimensSelectOrAddType( $this->doctrine))
                    ->addViewTransformer($transformer));
        */
        $builder->add('scnSeqnoExisting', 'specimen_selector', array('property_path' => 'scnSeqno'));
        $builder->add('scnSeqnoNew', new SpecimensType($this->doctrine), array('property_path' => 'scnSeqno'));

        $builder->add('values', 'collection', array('type' => new SpecimenValuesType($this->doctrine),
            'options' => array('data_class' => 'AppBundle\Entity\SpecimenValues'),
            'allow_delete' => true,
            'delete_empty' => true
        ));
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($builder) {
            $s2e = $event->getData();
            $form = $event->getForm();

            if(null !== $form->get('scnSeqnoExisting')->getData()){
                $specimen = $form->get('scnSeqnoExisting')->getData();
                $s2e->setScnSeqno($specimen);
                $this->doctrine->getManager()->persist($specimen);
                \Doctrine\Common\Util\Debug::dump('EXISTING:');
                \Doctrine\Common\Util\Debug::dump($specimen );
            }
            elseif(null !== $form->get('scnSeqnoNew')->getData()){
               // $specimen = new Specimens();
                $specimen = $form->get('scnSeqnoNew')->getData();
                $s2e->setScnSeqno($specimen);
                $this->doctrine->getManager()->persist($specimen);
                \Doctrine\Common\Util\Debug::dump('NEW:');
                \Doctrine\Common\Util\Debug::dump($specimen );
            }
            else throw new \Symfony\Component\Form\Exception\LogicException('no specimen given');

            /*$field = $builder->get('username');         // get the field
            $options = $field->getOptions();            // get the options
            $type = $field->getType()->getName();       // get the name of the type
            $options['mapped'] = "true";           // change the label
            $builder->add('scnSeqno', $type, $options); // replace the field
            $field=$form->get('scnSeqnoExisting');

            $data['scnSeqno'] = $specimen;
            $data['scnSeqnoExisting'];
            $form->getConfig()->getAttribute('mapped');
            $builder->get('apple')->get('qty')->setAttribute('mapped', 'true');*/

        });
/*
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $s2e = $event->getData();

            if (null !== $form->get('password')->getData()) {
                $s2e->setPassword($form->get('password')->getData());
            }
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormInterface $form) {
            $form = $event->getForm();
            $s2e = $form->getData();

            if (null !== $form->get('password')->getData()) {
                $s2e->setPassword($form->get('password')->getData());
            }
        });*/
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'AppBundle\Entity\Spec2Events',
            ));
    }

    public function getName()
    {
        return 'spec2eventstype';
    }
}