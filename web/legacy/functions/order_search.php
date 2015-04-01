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


$samples = new Search_Orders($db,$auth->getSessionGrouplevel());

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

function status_tr($cell)
{
	if($cell == 'pending'){ return '<img width="20" height="20" align="center" src="/img/button/pending.png"/>'; }
	elseif($cell == 'refused'){return '<img width="20" height="20" align="center" src="/img/button/refused.png"/>';}
	elseif($cell == 'accepted'){return '<img width="20" height="20" align="center" src="/img/button/accepted.png"/>';}
	else { return $cell;}
}

$samples->renderer->addCellFunction('Status','status_tr');

if(isset($_GET['search_sort']) && isset($_GET['sort_type'])) 
{ 
	$samples->addOrder($_GET['search_sort'],$_GET['sort_type']);
	
}


//$samples->renderer->addColumn(array('<input type="checkbox">'=>'<input type="checkbox">'));
//$samples->renderer->addColumn(array('Confirm'=>'<a class = "confirm" href = "#" style="width:100%;height:100%;">v</a>'));
//$samples->renderer->addColumn(array('Deny'=>'<a class ="deny" href = "#" style="width:100%;height:100%;">d</a>'));


$samples->renderer->setCurrentPage($search_page);

echo $samples;



?>