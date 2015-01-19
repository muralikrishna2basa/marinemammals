<?php

namespace AppBundle\Form\Subscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Entity\SpecimenValues;

class ObservationValuesListener implements EventSubscriberInterface
{

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::SUBMIT   => 'onSubmit',
        );
    }

    private function instantiateSpecimenValues($pmName,&$s2e,&$form){
        $em = $this->doctrine->getManager();
        $pm = $em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName($pmName);
        $sv=new SpecimenValues();
        $sv->setPmdSeqno($pm);
        $sv->setS2eScnSeqno($s2e);

        $form->get('valuesClassic')->getData()->add($sv);
        return $sv;
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $s2e= $event->getData();

        $biSv=$this->instantiateSpecimenValues('Before intervention',$s2e,$form);
        $diSv=$this->instantiateSpecimenValues('During intervention',$s2e,$form);
        $cSv=$this->instantiateSpecimenValues('Collection',$s2e,$form);
        $dcSv=$this->instantiateSpecimenValues('Decomposition Code',$s2e,$form);
        $blPm=$this->instantiateSpecimenValues('Body length',$s2e,$form);
        $bwPm=$this->instantiateSpecimenValues('Body weight',$s2e,$form);
        $aPm=$this->instantiateSpecimenValues('Age',$s2e,$form);
        $nsPm=$this->instantiateSpecimenValues('Nutritional Status',$s2e,$form);

        $extpath1=$this->instantiateSpecimenValues('Fresh external lesions::Fresh bite marks',$s2e,$form);
        $extpath2=$this->instantiateSpecimenValues('Fresh external lesions::Opened abdomen',$s2e,$form);
        $extpath3=$this->instantiateSpecimenValues('Fresh external lesions::Stabbing wound',$s2e,$form);
        $extpath4=$this->instantiateSpecimenValues('Fresh external lesions::Parallel cuts',$s2e,$form);
        $extpath5=$this->instantiateSpecimenValues('Fresh external lesions::Broken bones',$s2e,$form);
        $extpath6=$this->instantiateSpecimenValues('Fresh external lesions::Hypothema',$s2e,$form);
        $extpath7=$this->instantiateSpecimenValues('Fresh external lesions::Fin amputation',$s2e,$form);
        $extpath8=$this->instantiateSpecimenValues('Fresh external lesions::Encircling lesion',$s2e,$form);
        $extpath9=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Tail',$s2e,$form);
        $extpath10=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Pectoral fin',$s2e,$form);
        $extpath11=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Snout',$s2e,$form);
        $extpath12=$this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Mouth',$s2e,$form);
        $extpath13=$this->instantiateSpecimenValues('Fresh external lesions::Scavenger traces::Picks',$s2e,$form);
        $extpath14=$this->instantiateSpecimenValues('Fresh external lesions::Scavenger traces::Bites',$s2e,$form);
        $extpath15=$this->instantiateSpecimenValues('Fresh external lesions::Other fresh external lesions',$s2e,$form);
        $extpath16=$this->instantiateSpecimenValues('Healing/healed lesions::Bites',$s2e,$form);
        $extpath17=$this->instantiateSpecimenValues('Healing/healed lesions::Pox-like lesions',$s2e,$form);
        $extpath18=$this->instantiateSpecimenValues('Healing/healed lesions::Open warts',$s2e,$form);
        $extpath19=$this->instantiateSpecimenValues('Healing/healed lesions::Cuts',$s2e,$form);
        $extpath20=$this->instantiateSpecimenValues('Healing/healed lesions::Line/net impressions',$s2e,$form);
        $extpath21=$this->instantiateSpecimenValues('Fishing activities::Static gear on beach nearby',$s2e,$form);
        $extpath22=$this->instantiateSpecimenValues('Fishing activities::Static gear at sea nearby',$s2e,$form);
        $extpath23=$this->instantiateSpecimenValues('Other characteristics::External parasites',$s2e,$form);
        $extpath24=$this->instantiateSpecimenValues('Other characteristics::Froth from airways',$s2e,$form);
        $extpath25=$this->instantiateSpecimenValues('Other characteristics::Fishy smell',$s2e,$form);
        $extpath26=$this->instantiateSpecimenValues('Other characteristics::Prey remains in mouth',$s2e,$form);
        $extpath27=$this->instantiateSpecimenValues('Other characteristics::Remains of nets, ropes, plastic, etc.',$s2e,$form);
        $extpath28=$this->instantiateSpecimenValues('Other characteristics::Oil remains on skin',$s2e,$form);
        $extpath29=$this->instantiateSpecimenValues('Nutritional condition',$s2e,$form);
        $extpath30=$this->instantiateSpecimenValues('Stomach Content',$s2e,$form);
        $extpath31=$this->instantiateSpecimenValues('Other remarks',$s2e,$form);
    }

    public function onSubmit(FormEvent $event)
    {
        $s2e = $event->getData();
        $form = $event->getForm();

        if(null !== $form->get('scnSeqnoExisting')->getData()){
            $specimen = $form->get('scnSeqnoExisting')->getData();
            $s2e->setScnSeqno($specimen);
            $this->doctrine->getManager()->persist($specimen);
        }
        elseif(null !== $form->get('scnSeqnoNew')->getData()){
            // $specimen = new Specimens();
            $specimen = $form->get('scnSeqnoNew')->getData();
            $s2e->setScnSeqno($specimen);
            $this->doctrine->getManager()->persist($specimen);
        }
        else throw new \Symfony\Component\Form\Exception\LogicException('no specimen given');
    }
}