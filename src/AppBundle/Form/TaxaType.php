<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\ChoiceList\TaxonrankList;

class TaxaType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('canonicalName', 'text');
        $builder->add('scientificNameAuthorship', 'text');
        $builder->add('vernacularNameEn', 'text');
        $builder->add('taxonrank', 'choice',array(
            'empty_value' => 'Select...',
            'required' => false,
            'choice_list'=>new TaxonrankList($this->doctrine)));
        $builder->add('idodId', 'integer',array('required' => false));
    }

    public function getName()
    {
        return 'taxatype';
    }
}