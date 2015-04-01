<?php
require_once("../classes/arch/Layout_class.php");
require_once("../classes/db/Oracle_class.php");
$title  = 'Layout test';
$cred = parse_ini_file("../ini/db_credentials.ini",true);
$user = 'biolib_owner';
$usr_cred = $cred[$user];

$db = new ORACLE ($usr_cred['login'],$usr_cred['pass'],$usr_cred['alias']);

$test = new Layout_Test($db,$title);
echo $test->render();

echo $test->end();


?>