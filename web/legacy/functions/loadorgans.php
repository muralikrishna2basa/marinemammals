<?php

if(!function_exists('loadchildrens'))
{
	function loadchildrens($parent = false)
	{
		global $db;
	
		if($parent == false)
		{
			$parentname = '';
			$parentcode = 'ROOT';
		
		}
		else
		{
     	  $sql = 'select name from organs where code =  :code';
    	   $bind = array(':code'=>$parent);
    	   $res = $db->query($sql,$bind);
    	   if($res->isError()){ echo $res->errormessage();return;}
   	 	   $row = $res->fetch();
    	   $parentname = $row['NAME'];
       
			$parentcode = $parent;
		}
	
		$sql = "select * from organs where ogn_code = '$parentcode'";

		$res = $db->query($sql);
	 
		$parentname = $parentname == 'ROOT'?'':$parentname;
	
		$organ_select = "<select class='organ'><option class = 'selected' value = '$parentcode' selected = 'selected'>$parentname</option>";
	
		$organ_select .= "<option value = 'PARENT'>...</option>";
	
		$organ_select  .= "<optgroup label  = 'childrens'>";
	
		while($row = $res->fetch())
		{
			$name = $row['NAME'];
			$code = $row['CODE'];
			$organ_select .= "<option value='$code'>$name</option>";
		}
		$organ_select .= '</optgroup>';
		$organ_select .= '</select>';
	
		echo $organ_select;
	}
}
// document loading
if(isset($db)) 
{
	$parent = isset($lesion_var)?$lesion_var:'';
	
	loadchildrens($parent);

}
// ajax loading
else 

{

	require_once('../../directory.inc');

	include_once(Functions.'getAuthDb.php');	
	
	if(!isset($_GET['organselect'])) { return;}
	
	$organ_select = $_GET['organselect'];
	
	if($organ_select == 'PARENT')
	{
		if(!isset($_GET['actualorgan']) || strlen($_GET['actualorgan']) == 0){ return;}
		
		$actualorgan = $_GET['actualorgan'];
		
		if($actualorgan == 'ROOT') { loadchildrens();return;}
		
		// Get Parent
 		$sql = "select code,name from organs where code = (select ogn_code from organs where code = :actualorgan)";
		$bind = array('actualorgan'=>$actualorgan);
		
		$res = $db->query($sql,$bind);
		
		if($res->isError()) { return;}
		
		$row = $res->fetch();
		
		$parent = $row['CODE'];
		
		// get Childrens 
		
		loadchildrens($parent);
		
	}
	elseif(strlen($organ_select)>0)
	{
		
		
		// get childrens 
		loadchildrens($organ_select);
		
	}
	
}	
	
	
	

?>