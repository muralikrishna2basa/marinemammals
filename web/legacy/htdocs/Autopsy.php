<?php

include_once('../directory.inc'); /* Make use of absolute path */
require_once(Classes."arch/Biolibd_Layout_class.php");

$Layout = new Biolibd_Layout();

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="css/autopsy.css" />',
						'<link rel="stylesheet" type="text/css" href="css/slimbox2/slimbox2.css" />',
						'<script type="text/javascript" src="js/autopsy.js"></script>',
						'<script type="text/javascript" src="js/slimbox2.js"></script>'));

$Layout->addNavigationList('Autopsy_navigation',array("#autopsy_1"=>"Introduction",
												   "#autopsy_2"=>"Necropsy",
												   "#autopsy_3"=>"General Procedure",
												   "#autopsy_4"=>"Small Cetaceans",
												   "#autopsy_5"=>"Pinnipeds",
												   "#autopsy_6"=>"Large Cetaceans",
												   "#autopsy_7"=>"References",
												  ),true);
												   
												   
$autopsy_1 = include(Includes.'autopsy_autopsy_1.php');

$Layout->addContent('<div id = "autopsy_1">'.$autopsy_1."</div>");	


$autopsy_2 = include(Includes.'autopsy_autopsy_2.php');

$Layout->addContent('<div id = "autopsy_2">'.$autopsy_2."</div>");

$autopsy_3 = include(Includes.'autopsy_autopsy_3.php');

$Layout->addContent('<div id = "autopsy_3">'.$autopsy_3."</div>");

$autopsy_4 = include(Includes.'autopsy_autopsy_4.php');

$Layout->addContent('<div id = "autopsy_4">'.$autopsy_4."</div>");

$autopsy_5 = include(Includes.'autopsy_autopsy_5.php');

$Layout->addContent('<div id = "autopsy_5">'.$autopsy_5."</div>");

$autopsy_6 = include(Includes.'autopsy_autopsy_6.php');

$Layout->addContent('<div id = "autopsy_6">'.$autopsy_6."</div>");

$autopsy_7 = include(Includes.'autopsy_autopsy_7.php');

$Layout->addContent('<div id = "autopsy_7">'.$autopsy_7."</div>");


echo $Layout; // The layout is created and just need to be echoed

?>