<?php

require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/directory.inc');
require_once(Classes . "db/Oracle_class.php");

require_once(sfMain.'vendor/symfony/symfony/src/Symfony/Component/Yaml/Parser.php');
//require_once(Classes."auth/Auth_class.php");

//require_once(Functions . "Fixcoding.php");

$localhostSrv = array(
    '127.0.0.1',
    '::1'
);
$devSrv = array(
    'dev.marinemammals.be'
);
$prodSrv = array(
    'www.marinemammals.be'
);

$dbParameters = array();
try {
    if (in_array($_SERVER['REMOTE_ADDR'], $localhostSrv)) {
        $dbParameters =  yaml_parse_file(sfMain."app/config/parameters_dev.yml");
    } elseif (in_array($_SERVER['REMOTE_ADDR'], $devSrv)) {
        $dbParameters =  yaml_parse_file(sfMain."app/config/parameters_dev.yml");
    } elseif (in_array($_SERVER['REMOTE_ADDR'], $prodSrv)) {
        $dbParameters =  yaml_parse_file(sfMain."app/config/parameters_prod.yml");
    }
} catch (Exception $e) {
    printf("Unable to parse the YAML string: %s", $e->getMessage());
}

$user=$dbParameters['parameters']['database_user'];
$pass=$dbParameters['parameters']['database_password'];
$alias=$dbParameters['parameters']['database_host'].':'.$dbParameters['parameters']['database_port'].'/'.$dbParameters['parameters']['database_name'];

$db = new ORACLE ($user,$pass, $alias);

// WEBPAGE SECURED
//$auth = new Auth($db,'../Home.php','ohoho');
//$log = $auth->login();
?>