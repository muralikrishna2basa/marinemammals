<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

interface ValueAssignable
{
    public function setValues(\Doctrine\Common\Collections\Collection $values);

    public function getValues();

    public function getValueByKey($key);

    public function removeValue(EntityValues $ev);

    public function addValue(EntityValues $ev);

}