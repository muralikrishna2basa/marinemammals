<?php 
/**
 *  When ajax loading, => the relative path start on the ajax called directory 
 */
if(!isset($db) || !isset($auth))
{
	//include_once('../../directory.inc');

	include_once(Classes."db/Oracle_class.php");
	include_once(Classes."auth/Auth_class.php");
	include_once(Classes."search/searcher_class.php");
	include_once(Functions."Fixcoding.php");

	$cred = parse_ini_file(Ini."db_credentials.ini",true); 

	$user = 'biolib_owner';
	$usr_cred = $cred[$user];
	$db = new ORACLE ($usr_cred['login'],$usr_cred['pass'],$usr_cred['alias']);

	// WEBPAGE SECURED 
	//$auth = new Auth($db,'../Home.php','ohoho');
	//$log = $auth->login();
}
include_once(Classes."search/searcher_class.php");
//$grouplevel = $auth->getSessionGrouplevel();

// GET THE DATA FROM THE AJAX CALL 

if(isset($_GET['search_json'])){ $search_json = $_GET['search_json'];} else { $search_json = '';}
if(isset($_GET['search_sort'])){ $addorder = $_GET['search_sort'];}
if(isset($_GET['search_page'])){ $search_page = $_GET['search_page'];} else {$search_page = 1;}


$searchitems = json_decode(stripcslashes($search_json));

$samples = new Search_Necropsy($db);
//$samples = new Search_Necropsy($db,$grouplevel);

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

// Add Order Capability 
if(isset($_GET['search_sort']) && isset($_GET['sort_type'])) 
{ 
	$samples->addOrder($_GET['search_sort'],$_GET['sort_type']);
	
}

$samples->renderer->setCurrentPage($search_page);

echo $samples;



?>