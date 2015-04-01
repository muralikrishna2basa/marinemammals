<?php
/**
 *  	Import Place Table
 * 
 * 
 */

// Access databae
$dbAc =  odbc_connect('zeezoogdieren','','');

require_once('../../classes/db/Oracle_class.php');
//development database
$dbOr = new ORACLE('BIOLIB_OWNER','BIOLIB123','BIOLIBD.mumm.ac.be');


$sql = "select name from Persons where ";

?>