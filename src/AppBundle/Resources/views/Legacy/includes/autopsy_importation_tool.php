<?php
/**
 *   Autopsy importation tool
 *   Include File
 *   Description Import Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER : De Winter Johan
 *   LAST MODIFIED DATE:20/04/2010 
 */
ob_start();

// Javascript masked input capability - to be used with the first flow page

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/jquery.autocomplete.css" />',
						'<link rel="stylesheet" type="text/css" href="/legacy/css/flow.css" />',
						'<script type="text/javascript" src="/legacy/js/jquery.maskedinput-1.2.2.js"></script>',
						'<script type="text/javascript" src="/legacy/js/jquery.autocomplete.js"></script>'));


// Create the flow, link all pages together 

include_once(Classes.'import/flow_class.php');

$flow = new Flow(WebFunctions."flow_remote.php",'autopsy');
//
$flow->addInclude(array('autopsy_init'=>Classes."import/autopsies/autopsy_init.php",
						'create_autopsy_event'=>Classes."import/autopsies/create_autopsy_event.php",
						'contact_details'=>Classes."import/autopsies/contact_details.php",
						'specimen_link'=>Classes."import/autopsies/specimen_link.php",
						'global_parameters'=>Classes."import/autopsies/global_parameters.php",
						'macro_organ_lesions'=>Classes."import/autopsies/macro_organ_lesions.php",
						'micro_organ_lesions'=>Classes."import/autopsies/micro_organ_lesions.php",
						'samples'=>Classes."import/autopsies/samples.php",
						'medias'=>Classes."import/autopsies/medias.php",
						'conclusions'=>Classes."import/autopsies/conclusions.php"));

$flow->addJsCss(array('autopsy_init'=>array('css'=>'/legacy/css/autopsy_import/autopsy_autopsy_init.css','js'=>'/legacy/js/autopsy_import/autopsy_autopsy_init.js'),
					  'create_autopsy_event'=>array('css'=>'/legacy/css/autopsy_import/autopsy_create_autopsy_event.css','js'=>'/legacy/js/autopsy_import/autopsy_create_autopsy_event.js'),
					  'contact_details'=>array('css'=>'/legacy/css/autopsy_import/autopsy_contact_details.css','js'=>'/legacy/js/autopsy_import/autopsy_contact_details.js'),
					  'specimen_link'=>array('css'=>'/legacy/css/autopsy_import/autopsy_specimen_link.css','js'=>'/legacy/js/autopsy_import/autopsy_specimen_link.js'),
					  'global_parameters'=>array('css'=>'/legacy/css/autopsy_import/autopsy_global_parameters.css','js'=>'/legacy/js/autopsy_import/autopsy_global_parameters.js'),
					  'macro_organ_lesions'=>array('css'=>'/legacy/css/autopsy_import/autopsy_macro_organ_lesions.css','js'=>'/legacy/js/autopsy_import/autopsy_macro_organ_lesions.js'),
					  'micro_organ_lesions'=>array('css'=>'/legacy/css/autopsy_import/autopsy_micro_organ_lesions.css','js'=>'/legacy/js/autopsy_import/autopsy_micro_organ_lesions.js'),
					  'samples'=>array('css'=>'/legacy/css/autopsy_import/autopsy_samples.css','js'=>'/legacy/js/autopsy_import/autopsy_samples.js'),
					  'medias'=>array('css'=>'/legacy/css/autopsy_import/autopsy_medias.css','js'=>'/legacy/js/autopsy_import/autopsy_medias.js'),
					  'conclusions'=>array('css'=>'/legacy/css/autopsy_import/autopsy_conclusions.css','js'=>'/legacy/js/autopsy_import/autopsy_conclusions.js')
));						
						

//$flow->addInclude(array(Classes."import/autopsies/global_parameters.php"));


$flow->setStateBar(array('Pick Event',
						 'Create Necropsy',
						 'Contacts',
						 'Specimens',
						 'Global Parameters',
						 'Macroscopic Lesions',
						 'Microscopic Lesions',
						 'Samples',
						 'Medias',
						 'Conclusions'));
						 
				 

// Save the actual flow, i.e include the Object in the Session						
						
$flow->save();

// Doesn't make use of an Ajax Request at load time

echo "<div class='container_action'>";
include(WebFunctions."flow_remote.php");
echo "</div>";


// Output the buffer

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;

?>