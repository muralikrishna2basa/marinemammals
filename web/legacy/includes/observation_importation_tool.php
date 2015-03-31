<?php
/**
 *   Observation importation tool
 *   Include File
 *   Description Import Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER : De Winter Johan
 *   LAST MODIFIED DATE:01/03/2010 
 */
ob_start();

// Javascript masked input capability - to be used with the first flow page

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />',
						'<link rel="stylesheet" type="text/css" href="css/flow.css" />',
						'<script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"></script>',
						'<script type="text/javascript" src="js/jquery.autocomplete.js"></script>'));


// Create the flow, link all pages together 

require_once(Classes.'import/flow_class.php');
include_once(Classes."import/validation_class.php");

$flow = new Flow(Web."functions/flow_remote.php",'observation');
//
$flow->addInclude(array('observation_flow_zero'=>Classes."import/observations/observation_flow_zero.php",
						'observation_flow_one'=>Classes."import/observations/observation_flow_one.php",
						'observation_flow_two'=>Classes."import/observations/observation_flow_two.php",
						'observation_flow_three'=>Classes."import/observations/observation_flow_three.php",
						'observation_flow_four'=>Classes."import/observations/observation_flow_four.php"));
						
						
$flow->addJsCss(array('observation_flow_zero'=>array('css'=>'css/observation_flow_zero.css','js'=>'js/observation_flow_zero.js'),
					'observation_flow_one'=>array('css'=>'css/observation_flow_one.css','js'=>'js/observation_flow_one.js'),
					'observation_flow_two'=>array('css'=>'css/observation_flow_two.css','js'=>'js/observation_flow_two.js'),
					'observation_flow_three'=>array('css'=>'css/observation_flow_three.css','js'=>'js/observation_flow_three.js'),
					'observation_flow_four'=>array('css'=>'css/observation_flow_four.css','js'=>'js/observation_flow_four.js')

));						

$flow->setStateBar(array('Event List','Event Details','Specimen','Contact','Medias'));

//$flow->addInclude(array(Classes."import/observations/observation_flow_two.php"));


// Save the actual flow, i.e include the Object in the Session						
						
$flow->save();

// Doesn't make use of an Ajax Request at load time

echo "<div class='container_action'>";
include("functions/flow_remote.php");
echo "</div>";


// Output the buffer

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;

?>