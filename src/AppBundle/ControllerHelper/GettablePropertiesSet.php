<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/03/15
 * Time: 14:17
 */

namespace AppBundle\ControllerHelper;


abstract class GettablePropertiesSet
{
    protected $functions=array();

    public function getAll($object){
        $result=array();
        foreach($this->functions as $key=>$func){
            $result[$key]=call_user_func($this->functions[$key], $object);
        }
        return $result;
    }


}