<?php
	require_once(Classes."db/Oracle_class.php");
	
	require_once(Classes."auth/Auth_class.php");

	require_once(Functions."Fixcoding.php");

	$cred = parse_ini_file(Ini."db_credentials.ini",true); 

	$user = 'biolib_owner';
	$usr_cred = $cred[$user];
	$db = new ORACLE ($usr_cred['login'],$usr_cred['pass'],$usr_cred['alias']);

	// WEBPAGE SECURED 
	$auth = new Auth($db,'../Home.php','ohoho'); 
	$log = $auth->login();
?>