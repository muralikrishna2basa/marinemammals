<?php

/**
 *   Output json data's 
 *   used by ajax, modify interface person 
 *  
 *   input : seqno, output json attributes ( interface related)
 * 
 * */

require_once('../../directory.inc');
require_once(Classes."db/Oracle_class.php");
require_once(Classes."auth/Auth_class.php");
require_once(Classes."order/Person_class.php");

$cred = parse_ini_file(Ini."db_credentials.ini",true); // the parse_ini_file use a relative path...

$user = 'biolib_owner';
$usr_cred = $cred[$user];
$db = new ORACLE ($usr_cred['login'],$usr_cred['pass'],$usr_cred['alias']);

$auth = new Auth($db,'../Home.php','ohoho'); // Second argument = redirect url 
$log = $auth->login(); // store login in session and secure session 

// test 


if(isset($_GET['seqno'])){ $seqno = $_GET['seqno'];} else {$seqno = $auth->getSessionId();}
//$seqno = 1;

$person = new Person($db,$seqno);

if($person->isError){ return $person->errormessage;}

$person_attributes = $person->getAttributes();


$person_groups = $person->groups;

$institutes = $person->getInstitutes();

echo json_encode(array('person'=>fixEncoding($person_attributes),'groups'=>$person_groups,'institutes'=>fixEncoding($institutes)));
// json 






?>