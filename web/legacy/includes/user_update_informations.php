<?php
/**
 *   Include File   
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:06/01/2010
 */
ob_start();

require_once(Classes."arch/Form_class.php");

$Layout->addHead(array('<script type="text/javascript" src="js/user_update_informations.js"></script>',
						'<script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"></script>'
						));

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'&& $Layout->getNavigation()=='#update_informations') // so that prior to an update, the form is not reloaded 
{
	$person = new Person($db,$auth->getSessionId(),false,true);
}
else 
{
	$person = new Person($db,$auth->getSessionId(),array('Seqno'=>$auth->getSessionId()),true);
}

$form = $person->getForm();

if($form != false){ $form->onlyupdate = true;}

echo "If you want to change your personal data's, please update them in the form below.<br>
	  For password modification, follow this <a id='link_update_password' href='#'>link</a> or click on the corresponding tab.";


$person->__toString();

if($person->isError)
{ 
	//$Layout->isError = true; 
	echo "<span>$person->errormessage</span>";
}
elseif(isset($_POST['submit']) && $form->validate())
{
	echo "<span class='successmessage'>The informations have been successfully updated</span>";
}



$tmp = ob_get_contents();ob_end_clean();
return $tmp;
?>