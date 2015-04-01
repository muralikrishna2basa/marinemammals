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
	// GET THE DATA FROM THE AJAX CALL 

if(isset($_GET['search_json'])){ $search_json = $_GET['search_json'];} 
if(isset($_GET['search_sort'])){ $addorder = $_GET['search_sort'];}
if(isset($_GET['search_page'])){ $search_page = $_GET['search_page'];} else {$search_page = 1;}

$searchitems = json_decode(stripcslashes($search_json));


$samples = new Search_Institutes($db);
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

if(isset($_GET['search_sort']) && isset($_GET['sort_type'])) 
{ 
	$samples->addOrder($_GET['search_sort'],$_GET['sort_type']);
	
}



$samples->renderer->setCurrentPage($search_page);

echo $samples;



?>