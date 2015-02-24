<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EntityValues;
use \Doctrine\Common\Collections\ArrayCollection;
use \AppBundle\Entity\ValueAssignable;
use Doctrine\Common\Collections\Criteria;

class EntityValuesCollection
{

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

    public function  __construct()
    {
        $this->setCollection(new ArrayCollection());
    }

    /**
     * @param EntityValues $ev
     *
     * Add an EntityValues to this. An EntityValues with the same parameter name can only be added once.
     */
    public function add(EntityValues $ev)
    {
        if(!$this->hasValueForParameter($ev->getPmdName())){
            $this->getCollection()->add($ev);
        }
    }

    /**
     * @param ValueAssignable $va
     *
     * Assign any EntityValues present in this to the ValueAssignable $va if they have not been assigned yet.
     * Presence is tested only on name.
     */
    public function supplementEntityValues(ValueAssignable $va)
    {
        /*foreach ($this->collection as $ev) {
            //$name=$ev->getName();
            if (!$va->getValues()->isEmpty()) {
                $name = $ev->getPmdSeqno()->getName();
                if (!$va->getValues()->exists(function ($entry) use ($name) {
                    $a = $entry;
                    return $entry->getPmdSeqno()->getName() === $name;
                })
                ) {
                    $va->addValue($ev);
                }
            }
            else {
                $va->addValue($ev);
            }
        }*/
        foreach ($this->collection as $ev) {
            $name = $ev->getPmdName();
            $found=false;
            foreach ($va->getValues() as $vaev) {
                $vaevName = $vaev->getPmdName();
                if($name===$vaevName){
                    $found=true;
                }
            }
            if(!$found){
                $ev->setValueAssignable($va);
            }
        }
    }

    public function hasValueForParameter($pmName){
        foreach ($this->collection as $ev) {
            $name = $ev->getPmdName();
            if($name===$pmName){
                return true;
            }
        }
        return false;
    }


}