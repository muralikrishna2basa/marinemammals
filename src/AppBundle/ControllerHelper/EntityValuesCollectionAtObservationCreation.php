<?php

namespace AppBundle\ControllerHelper;

class EntityValuesCollectionAtObservationCreation extends EntityValuesCollectionContainer
{

    public function __construct($em)
    {
        $this->em = $em;
        $this->allSpecimenValues = new EntityValuesCollection();
        $this->allObservationValues = new EntityValuesCollection();

        $this->instantiateSpecimenValues('Before intervention', true, true);
        $this->instantiateSpecimenValues('During intervention', true, true);
        $this->instantiateSpecimenValues('Collection', true, true);
        $this->instantiateSpecimenValues('Decomposition Code', true, true);

        $this->instantiateSpecimenValues('Body length', true, false);
//        $this->instantiateSpecimenValues('Body weight', true, false);
        $this->instantiateSpecimenValues('Age', true, false);
        $this->instantiateSpecimenValues('Nutritional Status', true, false);

        $this->instantiateSpecimenValues('Fresh external lesions::Fresh bite marks', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Opened abdomen', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Stabbing wound', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Parallel cuts', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Broken bones', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Hypothema', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Fin amputation', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Encircling lesion', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Other fresh external lesions', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Tail', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Pectoral fin', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Snout', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Line/net impressions or cuts::Mouth', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Scavenger traces::Picks', false, true);
        $this->instantiateSpecimenValues('Fresh external lesions::Scavenger traces::Bites', false, true);
        $this->instantiateSpecimenValues('Healing/healed lesions::Bites', false, true);
        $this->instantiateSpecimenValues('Healing/healed lesions::Pox-like lesions', false, true);
        $this->instantiateSpecimenValues('Healing/healed lesions::Open warts', false, true);
        $this->instantiateSpecimenValues('Healing/healed lesions::Cuts', false, true);
        $this->instantiateSpecimenValues('Healing/healed lesions::Line/net impressions', false, true);
        $this->instantiateSpecimenValues('Fishing activities::Static gear on beach nearby', false, true);
        $this->instantiateSpecimenValues('Fishing activities::Static gear at sea nearby', false, true);
        $this->instantiateSpecimenValues('Other characteristics::External parasites', false, true);
        $this->instantiateSpecimenValues('Other characteristics::Froth from airways', false, true);
        $this->instantiateSpecimenValues('Other characteristics::Fishy smell', false, true);
        $this->instantiateSpecimenValues('Other characteristics::Prey remains in mouth', false, true);
        $this->instantiateSpecimenValues('Other characteristics::Remains of nets, ropes, plastic, etc.', false, true);
        $this->instantiateSpecimenValues('Other characteristics::Oil remains on skin', false, true);
//        $this->instantiateSpecimenValues('Nutritional condition', false, true);
//        $this->instantiateSpecimenValues('Stomach Content', false, true);
        $this->instantiateSpecimenValues('Other remarks', false, false);

        $this->instantiateSpecimenValues('Cause of death::Natural', false, true);
        $this->instantiateSpecimenValues('Cause of death::Bycatch', false, true);
        $this->instantiateSpecimenValues('Cause of death::Ship strike', false, true);
        $this->instantiateSpecimenValues('Cause of death::Predation', false, true);
        $this->instantiateSpecimenValues('Cause of death::Other', false, true);
        $this->instantiateSpecimenValues('Cause of death::Unknown', false, true);

        $this->instantiateSpecimenValues('Bycatch activity::Professional gear', false, false);
        $this->instantiateSpecimenValues('Bycatch activity::Recreational gear', false, false);
        $this->instantiateSpecimenValues('Bycatch activity::Angling', false, false);
        $this->instantiateSpecimenValues('Bycatch activity::Unknown fishing gear', false, false);

        $this->instantiateObservationValues('Wind direction', true, false);
        $this->instantiateObservationValues('Wind speed', true, false);
        $this->instantiateObservationValues('Seastate', true, false);
    }
}