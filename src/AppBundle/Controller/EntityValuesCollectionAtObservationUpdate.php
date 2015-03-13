<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ObservationValues;
use AppBundle\Entity\SpecimenValues;

class EntityValuesCollectionAtObservationUpdate
{

    public function __construct($em)
    {
        $this->em = $em;
        $this->allSpecimenValues = new EntityValuesCollection();
        $this->allObservationValues = new EntityValuesCollection();

        $this->instantiateSpecimenValues('Before intervention', true, false);
        $this->instantiateSpecimenValues('During intervention', true, false);
        $this->instantiateSpecimenValues('Collection', true, false);
        $this->instantiateSpecimenValues('Decomposition Code', true, false);

        $this->instantiateSpecimenValues('Body length', true, false);
        $this->instantiateSpecimenValues('Body weight', true, false);
        $this->instantiateSpecimenValues('Age', true, false);
        $this->instantiateSpecimenValues('Nutritional Status', true, false);

        $this->instantiateSpecimenValues('Fresh external lesions::Fresh bite marks', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Opened abdomen', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Stabbing wound', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Parallel cuts', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Broken bones', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Hypothema', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Fin amputation', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Encircling lesion', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Other fresh external lesions', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Tail', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Pectoral fin', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Snout', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Mouth', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Scavenger traces::Picks', false, false);
        $this->instantiateSpecimenValues('Fresh external lesions::Scavenger traces::Bites', false, false);
        $this->instantiateSpecimenValues('Healing/healed lesions::Bites', false, false);
        $this->instantiateSpecimenValues('Healing/healed lesions::Pox-like lesions', false, false);
        $this->instantiateSpecimenValues('Healing/healed lesions::Open warts', false, false);
        $this->instantiateSpecimenValues('Healing/healed lesions::Cuts', false, false);
        $this->instantiateSpecimenValues('Healing/healed lesions::Line/net impressions', false, false);
        $this->instantiateSpecimenValues('Fishing activities::Static gear on beach nearby', false, false);
        $this->instantiateSpecimenValues('Fishing activities::Static gear at sea nearby', false, false);
        $this->instantiateSpecimenValues('Other characteristics::External parasites', false, false);
        $this->instantiateSpecimenValues('Other characteristics::Froth from airways', false, false);
        $this->instantiateSpecimenValues('Other characteristics::Fishy smell', false, false);
        $this->instantiateSpecimenValues('Other characteristics::Prey remains in mouth', false, false);
        $this->instantiateSpecimenValues('Other characteristics::Remains of nets, ropes, plastic, etc.', false, false);
        $this->instantiateSpecimenValues('Other characteristics::Oil remains on skin', false, false);
        $this->instantiateSpecimenValues('Nutritional condition', false, false);
        $this->instantiateSpecimenValues('Stomach Content', false, false);
        $this->instantiateSpecimenValues('Other remarks', false, false);

        $this->instantiateSpecimenValues('Cause of death::Natural', false, false);
        $this->instantiateSpecimenValues('Cause of death::Bycatch', false, false);
        $this->instantiateSpecimenValues('Cause of death::Ship strike', false, false);
        $this->instantiateSpecimenValues('Cause of death::Predation', false, false);
        $this->instantiateSpecimenValues('Cause of death::Other', false, false);
        $this->instantiateSpecimenValues('Cause of death::Unknown', false, false);

        $this->instantiateSpecimenValues('Bycatch activity::Professional gear', false, false);
        $this->instantiateSpecimenValues('Bycatch activity::Recreational gear', false, false);
        $this->instantiateSpecimenValues('Bycatch activity::Angling', false, false);
        $this->instantiateSpecimenValues('Bycatch activity::Unknown fishing gear', false, false);

        $this->instantiateObservationValues('Wind direction', true, false);
        $this->instantiateObservationValues('Wind speed', true, false);
        $this->instantiateObservationValues('Seastate', true, false);
    }

    /**
     * @var EntityValuesCollection
     */
    private $em;

    /**
     * @var EntityValuesCollection
     */
    public $allSpecimenValues;

    /**
     * @var EntityValuesCollection
     */
    public $allObservationValues;

    private function instantiateObservationValues($pmName, $hasFlag, $mustBeCompleted)
    {
        $pm = $this->em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName($pmName);
        $ov = new ObservationValues($pm, $hasFlag, $mustBeCompleted);
        $this->allObservationValues->add($ov);
    }

    private function instantiateSpecimenValues($pmName, $hasFlag, $mustBeCompleted)
    {
        $pm = $this->em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName($pmName);
        $sv = new SpecimenValues($pm, $hasFlag, $mustBeCompleted);
        $this->allSpecimenValues->add($sv);
    }
}