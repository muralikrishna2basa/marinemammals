<?php
if(!function_exists('getorganlesion'))
{
	function getorganlesion($necropsy)
	{
		global $db;
		
		$organ_lesions = array();
		
		$process_tbl = array();
		
		if($necropsy!= false && strlen($necropsy) != 0)
			{
				$sql = "select c.rv_meaning as process, b.processus as process_code,b.ogn_code as organ from organ_lesions a, lesion_types b, cg_ref_codes c where a.lte_seqno = b.seqno
						and c.rv_domain = 'PROCESSUS' and c.rv_low_value = b.processus and a.ncy_ese_seqno = :ese_seqno ";
				$bind = array(':ese_seqno'=>$necropsy);
				
				$res = $db->query($sql,$bind);
    	   		
				if($res->isError()){ echo $res->errormessage();return;}
   	 	   	 	
				while($row = $res->fetch())
				{	
					$organ_lesions[$row['ORGAN']][] = $row['PROCESS']; 
					if(!array_key_exists($row['PROCESS'],$process_tbl))
					{
						$process_tbl[$row['PROCESS']] = $row['PROCESS_CODE'];
					}
				}
			}
			return array($organ_lesions,$process_tbl);
	}
}
if(!function_exists('loadchildrenslesions'))
{
	function loadchildrenslesions($parent = false,$necropsy = false)
	{
		global $db;
	
		if($parent == false)
		{
			$parentname = '';
			$parentcode = 'ROOT';
			$parentprocess = '';
		
		}
		else
		{
			$lesion_parent = json_decode($parent,true);
		
			if(!is_array($lesion_parent)){ echo "problem with json"; return;}
		
			$lesion_parent = $lesion_parent['lesion'];
		
			$parentcode = $lesion_parent[0];

			$parentprocess = $lesion_parent[1];
				
			$sql = 'select name from organs where code =  :code';
    	   	
			$bind = array(':code'=>$parentcode);
    	   
			$res = $db->query($sql,$bind);
    	   
			if($res->isError()){ echo $res->errormessage();return;}
   	 	   
			$row = $res->fetch();
    	   
			$parentname = $row['NAME'];
       
		}
	   
		list($organ_lesions,$process_tbl) = getorganlesion($necropsy);
	   
		$sql = "select * from organs where ogn_code = '$parentcode'";

		$res = $db->query($sql);
	 
		$parentname = $parentname == 'ROOT'?'':$parentname;
	
		$lesion = array('lesion'=>array($parentcode,$parentprocess));
		
		$lesion_json = json_encode($lesion);
		
		$selected = $parentprocess == 'NA'?"selected='selected'":"";
		
		$organ_select = "<select class='organ'><option class = 'selected' value = '$lesion_json' $selected>$parentname</option>";
	
		if(array_key_exists($parentcode,$organ_lesions))
		{	
			foreach($organ_lesions[$parentcode] as $process)
			{
				if($process =='NA') { continue;}
				
				$process_code = $process_tbl[$process];
				
				$selected = $process_code == $parentprocess?"selected='selected'":'';
				
				$lesion = array('lesion'=>array($parentcode,$process_code));
				$lesion_json = json_encode($lesion);
				
				$organ_select .="<option value='$lesion_json' $selected>$parentname/$process</option>";
			}
		}
		
		$organ_select .= "<option value = 'PARENT'>...</option>";
	
		$organ_select  .= "<optgroup label  = 'childrens'><option style='display:none;'></option>";
	
		while($row = $res->fetch())
		{
			$name = $row['NAME'];
			$code = $row['CODE'];
			
			$lesion = array('lesion'=>array($code,'NA'));
			$lesion_json = json_encode($lesion);
			
			$organ_select .= "<option value='$lesion_json'>$name</option>";
		}
		$organ_select .= '</optgroup>';
		$organ_select .= '</select>';
	
		echo $organ_select;
	}
}
// document loading
if(isset($db)) 
{
	$necropsy = isset($necropsy_seqno)?$necropsy_seqno:'';
	
	$processus = isset($processus_var)?$processus_var:"NA";
	
	$parent = isset($lesion_var)?$lesion_var:'';
	
	$lesion = array('lesion'=>array($parent,$processus));
	
	$lesion_json = json_encode($lesion);
	
	loadchildrenslesions($lesion_json,$necropsy);

}
// ajax loading
else 

{

	require_once('../../directory.inc');

	include_once(Functions.'getAuthDb.php');
	include_once(Classes.'import/flow_class.php');	
	
	$flow = unserialize($_SESSION['flow_autopsy']);
	$necropsy = $flow->getThread();
	
	
	if(!isset($_GET['organselect'])) { return;}
	
	$organ_select = $_GET['organselect'];
	
	if($organ_select == 'PARENT')
	{
		if(!isset($_GET['actualorgan']) || strlen($_GET['actualorgan']) == 0){ return;}
		
		$actualorgan = $_GET['actualorgan'];
		
		if($actualorgan == 'ROOT') { loadchildrens();return;}
		
		$actual = json_decode($actualorgan,true);
		
		if(!is_array($actual)) { loadchildrens();return;} 
		
		$actual_lesion = $actual['lesion'];
		$organ_lesion = $actual_lesion[0];
		
		// Get Parent
 		
		$sql = "select code,name from organs where code = (select ogn_code from organs where code = :actualorgan)";
		$bind = array('actualorgan'=>$organ_lesion);
		
		$res = $db->query($sql,$bind);
		
		if($res->isError()) { return;}
		
		$row = $res->fetch();
		
		$parent = $row['CODE'];
		
		$lesion = array('lesion'=>array($parent,'NA'));
		$lesion_json = json_encode($lesion);
		// get Childrens 
		
		loadchildrenslesions($lesion_json,$necropsy);
		
	}
	elseif(strlen($organ_select)>0)
	{
		
		
		// get childrens 
		loadchildrenslesions($organ_select,$necropsy);
		
	}
	
}	
?>
