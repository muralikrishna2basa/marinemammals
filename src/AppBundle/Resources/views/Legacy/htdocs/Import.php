<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

include_once('../directory.inc'); /* Make use of absolute path */


require_once(Classes . "arch/Biolibd_Layout_class.php");


$Layout = new Biolibd_Layout();


$db = $Layout->getDatabase();
$auth = $Layout->getAuth();

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/search.css" />',
    '<script type="text/javascript" src="/legacy/js/cms_plugin.js"></script>',
    '<script type="text/javascript" src="/legacy/js/search_plugin.js"></script>'));

$Layout->addHead(array('<script type="text/javascript" src="/legacy/js/flow_plugin.js"></script>',
    '<script type="text/javascript" src="/legacy/js/import.js"></script>'
));

$accordion = new Accordion('importation');
$accordion->addClass('accordion'); // to be recognized by javascript
$accordion->addClass('importation_accordion');


/*$accordion->addList('Observations',array("#observation_importation_tool"=>'Importation Tool',
                                         "#manage_taxas"=>"Manage Taxas",
                                         "#manage_stations"=>"Manage Stations"));

$accordion->addList('Autopsy',array("#autopsy_importation_tool"=>"Importation Tool"));

$Layout->addAccordionList($accordion);
*/
//$Layout->setInitNavigationId('#manage_specimens');
/*
$taxas_inc = include(Includes.'import_search_taxas.php');
$Layout->addContent('<div id = "manage_taxas">'.$taxas_inc."</div>");

$manage_stations_inc = include(Includes.'import_manage_stations.php');
$Layout->addContent('<div id = "manage_stations">'.$manage_stations_inc."</div>");

$observation_imp = include(Includes.'observation_importation_tool.php');
$Layout->addContent('<div id = "observation_importation_tool">'.$observation_imp."</div>");*/

$autopsy_imp = include(Includes . 'autopsy_importation_tool.php');
$Layout->addContent('<div id = "autopsy_importation_tool">' . $autopsy_imp . "</div>");
//$specimens_inc = include(Includes.'manage_specimens.php');
//$Layout->addContent('<div id = "manage_specimens">'.$specimens_inc."</div>");
//
echo $Layout; // The layout is created and just need to be echoed
?>