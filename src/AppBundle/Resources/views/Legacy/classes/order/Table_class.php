<?php

/**
 * 	Class Table  v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 *  Details:
 * ---------
 *
 * Class Table, used to perform modifications on table identified uniquely by a unique integer
 * Used to simplify classes based on those tables 
 *
 */
class Table 
{
	private $db;
	
	public $identifier ="seqno";
	
	public $isError;
	
	public $errormessage;
	
	private $table = null;
	
	public function __construct(ORACLE $db,$table)
	{
	$this->db = $db;	
	$this->initTable($table);
	}
	
	protected function initTable($table)
	{
		$sql = "select * from $table";
		
		$this->db->query($sql);
		
		if($this->db->isError()){ $this->isError = true;$this->errormessage = "table not found" ;return false;}
		
		$this->table = $table;
	}
	
	public function Add($attributes)
	{
		
	if($this->table == null || $this->table == false) {return false;}	
	/* sanitary check*/
	if(!is_array($attributes) || count($attributes) <= 0 ){$this->isError = true;$this->errormessage = 'attribute format wrong';return false; }	
	
	$columns_array = array_keys($attributes);
	
	$values_array = array_values($attributes);
	
	$columns = implode(",",$columns_array);
	
	$values =  implode(",",array_values($attributes));
	
	$binded_array = array();
	
	foreach($columns_array as $item) 
	{ 
		$cc = chr(count($binded_array) + 97);
		$binded_array[] = ":".$cc ;
	}
		 
	
	$binded_values = implode(",",$binded_array);
	
	$binds = array_combine($binded_array,$values_array);
	    
	
	$sql = "insert into $this->table ($columns) values($binded_values)";
	
	$result = $this->db->query($sql,$binds);
	
	if($result->isError()){ $this->isError = true; $this->errormessage = $result->errormessage();return false; }
	
	
	}
	
	public function Delete($tableids)
	{
	
	if($this->table == null || $this->table == false) {return false;}	
		
	if(!is_array($tableids) ){$this->isError = true;$this->errormessage = "not valid input";return false;}

	$bids = array();
	
	foreach($tableids as $item) { $bids[] = ":".$item; }
	
	$bids_values = implode(',',$bids);
	
	$binds = array_combine($bids,$tableids);
	
	$sql = "delete from $this->table where $this->identifier in ($bids_values)";	
	
	$result = $this->db->query($sql,$binds);
	
	if($result->isError()){ $this->isError = true; $this->errormessage = $result->errormessage();return false;}
		
	}
	
	public function Alter($attributes,$tableids)
	{
	
	
	if($this->table == null || $this->table == false) {return false;}		
		
	if(!is_array($attributes) || count($attributes) <= 0 ){$this->isError = true;$this->errormessage = 'attribute format wrong';return false;}	
	
	if(!is_array($tableids) ){$this->isError = true;$this->errormessage = "not valid ids input";return false;}

	
	$columns_array = array_keys($attributes);
	
	$values_array = array_values($attributes); 
	
	
	$binded_array = array();$tmp = array();
	
	foreach($columns_array as $item) 
	{ 
		$cc = chr(count($binded_array) + 97);
		$binded_array[] = ":".$cc ; $tmp[] = $item."=:".$cc;}
	
	$columns = implode(',',$tmp);
	
	$binds = array_combine($binded_array,$values_array);
	/* seqno treatment */
	$bids = array();
	
	foreach($tableids as $item) { $bids[] = ":".$item; }
	
	$bids_values = implode(',',$bids);
	
	$bindsseqno = array_combine($bids,$tableids);
	
	$binds += $bindsseqno; 
	
	$sql ="update $this->table set $columns where $this->identifier in ($bids_values)";
	
	$result = $this->db->query($sql,$binds);
	
	if($result->isError()){ $this->isError = true; $this->errormessage = $result->errormessage();return false;}
	
	}
	
	public function getAttributes($tableid)
	{
		if($this->table == null || $this->table == false) {return false;}	
		
		$sql = "select * from $this->table where $tableid = :tableid";
		
		$bind = array(':tableid'=>$tableid);
		
		$r = $this->db->query($sql,$bind);
		
		if($r->isError()){ $this->isError = true;$this->errormessage = $r->errormessage();return false;}
		
		return $r->fetchAll();
	}
}
?>