<?php 
if(!isset($db) || !isset($auth))
{
	require_once('../../directory.inc');

	include_once(Functions.'getAuthDb.php');
	
	include_once(Classes."search/searcher_class.php"); 
}
$grouplevel = $auth->getSessionGrouplevel();

if(isset($_GET['search_json'])){ $search_json = $_GET['search_json'];} 
if(isset($_GET['search_sort'])){ $addorder = $_GET['search_sort'];}
if(isset($_GET['search_page'])){ $search_page = $_GET['search_page'];} else {$search_page = 1;}

$searchitems = json_decode(stripcslashes($search_json));


$samples = new Search_Samples($db,$grouplevel);

if(isset($_GET['search_ppr']) && $_GET['search_ppr']!='undefined' )
{
$samples->renderer->pager->rows_per_page = $_GET['search_ppr'];
} 

// The filter is first added so that the filterbyname won't give an error
$samples->addFilter(array('Filter_Sample_Request_Loans_Seqno'));

$countfilters = 0;

if($searchitems instanceof stdClass)
{

foreach($searchitems as $searchitem)
{
	if($searchitem != 'dum')
	{
			$operator = htmlentities($searchitem->operator, ENT_QUOTES, 'UTF-8');
		$samples->FilterbyName($searchitem->filter,$operator,fixDecoding($searchitem->field));
	$countfilters +=1;
	}
}
}
if($countfilters == 0) { return false; } // so that it doesnt search for samples not linked with the order

$samples->FilterbyName('Taxa','#'); // so that the column specimen is available uh problem
$samples->FilterbyName('Organ','#'); // so that the column specimen is available
$samples->renderer->addColumn('Taxa'); // render the corresponding column
$samples->renderer->addColumn('Organ'); // render the corresponding column


$samples->renderer->hidesearch = true;

function availability_tr($cell)
{
	if($cell == 'yes'){ return '<img width="20" height="20" align="center" src="/img/green.png"/>'; }
	elseif($cell == 'no'){return '<img width="20" height="20" align="center" src="/img/red.png"/>';}
	else { return $cell;}
}

$samples->renderer->addCellFunction('Availability','availability_tr');

if(isset($_GET['search_sort']) && isset($_GET['sort_type'])) 
{ 
	$samples->addOrder($_GET['search_sort'],$_GET['sort_type']);
	
}


$samples->renderer->build($search_page);

echo "<div class ='samples_order'>";
echo $samples->renderer->table;
echo "</div>";


?>


