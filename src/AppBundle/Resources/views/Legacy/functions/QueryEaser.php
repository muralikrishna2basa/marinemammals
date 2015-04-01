<?php

/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/03/15
 * Time: 11:25
 */
class QueryEaser
{
    public $db;
    public $sql;
    public $sqlBind;

    public $error=null;

    private $result;

    public $resultArray = array();

    public function __construct($db,$sql, $keyedArray,$sqlBind)
    {
        $this->db = $db;
        $this->sql = $sql;
        $this->sqlBind = $sqlBind;
        $this->result=$db->query($this->sql,$this->sqlBind);
        if($this->result->isError()){
            $this->error=$this->result->errormessage();
        }
        while ($row = $this->result->fetch()) {
            $rowresult = array();
            foreach ($keyedArray as $key => $value) {
                $rowresult[$key] = $row[$key];
            }
            array_push($this->resultArray, $rowresult);
        }
    }

}