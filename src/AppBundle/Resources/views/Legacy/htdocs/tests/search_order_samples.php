<?php 
/**
 *  When ajax loading, => the relative path start on the ajax called directory 
 */

require_once('../../directory.inc');

/**
 *   Search in the database and render the results 
 *   method get for the ajax call,
 *   Searcher dependent, because one might add or remove columns
 */
require_once(Classes."db/Oracle_class.php");
require_once(Classes."auth/Auth_class.php");
include_once(Classes."search/searcher_class.php");
require_once(Functions."Fixcoding.php");
$cred = parse_ini_file(Ini."db_credentials.ini",true); 

$user = 'biolib_owner';
$usr_cred = $cred[$user];
$db = new ORACLE ($usr_cred['login'],$usr_cred['pass'],$usr_cred['alias']);



// WEBPAGE SECURED 
$auth = new Auth($db,'../Home.php','ohoho'); 
if(is_array($_SESSION['samples'])!= true || count($_SESSION['samples']) == 0) { return false;}
$log = $auth->login(); 

// GET THE DATA FROM THE AJAX CALL 

if(isset($_GET['search_json'])){ $search_json = $_GET['search_json'];} 
if(isset($_GET['search_sort'])){ $addorder = $_GET['search_sort'];}
if(isset($_GET['search_page'])){ $search_page = $_GET['search_page'];} else {$search_page = 1;}



$samples = new Search_Samples($db);

if(isset($_GET['search_ppr']) && $_GET['search_ppr']!='undefined' )
{
$samples->renderer->pager->rows_per_page = $_GET['search_ppr'];
}


$samples_tmp = $_SESSION['samples'];

echo "session_samples".implode("<br>",$samples_tmp);

$samples_seqno = array();


foreach($samples_tmp as $item)
{ 
	$samples_tmp = json_decode(stripcslashes($item))->Seqno;
	echo "<br>".$samples_tmp;
	if($samples_tmp!= null) {$samples_seqno[]= $samples_tmp;} 
}
echo "samples_tmp".implode("<br>",$samples_tmp);
$samples->addFilter(array('Filter_Sample_Seqno')); // so that the filter with name id is ready to be used 

$samples->FilterbyName('ID','in',$samples_seqno);
$samples->FilterbyName('specimen','!=','infinity'); // so that the column specimen is available uh problem
$samples->FilterbyName('organ','!=','infinity'); // so that the column specimen is available
$samples->renderer->addColumn('Taxa'); // render the corresponding column
$samples->renderer->addColumn('Organs'); // render the corresponding column
$samples->renderer->RemoveColumn('Sample Type');

if(isset($addorder)) { $samples->addOrder($addorder);}
//$samples->renderer->hidefooter = true;
$samples->renderer->setCurrentPage($search_page);

echo $samples;



?>