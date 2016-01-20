<?php
/**
 *   Load samples script 
 *   
 *   Called via the web interface ( i.e if $_POST['testsubmit'] is not set)
 *   or indirectly via the form submission.
 *   
 * 
 */
if(isset($_POST['testsubmit']) && isset($_POST['download_format'])) // call via form submission
{
	require_once('../../directory.inc');

	include_once(Functions.'getAuthDb.php');
	
	include_once(Classes."search/searcher_class.php");
	
	require_once(Classes.'export/Export_interface.php');
	
	$samples = new Search_Samples($db,$auth->getSessionGrouplevel());


	$smples = $_SESSION['samples'];

	$smple_filter = array();
	foreach($smples as $smple)
	{
		$sample_ob = json_decode(stripcslashes($smple));
	     $smple_filter[] = $sample_ob->Seqno;
		
	
	}
	
	$samples->addFilter(array('Filter_Sample_Seqno')); // so that the filter with name id is ready to be used 

	$samples->FilterbyName('ID','in',$smple_filter);
	
	$samples->FilterbyName('specimen','#'); // so that the column specimen is available uh problem

	$samples->FilterbyName('organ','#'); // so that the column specimen is available

	$samples->renderer->addColumn('Taxa'); // render the corresponding column

	$samples->renderer->addColumn('Organs'); // render the corresponding column

	$samples->renderer->RemoveColumn('Sample Type');
	
	$test = $samples->__toString();
	$sql  = $samples->query->sqlquery;
	$binds = $samples->query->bindings;
	unset($binds[':end_row']);
	unset($binds[':start_row']);

    if(count($binds) == 0)
    {
	$r = $db->query($sql);
    }
    else 
    {
 	$r = $db->query($sql,$binds);
    }
	$exports = new Exports();
	
	$xls = $exports->loadClass($_POST['download_format']);

	while($row = $r->fetch() )
	{
		$xls->AddRow($row);
	
	}

	$xls->Download("Order");

}
elseif(!isset($db)) // In that case, the user is surely not allowed to be here, well, an additional test is performed
{
	require_once("../../directory.inc");

	session_start();

	require_once(Classes.'export/Export_interface.php');
	require_once(Classes."db/Oracle_class.php");
	require_once(Classes."auth/Auth_class.php");

//	$cred = parse_ini_file(Ini."db_credentials.ini",true);
//	$user = 'biolib_test';
//	$usr_cred = $cred[$user];
//	$db = new ORACLE ($usr_cred['login'],$usr_cred['pass'],$usr_cred['alias']);
    include_once(Functions.'getAuthDb.php');
	
	$auth = new Auth($db,'../Home.php','ohoho'); 
	$log = $auth->login();
}
else // Call via the web-interface 
{
	$exports = new Exports();
	
	$exports->setExfile('functions/export_order_samples.php');

	echo $exports;
}




?>