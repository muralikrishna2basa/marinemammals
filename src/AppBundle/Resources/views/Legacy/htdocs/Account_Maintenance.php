<?php
ob_start();
/**
 * 	Account Maintenance
 * 
 * 
 */
include_once('../directory.inc'); /* Make use of absolute path */

require_once(Classes."arch/Biolibd_Layout_class.php");

require_once(Classes."auth/AccountMaintenance_class.php");

include_once(Classes."auth/Captcha_class.php");

require_once(Classes."arch/Form_class.php");

$Layout = new Biolibd_Layout();

$db = $Layout->getDatabase();

$auth = $Layout->getAuth();

$menus = $Layout->getMenus();

// Menu tweak

$menus->setHidden('Account Maintenance',false);

$menus->setHidden('Register',true);

// Create new Captcha

$captcha = new Captcha(Classes."auth/Fonts/","img/regimg/");

$account_maintenance = new AccountMaintenance($db,$auth);

// In case a code has been submitted
if(isset($_GET['code']) && is_string($_GET['code']))
{
	$account_maintenance->resetPassword($_GET['code']);	
// error	
	if($account_maintenance->isError)
	{
	echo "<p>A problem occured while resetting your password. </p>";
	echo "<p>The error is : $account_maintenance->errormessage</p>";
	echo "<p>Try again, if this problem is repeating please consider contacting the Biobank Webmaster</p>"; 
	$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>Error</a></li></ul></div>");
	$Layout->addContent(ob_get_contents());
	ob_end_clean();
	echo $Layout;
	return;		
	}
	
	$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>Success</a></li></ul></div>");
	echo "<p>Your account has been successfully resetted</p>";
	echo "<p>Please login using the password send to your mailbox</p>";
	echo "<p>To change your password, please go on the User tab</p>";
	$Layout->addContent(ob_get_contents());
	ob_end_clean();
	echo $Layout;
	return;
	
}


// Create form

$ame_form = new Form('Account_Maintenance','POST');

$ame_form->setAttribute('action',$_SERVER['PHP_SELF']);

$ame_form->setAttribute('class','default_form');

$ame_fieldset = $ame_form->addElement('fieldset');

$email_fs = $ame_fieldset->addElement('text', 'Email', array('style' => 'width: 300px;'), array('label' => 'Email:') );

$security_fs = $ame_form->addElement('fieldset')->setLabel('Security');  //FIELDSET

$security_text = $security_fs->addElement('text', 'captcha_text', array('style' => 'width: 150px;'), array('label' => 'Answer:') );


// Rules

function captcha_check($arg)
{
	global $captcha;
	return $captcha->checkCaptcha($arg);
	
}

$security_text->addRule('callback','Captcha Not Valid',"captcha_check");

$email_fs->addRule('required','Email required');

function emailcheck($arg)
{
	return filter_var($arg,FILTER_VALIDATE_EMAIL);
}

if(function_exists('filter_var'))
{
	$email_fs->addRule('callback','Not a valid email inserted','emailcheck');
}
else 
{
	$email_fs->addRule('regex','Not a valid email inserted','([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})');
}
// In case the form hasn't been validated
if(!$ame_form->validate())
{
	$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>First Step</a></li></ul></div>");
	
	$captcha->CreateImage();
	
	$security_captcha = $security_fs->addElement('image','captcha',array('src'=> $captcha->getImage(),
 																'alt'=>'Captcha Image'))->setLabel('Captcha:');
	 	
	echo "<p>Please enter your personal email address in the form below.</p>";

	echo "<p>Further instruction will be send to your registrated address.</p>";
	 
	$ame_form->__toString();
	
	$Layout->addContent(ob_get_contents());
	
	ob_end_clean();

	echo $Layout;				
	
	return;
}
// In case the form has been validated

$v =$ame_form->getValue();

$account_maintenance->checkEmailUser($v['Email']);

// In case an error popped up
if($account_maintenance->isError)
{ 
	echo "<p>A problem occured while retrieving your account. </p>";
	echo "<p>The error is : $account_maintenance->errormessage</p>";
	echo "<p>Try again, if this problem is repeating please consider contacting the Biobank Webmaster</p>"; 
	$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>Error</a></li></ul></div>");
	$Layout->addContent(ob_get_contents());
	ob_end_clean();
	echo $Layout;
	return;
}
// In case the account has been successfully retrieved

$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>Success</a></li></ul></div>");
echo "<p>An account match the submitted email address</p>";
echo "<p>A message has been send to your email address</p>";
echo "<p>Please click on the link provided in the message send to you</p>";
$Layout->addContent(ob_get_contents());
ob_end_clean();
echo $Layout;
return;
?>