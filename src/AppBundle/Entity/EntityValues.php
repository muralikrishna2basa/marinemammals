<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

interface EntityValues
{
    public function setValue($value);

    public function getValue();

    public function setValueFlag($valueFlag);

    public function getValueFlag();

    public function getPmdName();

    public function getValueFlagRequired();

    public function setValueFlagRequired($mustBeFlagged);

    public function isValueFlaggedLegal();

    public function isValueUnwanted();
}
