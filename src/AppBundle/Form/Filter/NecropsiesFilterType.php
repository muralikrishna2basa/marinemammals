<?php

namespace AppBundle\Form\Filter;

use AppBundle\Entity\Repository\TaxaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\CgRefCodesRepository;
use AppBundle\Entity\Repository\StationsRepository;
use AppBundle\Entity\Repository\OrgansRepository;
use AppBundle\Form\ChoiceList\CgRefChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NecropsiesFilterType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventDatetimeStart', 'filter_date', array(
            'required' => false,
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'));
        $builder->add('eventDatetimeStop', 'filter_date', array(
            'required' => false,
            'input'  => 'datetime',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'));
        $builder->add('osnTypeRef', 'filter_entity', array(
            'required' => false,
            'empty_value' => 'Observations type...',
            'class' => 'AppBundle:CgRefCodes',
            'property' => 'rvMeaning',
            'query_builder' => function (CgRefCodesRepository $er) {
                return $er->getRefCodesQb('OSN_TYPE');
            }
        ));
        $builder->add('stnSeqno', 'filter_entity', array(
            'empty_value' => 'Location...',
            'required' => false,
            'class' => 'AppBundle:Stations',
            'property' => 'placeNameDesc',
            'query_builder' => function (StationsRepository $er) {
                return $er->getAllStationsPlaceQb();
            }
        ));
        $builder->add('txnSeqno', 'filter_entity', array(
            'empty_value' => 'Species...',
            'required' => false,
            'class' => 'AppBundle:Taxa',
            'property' => 'fullyQualifiedName',
            'query_builder' => function (TaxaRepository $er) {
                return $er->getAllEuropeanTaxaQb();
            }
        ));
        $builder->add('refAut', 'filter_text', array('required' => false));
        $builder->add('refLabo', 'filter_text', array('required' => false));
        $builder->add('processus', 'filter_choice', array(
            'empty_value' => 'Select...',
            'required' => false,
            'choice_list' => new CgRefChoiceList($this->doctrine, 'PROCESSUS')
        ));
        $builder->add('ognCode', 'filter_entity', array(
            'empty_value' => 'Organ...',
            'required' => false,
            'class' => 'AppBundle:Organs',
            'property' => 'name',
            'query_builder' => function (OrgansRepository $er) {
                return $er->getAllOrgansQb();
            }
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false/*,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
            'onlyBelgium'=>true*/
        ));
    }

    public function getName()
    {
        return 'necropsiesfiltertype';
    }
}