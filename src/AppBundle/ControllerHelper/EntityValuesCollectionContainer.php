<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 18/03/15
 * Time: 16:14
 */

namespace AppBundle\ControllerHelper;

use AppBundle\Entity\ObservationValues;
use AppBundle\Entity\SpecimenValues;

class EntityValuesCollectionContainer {


    protected $em;

    /**
     * @var EntityValuesCollection
     */
    public $allSpecimenValues;

    /**
     * @var EntityValuesCollection
     */
    public $allObservationValues;

    protected function instantiateObservationValues($pmName, $hasFlag, $mustBeCompleted)
    {
        $pm = $this->em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName($pmName);
        $ov = new ObservationValues($pm, $hasFlag, $mustBeCompleted);
        $this->allObservationValues->add($ov);
    }

    protected function instantiateSpecimenValues($pmName, $hasFlag, $mustBeCompleted)
    {
        $pm = $this->em->getRepository("AppBundle:ParameterMethods")->getParameterMethodByName($pmName);
        $sv = new SpecimenValues($pm, $hasFlag, $mustBeCompleted);
        $this->allSpecimenValues->add($sv);
    }
}