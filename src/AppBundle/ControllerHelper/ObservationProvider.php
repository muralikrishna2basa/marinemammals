<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 18/03/15
 * Time: 16:21
 */

namespace AppBundle\ControllerHelper;

use AppBundle\Entity\Observations;
use AppBundle\Entity\EventStates;
use AppBundle\Entity\Event2Persons;
use AppBundle\Entity\Spec2Events;

class ObservationProvider {

    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repo=$this->doctrine->getRepository('AppBundle:Observations');
    }

    public function loadAndSupplementObservation($id)
    {
        $observation = $this->loadObservation($id);
        $evc = new EntityValuesCollectionAtObservationUpdate($this->doctrine);
        $evc->allObservationValues->supplementEntityValues($observation);
        $s2e = $observation->getEseSeqno()->getSpec2Events();
        $evc->allSpecimenValues->supplementEntityValues($s2e);
        return $observation;
    }

    public function loadObservation($id)
    {
        $observation = $this->repo->find($id);
        if (!$observation) {
            throw $this->createNotFoundException(sprintf('The observation with seqno %s does not exist.', $id));
        }
        return $observation;
    }

    public function prepareNewObservation()
    {
        $observation = new Observations();
        $event = new EventStates();
        $observation->setEseSeqno($event);

        $event2Persons1 = new Event2Persons();
        $event2Persons1->setEseSeqno($event);
        $event2Persons1->setE2pType(EventStates::OBSERVED);
        $event->getEvent2Persons()->add($event2Persons1);

        $event2Persons2 = new Event2Persons();
        $event2Persons2->setEseSeqno($event);
        $event2Persons2->setE2pType(EventStates::GATHERED);
        $event->getEvent2Persons()->add($event2Persons2);

        $event2Persons2 = new Event2Persons();
        $event2Persons2->setEseSeqno($event);
        $event2Persons2->setE2pType(EventStates::INFORMED);
        $event->getEvent2Persons()->add($event2Persons2);

        $evcfoc = new EntityValuesCollectionAtObservationCreation($this->doctrine);

        $evcfoc->allObservationValues->supplementEntityValues($observation);

        $s2e = new Spec2Events();
        //$specimen=new Specimens();
        $event->setSpec2Events($s2e);
        //$s2e->setEseSeqno($event); //TODO: check if this can be deleted. shoudle be now that this is truly bidirectional
        //$s2e->setScnSeqno($specimen);

        $evcfoc->allSpecimenValues->supplementEntityValues($s2e);

        return $observation;
    }
}