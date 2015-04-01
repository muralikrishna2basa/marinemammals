<?php 
/**
 *  When ajax loading, => the relative path start on the ajax called directory 
 */
if(!isset($db) || !isset($auth))
{
	require_once('../../directory.inc');

	include_once(Functions.'getAuthDb.php');
	
	include_once(Classes."search/searcher_class.php");
}
include_once(Classes.'record/db_record_class.php');

$test2 = new Db_records($db);

$test2->add('User_record','2');

$test2->add('User_record','1');

$test2->add('User_record','102');

$test2->add('User_record','113');

$test2->add('Specimen_record','1146');

if(isset($_POST['record_id']))
{
		$test2->setCurrentId($_POST['record_id']);
}


echo $test2;


?>