<?php


//class A 
//{
//	public function __toString()
//	{
//		ob_start();
//		
//		echo "a";
//			
//		$tmp = ob_get_contents();ob_end_clean();
//		
//		return $tmp;
//	}
//}


require_once('../../directory.inc'); /* Make use of absolute path */
require_once(Classes."db/Oracle_class.php");
require_once(Classes."order/Person_class.php");
require_once(Classes."cms/institute_class.php");
require_once(Classes."arch/Form_class.php");
require_once(Classes."order/Table_class.php");



$cred = parse_ini_file(Ini."db_credentials.ini",true);
$user = 'biolib_owner';
$usr_cred = $cred[$user];

$db = new ORACLE ($usr_cred['login'],$usr_cred['pass'],$usr_cred['alias']);

$person = new Person($db,1);

$pk = array('Seqno'=>'1');

$institute = new Institute($db,$person,$pk);

echo $institute;

?>