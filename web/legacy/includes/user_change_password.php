<?php
/**
 *   Include File   
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:06/01/2010
 */
ob_start();


$form = new Form('Password_form','POST');
		
$form->setAttribute('class','default_form');

$form->setAttribute('action',$_SERVER['PHP_SELF']);

$form_fs  = $form->addElement('fieldset')->setLabel('Update Password');  //FIELDSET

$password_old     = $form_fs->addElement('password', 'OLDPassword', array('style' => 'width: 100px;'), array('label' => 'Current password:') );

$password_new     = $form_fs->addElement('password', 'NEWPassword', array('style' => 'width: 100px;'), array('label' => 'New password:') );
		
$password_new_cfm = $form_fs->addElement('password', 'Password'.'_cfm', array('style' => 'width: 100px;'), array('label' => 'Confirm New password:') );
		
$password_new->addRule('eq', 'Passwords do not match', $password_new_cfm);
$password_new_cfm->addRule('required', 'Password  required');
$password_old ->addRule('required', 'Password  required');
$password_new ->addRule('required', 'Password  required');

$form->onlyupdate = true;

$pkelem = $form->addElement('text', 'pk', array('style' => 'display:none;'), array('label' => '') );

$pkelem->setAttribute('value','{'.'"Seqno":'.$auth->getSessionId().'}');

if(!$form->validate() || $form->getValue() == null)
{
	if( isset($_GET['pk']) && strlen($_GET['pk'])>0) {
				echo $form->__toString(false);}
	else {echo $form->__toString();}
					
}
elseif(isset($_POST['submit']) && $_POST['submit'] == 'Update' && isset($_POST['pk']) && strlen($_POST['pk'])>0)
		{
			$attributes = $form->getValue();
			
			$pass = $auth->getPassword();
			
			if(md5($attributes['OLDPassword'])!=$pass)
			{
			 // $Layout->isError = true;
			 echo "<span class='errormessage'>Old Password do not match password saved in database</span>";
			}
			else 
			{
			  	$res = $auth->setPassword($attributes['NEWPassword']);
			  	if($res!=true)
			  	{
			  	//	$Layout->isError = true;
			 		echo "<span class='errormessage'>$auth->errormessag</span>";
				}
				else 
				{
					echo "<span class='successmessage'>Password successfully updated</span>";
				}
			  	
			}
		 echo $form->__toString();
			// check that old password match the md5 encryption of the one stored in the person table
		}	


$tmp = ob_get_contents();ob_end_clean();
return $tmp;
?>