<?php

namespace AppBundle\ControllerHelper;

use AppBundle\Entity\EntityValues;
use \Doctrine\Common\Collections\ArrayCollection;
use \AppBundle\Entity\ValueAssignable;

class EntityValuesCollection
{

    /**
     * @var ArrayCollection
     */
    private $collection;

    private $keys;

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
        foreach ($collection as $key => $ev) {
            $this->keys[$key] = '';
        }
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
        $key = $ev->getPmdName();
        if (!$this->hasValueForParameter($key)) {
            //$this->getCollection()->add($ev);
            $this->getCollection()->set($key, $ev);

            //foreach($collection as $key=>$ev){
            $this->keys[$key] = '';
            //}
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
        foreach ($this->collection as $canonicalEvKey => $canonicalEntityValues) {
            $found = false;
            foreach ($va->getValues() as $entityValue) {
                $evKey = $entityValue->getPmdName();
                if ($canonicalEvKey === $evKey) {
                    $found = true;
                    $this->keys[$canonicalEvKey] = $evKey;
                    $entityValue->setHasFlag($canonicalEntityValues->getHasFlag());
                    $entityValue->setValueRequired($canonicalEntityValues->getValueRequired());
                }
            }
            if ($found === false) {
                $canonicalEntityValues->setValueAssignable($va);
                $this->keys[$canonicalEvKey] = $canonicalEvKey;
            }
        }
        $keys=$this->keys;//database-fetched entityValues that are not predefined in the canonicalKeys are to be excluded.
        $nonMatchingEv=array_filter($va->getValues()->toArray(),function($ev) use($keys){
                return !in_array($ev->getPmdName(),$keys);
        });
        foreach ($nonMatchingEv as $nmEv){
            $va->removeValue($nmEv);
        }

    }

    public function hasValueForParameter($pmName)
    {
        foreach ($this->collection as $ev) {
            $name = $ev->getPmdName();
            if ($name === $pmName) {
                return true;
            }
        }
        return false;
    }


}