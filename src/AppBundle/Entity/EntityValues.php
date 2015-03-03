<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

interface EntityValues
{
    public function getValueAssignable();

    public function setValueAssignable(ValueAssignable $va);

    public function setValue($value);

    public function getValue();

    public function setValueFlag($valueFlag);

    public function getValueFlag();

    public function getPmdName();

    public function getValueRequired();

    public function setValueRequired($valueRequired);

    public function getHasFlag();

    public function setHasFlag($valueFlagRequired);

    public function isValueFlagLegal();

    public function isValueUnwantedLegal();

    //public function isValueUnwantedLegal2();

    public function isValueLegal();
}
