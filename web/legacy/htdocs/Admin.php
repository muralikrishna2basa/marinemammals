<?php

include_once('../directory.inc'); /* Make use of absolute path */
require_once(Classes."arch/Biolibd_Layout_class.php");


$Layout = new Biolibd_Layout();

$db = $Layout->getDatabase();

$auth = $Layout->getAuth();


require_once(Classes."arch/Form_class.php");
require_once(Classes."order/Table_class.php");
require_once(Classes."cms/Institute_class.php");
require_once(Classes."cms/Person_class.php");
require_once(Classes."cms/Sample_class.php");



$Layout->addNavigationList('admin_navigation',array("#manage_orders"=>"Manage Orders",
                                                    "#confirm_order"=>"Confirm Order",
													"#deny_order"=>"Deny Order",
													"#delete_order"=>"Delete Order",
													"#manage_users"=>"Manage Users",	
													"#manage_institutes"=>"Manage Institutes",
						 							"#containers"=>"Containers",
						 							"#manage_samples"=>"Manage Samples"),true);		

$Layout->addHiddenNavigation('admin_navigation',array("#confirm_order","#deny_order","#delete_order"));		
						 							
$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="css/search.css" />',
						'<script type="text/javascript" src="js/cms_plugin.js"></script>',
						'<script type="text/javascript" src="js/search_plugin.js"></script>',
						'<script type="text/javascript" src="js/jquery.tablesorter.js"></script>'));


						
$order_inc = include(Includes.'order.php');
$Layout->addContent('<div id = "manage_orders">'.$order_inc."</div>");

$user_inc = include(Includes.'manage_users.php');
$Layout->addContent('<div id = "manage_users">'.$user_inc.'</div>');
//
////
$institute_inc = include(Includes.'manage_institutes.php');
$Layout->addContent('<div id = "manage_institutes">'.$institute_inc.'</div>');
//
$confirm_order_inc = include(Includes.'confirm_order.php');
$Layout->addContent('<div id = "confirm_order" style="display:none;">'.$confirm_order_inc.'</div>');
// 
$deny_order_inc = include(Includes.'deny_order.php');
$Layout->addContent('<div id = "deny_order" style="display:none;">'.$deny_order_inc.'</div>');
//
$delete_order_inc = include(Includes.'delete_order.php');
$Layout->addContent('<div id = "delete_order" style="display:none;">'.$delete_order_inc.'</div>');

//
//
//
$container_inc = include(Includes.'containers.php');
$Layout->addContent('<div id="containers">'.$container_inc.'</div>');
//
$sample_inc = include(Includes.'manage_samples.php');
$Layout->addContent('<div id = "manage_samples">'.$sample_inc.'</div>');

//
//$Layout->addContent('<div id = "other"> This is the place reserved for other things</div>');
// 

echo $Layout;

echo '<ul id="myMenu" class="contextMenu">
			<li class="Details separator"><a href="#Details">Details</a></li>
			<li class="confirm separator"><a href="#confirm_order">Confirm</a></li>
			<li class="Deny separator"><a href="#deny_order">Deny</a></li>
			<li class="Delete separator"><a href="#delete_order">Delete</a></li>
</ul>
'
;
?>