<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/03/15
 * Time: 14:17
 */

namespace AppBundle\Controller;


abstract class PropertiesSet
{

    protected $functions;

    public function toArray($observation){
        $result=array();
        foreach($this->functions as $key=>$func){
            $result[$key]=call_user_func($this->functions[$key], $observation);
        }
        return $result;
    }


}