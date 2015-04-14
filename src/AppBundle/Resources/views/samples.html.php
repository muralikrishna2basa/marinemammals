<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

include_once(dirname($_SERVER['DOCUMENT_ROOT']).'/directory.inc'); /* Make use of absolute path */

require_once(Classes."arch/Biolibd_Layout_class.php");


$Layout = new Biolibd_Layout("MM: Biobank");

$db = $Layout->getDatabase();

//$auth = $Layout->getAuth();

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/Biobank.css" />',
						'<link rel="stylesheet" type="text/css" href="/legacy/css/search.css" />',
						'<script type="text/javascript" src="/legacy/js/search_plugin.js"></script>',
						'<script type="text/javascript" src="/legacy/js/Biobank.js"></script>'));

/*$navigation_list = array("#description_biobank"=>"Description","#manage_samples"=>"Search for Samples",
						 "#agreement_biobank" =>"Order ( Agreement)","#order_samples"=>"Order ( Review)");


$Layout->addNavigationList('biobank_navigation',$navigation_list,true);
	
$Layout->addHiddenNavigation('biobank_navigation',array("#agreement_biobank","#order_samples"));					 */
						 
/*
$description_biobank_inc = include(Includes.'description_biobank.php');
$Layout->addContent('<div id = "description_biobank">'.$description_biobank_inc.'</div>');*/

$agreement_biobank_inc = include(Includes.'agreement_biobank.php');
$Layout->addContent('<div id = "agreement_biobank">'.$agreement_biobank_inc.'</div>');


$biobank_search_samples_inc = include(Includes.'biobank_search_samples.php');

$Layout->addContent('<div id = "manage_samples">'.$biobank_search_samples_inc.'</div>');

$biobank_order_process_inc = include(Includes.'order_process.php');
$Layout->addContent('<div id = "order_samples">'.$biobank_order_process_inc.'</div>');



//$Layout->cleanHead();

echo $Layout;

?>



