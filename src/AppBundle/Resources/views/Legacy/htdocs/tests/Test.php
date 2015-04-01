<?php
require_once("../classes/db/Oracle_class.php");
require_once("../classes/auth/Auth_class.php");

require_once("../classes/arch/Layout_class.php");

/* 
Credentials
*/
$cred = parse_ini_file("../ini/db_credentials.ini",true);
$user = 'biolib_owner';
$usr_cred = $cred[$user];
$db = new ORACLE ($usr_cred['login'],$usr_cred['pass'],$usr_cred['alias']);


/*
Layout 
*/
$Layout = new Biolibd_Layout($db); // the layout object is created
$Layout->setSignout($_SERVER['PHP_SELF']."?action=logout"); // to be used in the body 
$Layout->setAction($_SERVER['PHP_SELF']);




/* 
Authorization process, 
*/
$auth = new Auth($db,'Test.php','ohoho'); // Second argument = redirect url 

/* 
Login capability 
*/

$log = $auth->login();

/*
Display Login error in  the layout
*/
if(isset($log) & is_array($log)) { if(key($log) == true){$Layout->signin->setError(current($log));} } 
else { $Layout->signin->logged($auth->getSessionName()); }


if(isset($_GET['action']) && $_GET['action'] == 'logout') { $auth->logout(); }

//$Layout->setNavigation(false);
$Layout->multidrop->setGroup($auth->getSessionGroupname());
$Layout->render(); // The layout is created and just need to be echoed
echo $Layout->start();

echo "User belong to group of max level: ".$auth->getSessionGrouplevel();
?>
 <p>This is a TEST</p>

<?php
echo $Layout->end();
?>