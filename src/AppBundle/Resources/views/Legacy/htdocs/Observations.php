<?php


include_once('../directory.inc'); /* Make use of absolute path */


require_once(Classes."arch/Biolibd_Layout_class.php");

$Layout = new Biolibd_Layout();

$Layout->addHead(array('<script type="text/javascript" src="js/spec2events_search.js"></script>'));

$db = $Layout->getDatabase();
$auth = $Layout->getAuth();
$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="css/search.css" />',
						'<script type="text/javascript" src="js/cms_plugin.js"></script>',
						'<script type="text/javascript" src="js/search_plugin.js"></script>',
						'<link rel="stylesheet" type="text/css" href="css/observations.css" />'));

$Layout->addNavigationList('observations_navigation',array("#observations_description"=>"Description",
													  "#observations_search"=>"Search"),true);		
						
$db = $Layout->getDatabase();

$auth = $Layout->getAuth();

$observations_description_inc = include(Includes.'observations_description.php');
$Layout->addContent('<div id = "observations_description">'.$observations_description_inc."</div>");

$observations_search_inc = include(Includes.'observations_search_inc.php');
$Layout->addContent('<div id = "observations_search">'.$observations_search_inc."</div>");


echo $Layout; // The layout is created and just need to be echoed