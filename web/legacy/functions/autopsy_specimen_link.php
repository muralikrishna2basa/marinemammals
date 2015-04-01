<?php
/**
 *    If ajax loaded, then get database and authenticate
 * 
 * 
 *  
*/
if(!isset($db) || !isset($auth))
{
	$var = '';
	
	//require_once('directory.inc');

	//include_once(Functions.'getAuthDb.php');
	
	include_once(Classes."search/searcher_class.php");
	
	if(isset($_POST['specimen_link']))
	{
		$var  = $_POST['specimen_link'];
	} 
}

include_once(Classes.'record/db_record_class.php');

echo new Specimen_record($db,$var);

?>