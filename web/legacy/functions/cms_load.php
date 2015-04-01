<?php

/**
 * Used as a tool to retrieve ajax loaded form content 
 * 
 * */

require_once('../../directory.inc');

include_once(Functions.'getAuthDb.php');
	
include_once(Classes."search/searcher_class.php");


if(!isset($_GET['class']) || !is_string($_GET['class']) || strlen($_GET['class']) <= 0){ return false;}
if(!isset($_GET['pk'])|| !is_string($_GET['class']) || strlen($_GET['class']) <= 0){ return false;}

$class = $_GET['class'].'_class.php';
$classname = $_GET['class'];


$pk    = json_decode(stripcslashes($_GET['pk']),true); 



require_once(Classes."cms/".$class);
require_once(Classes."arch/Form_class.php");
require_once(Classes."order/Table_class.php");


$classelement = new $classname($db,$auth->getSessionId(),$pk);


$classelement->__toString();
