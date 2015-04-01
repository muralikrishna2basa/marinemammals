<?php

include_once('../directory.inc'); /* Make use of absolute path */
require_once(Classes."arch/Biolibd_Layout_class.php");


$Layout = new Biolibd_Layout();



$db = $Layout->getDatabase();


$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="css/Home.css" />'));

$Layout->addNavigationList('Home_navigation',array("#home_description"=>"Description",
												   "#home_contacts"=>"Contacts",
												   "#partners"=>"Partners"),true);



$observations = include(Includes.'home_observations.php');

$Layout->addContent('<div id = "home_description">'.$observations."</div>");

$library = include(Includes.'home_library.php');

$Layout->addContent('<div id = "home_contacts">'.$library."</div>");

$autopsy = include(Includes.'home_autopsies.php');

$Layout->addContent('<div id = "partners">'.$autopsy."</div>");

echo $Layout; // The layout is created and just need to be echoed


