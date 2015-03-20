<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/03/15
 * Time: 14:17
 */

namespace AppBundle\ControllerHelper;


abstract class SettablePropertiesSet
{
/*    protected $functions = array(array('getter' => '', 'setter' => ''));

    public function execute($object)
    {
        foreach ($this->functions as $propertyName => $funcArr) {
            call_user_func(array($object, $funcArr['setter']), $funcArr['getter']);
        }
    }*/

    protected $functions=array();

    public function setAll(&$object){
        foreach($this->functions as $key=>$func){
            //call_user_func($this->functions[$key], $object);
            $object->{$this->functions[$key]};
        }
    }
}