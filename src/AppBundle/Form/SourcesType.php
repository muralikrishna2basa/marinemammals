<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Repository\SourcesRepository;

class SourcesType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $types=$this->doctrine->getRepository("AppBundle:Sources")->getAllSourceTypes();
        $types2=array();
        foreach($types as $i=>$type){
            array_push($types2,$types[$i]['type']);
        }
        $builder->add('name', 'text',array(
            'required' => true
        ));
        $builder->add('type', 'choice', array(
            'empty_value' => 'Select...',
            'required' => true,
            'choices'=> $types2
            //'choice_list'=>new CgRefChoiceList($this->doctrine,'SOURCE_TYPE')
        ));
    }

    public function getName()
    {
        return 'sourcestype';
    }
}