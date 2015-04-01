<?php
ob_start();
/**
 *   Registration Method v1.0.0 
 *  
 *   Basic registration process with email verification. 
 * 
 * 	 After confirmation the registrant is set into the persons table from database, 
 *   and might login.   
 *
 */
include_once('../directory.inc'); /* Make use of absolute path */

require_once(Classes."arch/Biolibd_Layout_class.php");

$Layout = new Biolibd_Layout();

$db = $Layout->getDatabase();

require_once(Classes."arch/Form_class.php");

require_once(Classes."auth/Signup_class.php");

include_once(Classes."auth/Captcha_class.php");


$captcha = new Captcha(Classes."auth/Fonts/","img/regimg/");




$captcha->CreateImage();

/**
 *  Creation of a random image name
 */


/*  
Init Variables 
*/

$Layout->addHead(array('<script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"></script>',
						'<script type="text/javascript" src="js/register_login.js"></script>',
					   '<link rel="stylesheet" type="text/css" href="css/Register.css" />'));

$reg_messages = array('success' =>array('title'=>'Confirmation Successful',
					  					'content'=>'<p>Thank you. Your account has now been confirmed.<br> You can now login'),
					 'confirm_error'=>array('title'=>'Confirmation Problem',
					 						'content'=>'<p>There was a problem confirming your accound.<br> Please try again or contact
					 						the site administrators'),
					 'email_sent'=>array('title'=>'check your email',
					 					 'content'=>'<p>Thank you. Please can you confirm your account by clicking on the link provided 
					 					 				in the message sent to your email address.</p>'	),
					 'email_error'=>array('title'=>'Email Problem','content'=>'<p>Unable to send confirmation email.<br>Please 
					 								contact the site administrator'),
					 'signup_error'=>array('title'=>'Registration Problem','content'=>'<p>There was an error creating your account.<br>
					 								 </p>')							
					 );

$listener = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$frmName = 'De Winter';

$frmAddress = 'johan.dewinter@mumm.ac.be';

$subj = "Account Confirmation";
$pwd = $_POST['PASSWORD'];
$lgn = $_POST['LOGIN_NAME'];
$msg = <<<EOD
<html>
<body>
<h2> Thank you for registering !</h2>
<div>Your contact details are $lgn:$pwd</div>
<div>In case you forgot your password please contact the webmaster.</div>
<div> The final step is to confirm your account by clicking on : </div>
<div><confirm_url/></div>
<div>
<b> BIOLIBD team </b>
</div>
</body>
</html>
EOD;

$login_name = 'LOGIN_NAME';$password   = 'PASSWORD';$last_name  = 'LAST_NAME';$first_name = 'FIRST_NAME';

$address = 'ADDRESS';$phone_number = 'PHONE_NUMBER';$email = 'EMAIL';$sex = 'SEX';$title = 'TITLE'; 

$signup = new Signup($db,$listener,$frmName,$frmAddress,$subj,$msg,true);

/**
 *  Form Creation 
 * 
 */
$person_form = new Form('Register_form','POST');

$person_form->setAttribute('action',$_SERVER['PHP_SELF']);

$person_form->setAttribute('class','default_form');

$person_form_fs  = $person_form->addElement('fieldset')->setLabel('Login Informations');  //FIELDSET

$login_name_fs   = $person_form_fs->addElement('text', $login_name, array('style' => 'width: 100px;'), array('label' => 'Login Name:') );

$password_fs     = $person_form_fs->addElement('password', $password, array('style' => 'width: 100px;'), array('label' => 'Password:') );

$password_fs_cfm = $person_form_fs->addElement('password', $password.'_cfm', array('style' => 'width: 100px;'), array('label' => 'Confirm password:') );

$pers_details    = $person_form->addElement('fieldset')->setLabel('Contact details');  //FIELDSET

$last_name_fs    = $pers_details->addElement('text', $last_name, array('style' => 'width: 100px;'), array('label' => 'Last Name:') );

$first_name_fs   = $pers_details->addElement('text', $first_name, array('style' => 'width: 100px;'), array('label' => 'First Name:') );

$address_fs      = $pers_details->addElement('text', $address, array('style' => 'width: 400px;'), array('label' => 'Professional Address:') );

$phone_number_fs = $pers_details->addElement('text', $phone_number , array(), array('label' => 'Phone Number:') );

$email_fs        = $pers_details->addElement('text', $email, array('style' => 'width: 150px;'), array('label' => 'Email:') );

$security = $person_form->addElement('fieldset')->setLabel('Security');  //FIELDSET

$sql = "select rv_low_value from cg_ref_codes where rv_domain = 'PSN_TITLE'";
$res = $db->query($sql);
$row = $res->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
$psn_title = $row['RV_LOW_VALUE'];

$title_array = array(NULL=>NULL) + array_combine($psn_title,$psn_title);

$title_fs = $pers_details->addElement('select', $title, array('style' => 'width: 40px;'), array('label' => 'Title:') );

$title_fs->loadOptions($title_array);

// load questions
//include(Includes."questions.php");
//
//$position_question = rand(0,count($questions)-1);

$security_captcha = $security->addElement('image','captcha',array('src'=> $captcha->getImage(),
 																'alt'=>'Captcha Image'))->setLabel('Captcha:');

$security_text = $security->addElement('text', 'captcha_text', array('style' => 'width: 150px;'), array('label' => 'Answer:') );

//function callbacksecurity($arg)
//{
//	global $questions;
//	
//	global $position_question;
//	
//	return true;
//}											
/*
Rules
*/
function captcha_check($arg)
{
	global $captcha;
	return $captcha->checkCaptcha($arg);
	
}
$security_text->addRule('callback','Captcha Not Valid',"captcha_check");
$password_fs->addRule('eq', 'Passwords do not match', $password_fs_cfm);
//$password_fs_cfm->addRule('required', 'Password  required');
$password_fs ->addRule('required', 'Password  required');
$login_name_fs->addRule('required', 'Login  required');
$first_name_fs->addRule('required', 'First name required');
$last_name_fs->addRule('required','Last Name required');
$last_name_fs->addRule('regex', 'Username should contain only letters', '/^[a-zA-Z]+$/');
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

//$phone_number_fs->addRule('regex','Must be numeric', '/^\d+$/');

/**
 * 
 * The registrant followed the link in the registration process
 * 
 * 
 */
if(isset($_GET['code']))
{   
	
	$person_seq = $signup->confirm($_GET['code']);
	
	if($signup->isError())
	{ 
			$display = $reg_messages['confirm_error'];
			
			$Layout->isError = true;$Layout->errormessage = $signup->errormessage;
			
			$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>Error</a></li></ul></div>");
	
			$person_form->__toString();
			
			$Layout->addContent(ob_get_contents());
			
			ob_end_clean();
			
			echo $Layout;
			
			return;
	}
	
	$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>Success</a></li></ul></div>");
	
	$sql = "select * from persons where seqno ='$person_seq'";
	$res = $db->query($sql);
	if($res->isError()){ $Layout->errormessage = $db->errormessage;}
	else 
	{
		$row = $res->fetch();
		$title = $row['TITLE'];
		$first_name = $row['FIRST_NAME'];
		$last_name = $row['LAST_NAME'];
		$login_name = $row['LOGIN_NAME'];
	
		echo "<p>Thank you $title $first_name $last_name. Your account has now been confirmed.<br> ";
		echo "You can now login with your username: $login_name <br>";
		echo "To update your personal details, please go to the user tab.<br>";
		echo "The Biobank Team store securely your password, it is therefore impossible to retrieve it.<br>";
		echo "In case you forgot your password, please contact the  <a href='web@biolibd.mumm.ac.be'>webmaster</a> for a reset.<br>";
		echo "In the biobank tab, you are now able to order samples.<br>";
		echo "You may also download the result of your search in several formats.<br>";
		echo "In the user tab, you are now able to view the status of your orders";
			}
	
	//$display = $reg_messages['success'];
	
	//echo $display['content'];
	
	//$person_form->__toString();
	
	$Layout->addContent(ob_get_contents());ob_end_clean();
	
	echo $Layout;
	
	return;
}
/**
 * The form has not been validated, because some rules have been broken
 * 
 * 
 */
if(!$person_form->validate())
{

 	$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>First Step</a></li></ul></div>");
	
 	echo "<p>This section is dedicated to scientists working on research projects in which selected tissue samples are required.</p>";
 	echo "<p>To obtain a login, a short description of the objective of a project or research subject will be required, and an affiliation to a research institute or project.</p>";
 	echo "<p>A login is given upon a successful email confirmation, it is therefore important to enter your right email address</p>"; 
	echo "<p>Please enter required details (<span style='color:red;'>*</span>) in the form below:</p>";
	 
	$person_form->__toString();
	
	$Layout->addContent(ob_get_contents());
	
	ob_end_clean();

	echo $Layout;				
	
	return;
}

/**
 * The form has been validated
 * 
 * 
 */
$v =$person_form->getValue();

$submitVars = array('login'=>$v[$login_name],'password'=>$v[$password], // same order as in  the ini file
					'address'=>$v[$address],'phone_number'=>$v[$phone_number],'email'=>$v[$email],
					'first_name'=>$v[$first_name],'last_name'=>$v[$last_name],'title'=>$v[$title]);

$signup->createSignup($submitVars);


/**
 * The form has been submitted, a problem occured in the registration creation
 * 
 * 
 */

if($signup->isError())
{ 
	
	$display = $reg_messages['signup_error']; 

	$Layout->isError = true;$Layout->errormessage = $display['content'].$signup->errormessage;
	
	$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>Error</a></li></ul></div>");
	
	$person_form->__toString();
		
	$Layout->isError = true;$Layout->errormessage =$signup->errormessage;
			
	$Layout->addContent(ob_get_contents());
	
	ob_end_clean();
			
	echo $Layout;
	
	return;
}


$signup->sendConfirmation();

/**
 * The form has been submitted, however there is a problem with the mail
 * 
 * 
 */
if($signup->isError())
{ 
	$display = $reg_messages['email_error']; 
	
	$Layout->isError = true;$Layout->errormessage = $display['content'].$signup->errormessage;
	
	$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>Error</a></li></ul></div>");
	
	$person_form->__toString();
	
	$Layout->addContent(ob_get_contents());ob_end_clean();
	
	echo $Layout;
	
	return;
}

/**
 * The form has been submitted without errors, a message has been sent to the email address 
 * 
 */
$Layout->addNavigation("<div><ul><li class='isclicked'><a  href = '#Layout_content'>Final Step</a></li></ul></div>");
		
$display = $reg_messages['email_sent'];

echo $display['content'];


$Layout->addContent(ob_get_contents());

ob_end_clean();

echo $Layout;

return;

?>
