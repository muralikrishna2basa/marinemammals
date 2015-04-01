<?php

include_once('../directory.inc'); /* Make use of absolute path */
require_once(Classes."arch/Biolibd_Layout_class.php");
require_once(Classes."cms/Person_class.php");
require_once(Classes."order/Table_class.php");

$Layout = new Biolibd_Layout();

$db = $Layout->getDatabase();

$auth = $Layout->getAuth();



$Layout->addNavigationList('user_navigation',array("#update_informations"=>"Update Infos",
                                                    "#change_password"=>"Change Password",
                                                    "#view_orders"=>"View Orders"),true);

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="css/user.css" />'));                                                    


$updateinfos = include(Includes.'user_update_informations.php');
$Layout->addContent('<div id = "update_informations">'.$updateinfos."</div>");


$changepassword = include(Includes.'user_change_password.php');
$Layout->addContent('<div id = "change_password">'.$changepassword."</div>");

$vieworders = include(Includes.'user_view_orders.php');
$Layout->addContent('<div id = "view_orders">'.$vieworders."</div>");

echo $Layout; // The layout is created and just need to be echoed
