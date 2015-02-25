<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TaxaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('canonicalName', 'text');
        $builder->add('scientificNameAuthorship', 'text');
        $builder->add('vernacularNameEn', 'text');
        $builder->add('taxonrank', 'text');
        $builder->add('idodId', 'integer');
    }

    public function getName()
    {
        return 'taxatype';
    }
}