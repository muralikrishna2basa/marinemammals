<?php
/**
 * 	Autopsy importation tool
 *  Conclusions Screen
 *  VERSION:1.0.0
 *  AUTHOR:DE WINTER JOHAN 
 *  CREATED:20/04/2010
 *  LAST MODIFIED:20/04/2010
 */

include_once(Classes.'import/flow_class.php');

include_once(Functions.'Fixcoding.php');



// Database Access

$db = $this->db;

//  Set javascript & css files, to be loaded dynamically 
$css = "css/autopsy_import/autopsy_conclusions.css";

$js = "js/autopsy_import/autopsy_conclusions.js";


$val = $this->validation;
?>

<input style='display:none;' name='flow' value = '<?php echo $this->flowname; ?>'/>
