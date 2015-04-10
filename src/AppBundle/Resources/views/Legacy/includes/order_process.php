<?php
/**
 *   Include File
 *   Order Process Biobank Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();

require_once(Classes.'arch/Form_class.php');

require_once(Classes.'order/Order_class.php');



$search_selected_samples = <<<EOD
<div id = "search_selected_samples">
<div class = "search_selected_results"></div>
<div class = "Search_search_tool" style="display:none;">
<div class = "search_tool">
<a class="Search_for" href = "" ><span class ="search" title="search for filtered samples"></span></a>
</div>
</div>
</div> 
EOD;


/**
 *  In case the order has been successfully registered 
 *  If the user click on a different link ( admin,...) then if it goes back to the search tool, 
 *  He is going to be redirected to the top of the page
 * 
 * 
 * */

if((!isset($_SESSION['samples']) || count($_SESSION['samples']) == 0) && (isset($_POST['gobackend']) || isset($_POST['clean_samples']) ))
{
		$Layout->NavigateTo('biobank_navigation','#manage_samples');

}

/** In case of a Submit 
 * 
 */
if(isset($_POST['submit']) == true && is_string($_POST['submit']) == true && $_POST['submit'] == 'Add')
{
	$Layout->addNavigationList('biobank_navigation',array("#order_samples"=>"Final Review"),true);	
}

/**
 *  Form Building
 */
$order_form = new Form('Order_form','POST');
		
$order_form->setAttribute('class','default_form');

$order_form->setAttribute('action','/Biobank.php');
		
$order_form_fs  = $order_form->addElement('fieldset')->setLabel('Order');  

$study_description   = $order_form_fs->addElement('textarea', 'Study_Description', array(''), array('label' => 'Study Description :') );

$study_description->addRule('required', 'Description required');	

$order_form->addFooter('<button value="goback" class="order_samples" name="goback" type="submit">Go Back</button>');


/**
 *  In case of a Go back 
 */
if(isset($_POST['goback']) == true && is_string($_POST['goback']) == true && $_POST['goback'] == 'goback')
{
	$Layout->NavigateTo('biobank_navigation','#manage_samples');
	echo $search_selected_samples;
	echo $order_form->__toString();
	$tmp = ob_get_contents();
	ob_end_clean();
	return $tmp;	
}





/* In case the form hasnt been validated*/

if(!$order_form->validate() || $order_form->getValue() == null)
		{
		//$test = include("functions/search_order_samples.php");	
		echo $search_selected_samples;	
		echo $order_form->__toString();
		
		/*if($Layout->getAuth()->getSessionGroupname()!='GUEST')
		{
			include(Web.'functions/export_order_samples.php');
		}*/
            include(WebFunctions.'/export_order_samples.php');
		$tmp = ob_get_contents();
		ob_end_clean();
		return $tmp;	
		}

/**
 *  In case of validation 
 */

$auth = $Layout->getAuth();

$person_seqno = $auth->getSessionId();

// get the samples out of SESSION

if(is_array($_SESSION['samples'])!= true || count($_SESSION['samples']) == 0) { return false;}

$samples_tmp = $_SESSION['samples'];

$samples_seqno = array();
foreach($samples_tmp as $item)
{ 
	$samples_tmp = json_decode(stripcslashes($item))->Seqno;
	if($samples_tmp!= null) {$samples_seqno[]= $samples_tmp;} 
}

$study_description_value = $study_description->getValue();

$order_class = New Order($db);

$order_class->CreateOrder($study_description_value,$samples_seqno,array($person_seqno=>'RSR'),true);


if($order_class->isError == true) 
{

$Layout->unhideNavigation('#order_samples');	

$Layout->updateNavigationItem('biobank_navigation','#order_samples',"Order( Final)");

$Layout->NavigateTo('biobank_navigation','#order_samples');


echo "error<br>".$order_class->errormessage;

echo '<form method="POST" action = "'.$php_self.'"><button value="goback" class="order_samples" name="goback" type="submit">Go Back</button></form>';

}
else 
{
$Layout->unhideNavigation('#order_samples');	

$Layout->updateNavigationItem('biobank_navigation','#order_samples',"Order( Final)");

$Layout->NavigateTo('biobank_navigation','#order_samples');

echo "Your order has been successfully entered. A mail has been sent to your registrated mailbox. 
<br>The team in charge will proceed your request has soon as possible";	

$php_self = $_SERVER['PHP_SELF'];

echo '<form method="POST" action = "'.$php_self.'"><button value="gobackend" class="order_samples" name="gobackend" type="submit">Go Back</button></form>';

unset($_SESSION['samples']);

}

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>