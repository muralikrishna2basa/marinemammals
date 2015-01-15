<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Specimens;

/**
 * Used to handle objects in the specimens selector type
 */
class SpecimensSelector
{

    private $AddNewSpecimens=false;
    private $SpecimensNew;
    private $SpecimensSelected;


    public function __construct(Specimens $specimens) {
        $this->SpecimensSelected = $specimens;
        $this->SpecimensNew= new Specimens();
    }

    public function getSpecimens() {
        if ($this->AddNewSpecimens) {
            return $this->SpecimensNew;
        }
        return $this->SpecimensSelected;
    }

    public function setSpecimensNew(Specimens $SpecimensNew)
    {
        $this->SpecimensNew = $SpecimensNew;
    }

    public function getSpecimensNew()
    {
        return $this->SpecimensNew;
    }

    public function setSpecimensSelected($SpecimensSelected)
    {
        $this->SpecimensSelected = $SpecimensSelected;
    }

    public function getSpecimensSelected()
    {
        return $this->SpecimensSelected;
    }

    public function setAddNewSpecimens($AddNewSpecimens)
    {
        $this->AddNewSpecimens = $AddNewSpecimens;
    }

    public function getAddNewSpecimens()
    {
        return $this->AddNewSpecimens;
    }


}