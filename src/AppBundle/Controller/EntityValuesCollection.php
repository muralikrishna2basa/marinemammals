<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EntityValues;
use \Doctrine\Common\Collections\ArrayCollection;
use \AppBundle\Entity\ValueAssignable;

class EntityValuesCollection {

    /**
     * @var ArrayCollection
     */
    private $collection;

    /**
     * @return ArrayCollection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param ArrayCollection $collection
     */
    public function setCollection(ArrayCollection $collection)
    {
        $this->collection = $collection;
    }

    public function  __construct(){
        $this->setCollection(new ArrayCollection());
    }

    /**
     * @param ValueAssignable $va
     *
     * Assign any EntityValues present in this to the ValueAssignable $va if they have not been assigned yet.
     * Presence is tested only on name.
     */
    public function supplementEntityValues(ValueAssignable $va){
        foreach ($this->collection as $ev){
            $name=$ev->getName();
            if(!$va->getValues()->exists(function($entry) use ($name) {
                return $entry->getName()===$name;
            })){
                $va->addValue($ev);
            }
        }
    }


}