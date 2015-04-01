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
include_once(Classes.'cms/Tree_class.php');

$grouplevel = $auth->getSessionGrouplevel();

// GET THE DATA FROM THE AJAX CALL 

if(isset($_GET['search_json'])){ $search_json = $_GET['search_json'];} 
if(isset($_GET['search_sort'])){ $addorder = $_GET['search_sort'];}
if(isset($_GET['search_page'])){ $search_page = $_GET['search_page'];} else {$search_page = 1;}


$searchitems = json_decode(stripcslashes($search_json));



$samples = new Search_Samples($db,$grouplevel);

if(isset($_GET['search_ppr']) && $_GET['search_ppr']!='undefined' )
{
$samples->renderer->pager->rows_per_page = $_GET['search_ppr'];
} 
else 
{
$samples->renderer->pager->rows_per_page = 5;	
}
if($searchitems instanceof stdClass)
{
foreach($searchitems as $searchitem)
{
	if($searchitem != 'dum')
	{
			$operator = htmlentities($searchitem->operator, ENT_QUOTES, 'UTF-8');
		$samples->FilterbyName($searchitem->filter,$operator,fixDecoding($searchitem->field));
	}
}
}
// 

$samples->FilterbyName('localization seqno','#'); 

$samples->renderer->addColumn('Container Localization'); // render the corresponding column // must be before the ordering capability 


$samples->FilterbyName('organ','#'); // so that the column specimen is available
$samples->renderer->addColumn('Organs'); // render the corresponding column

// Add Order Capability 

function availability_tr(&$cell)
{
	if($cell == 'yes'){ return '<img width="20" height="20" align="center" src="/img/green.png"/>'; }
	elseif($cell == 'no'){return '<img width="20" height="20" align="center" src="/img/red.png"/>';}
	else { return $cell;}
}

$samples->renderer->addCellFunction('Availability','availability_tr');

function container_tr(&$cell)
{
	global $db;
	$sql = "select * from container_localizations where seqno = $cell";
	$r = $db->query($sql)->fetch();
	if($db->isError()){ return $cell;}
	
	$mapobjects = array('INST'=>'Institute_Object',
								  'BOX'=>'Box_Object',
								  'MIC'=>'Mic_Object',
								   'ROOT'=>'Root_Object',
								   'FR'=>'Fr_Object',
								   'RANK'=>'Rank_Object'); 
	if(array_key_exists($r['CONTAINER_TYPE'],$mapobjects))
	{
		$rcontainer = $r['CONTAINER_TYPE'];
		$object = $mapobjects[$rcontainer];
		$object_class = new $object($r['NAME'],$cell);
		return $object_class->__toString();
	}
	else 
	{
		return $cell;
	}

}
$samples->renderer->addCellFunction('Container Localization','container_tr');


if(isset($_GET['search_sort']) && isset($_GET['sort_type'])) 
{ 
	$samples->addOrder($_GET['search_sort'],$_GET['sort_type']);

}



$samples->renderer->setCurrentPage($search_page);

echo $samples;



?>