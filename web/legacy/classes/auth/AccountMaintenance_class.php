<?php
/**
 * Recovery password tool 
 * Two step recovery 
 * 
 * First given the email address, the tool check for correspondance in database 
 * then, it send details ( user login to the corresponding address)
 * it provides a link that will redirect the user on a page 
 * that will let the user know that his password has been resetted and that he must check 
 * his mailbox to get the new ( and temporary) password.
 * 
 * When login for the first time with this temporary password, it could be useful to directly redirect the user on the 
 * password change tool
 *
 */
class AccountMaintenance
{
	protected $db;
	
	protected $auth;
	
	public $isError = false;
		
	protected $listener;
	
	public $errormessage;
	
	
	public function __construct(ORACLE $db,Auth $auth)
	{
		if($db instanceof ORACLE){ $this->db = $db;}
		
		if($auth instanceof Auth) { $this->auth = $auth;}
			
		$this->listener = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

	}
	/**
	 * Check the email send by the user
	 * In case the mail got a database correspondance => create unique identifier and append it to the user. 
	 */
	public function checkEmailUser($email)
	{
		// check Email 
		$sql = "select seqno, email,last_name,first_name,login_name, count(*) as num_user from persons where email = :email
				group by seqno, email,last_name,first_name, login_name";
		$bind = array(':email'=>$email);
		$res = $this->db->query($sql,$bind);
		if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage;return false;}
		$row = $res->fetch();
		if($row['NUM_USER'] != '1'){ $this->isError = true;$this->errormessage = "Email not found";return false;}
		
		// Email Checked
		// get user seqno
		$uniqueID = $this->getUniqueID();
		
		$login = $row['LOGIN_NAME'];
		
		$sql = "insert into account_maintenance(psn_seqno,email,ID) values (:psn_seqno,:email,:id)";
		$binds = array(':psn_seqno'=>$row['SEQNO'],':email'=>$row['EMAIL'],':id'=>$uniqueID);
		
		$this->db->query($sql,$binds);
		if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage;return false;}
		
		//send Email notification 
		
		$clicked_ref =  "<a  href ='$this->listener?code=$uniqueID'>link</a>";
		
		$msg = <<<EOD
<p>Dear User</p><br>
<p> The Account Maintenance tool has been sollicitated for your account</p><br>
<p> If you are not the author of this sollicitation, this means that someone is trying to access your account</p><br>
<p> In that case, i suggest you to contact the webmaster of the <a href='www.marinemammals.be'>Marine Mammal</a> website</p>
<p> Your login is $login</p>
<p> Clicking on this $clicked_ref will reset your password.
EOD;
		$subject = "Password Retrieval tool";
		$this->sendUserEmail($email,$subject,$msg);
	}
	
	protected function getUniqueID()
	{
		$code = $this->getCode();
		
		$salt  = "flower";
		
		return md5($salt.$code);
	}
	protected function getCode()
	{
		$length = mt_rand(3,10);
		
		$alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
		
		$string = "";
		
		for($i = 0;$i<$length;++$i)
		{
			$string .=$alphabet[mt_rand(0,strlen($alphabet)-1)];
		}
	
		return $string;
		
	}	
	public function resetPassword($code)
	{
		$db = $this->db;
		// check code
		$sql = "select seqno, psn_seqno, count(*) as num_code from account_maintenance where id = :code group by seqno,psn_seqno";
		$bind = array(":code"=>$code);
		
		$res = $db->query($sql,$bind);
		
		if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage;return false;}
		
		$row = $res->fetch();
		
		if($row['NUM_CODE'] != '1') { $this->isError = true;$this->errormessage = "not a valid code";return false;}
		
		// valid code, set password
		date_default_timezone_set('Europe/Paris');

		$year = idate('Y');
		
		$account_maintenance_seqno = $row['SEQNO'];
		
		$pass = $this->getCode()."?$year";
		
		$newpassword = md5($pass);
		
		$sql = "update persons set password = :newpassword where seqno = :seqno";
		
		$binds = array(':newpassword'=>$newpassword,':seqno'=>$row['PSN_SEQNO']);
		
		$res = $db->query($sql,$binds);
		
		if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage;return false;}
		
		// get user detail
		$sql = "select * from persons where seqno = :seqno";
		$bind = array(':seqno'=>$row['PSN_SEQNO']);
		$res = $db->query($sql,$bind);
		
		if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage;return false;}

		$row = $res->fetch();
		
		$login = $row['LOGIN_NAME'];
		// send the user a message that contain the newpassword, prompt him to change it 
		
		$msg = <<<EOD
<p>Dear $login</p>
<p> You have successfully updated your password </p>
<p>Your new password is $pass</p>
<p>You can change it by going in the User tab after login</p>		
EOD;
		$email = $row['EMAIL'];
		
		$subject = "Successful Password Reset";
		
		$this->sendUserEmail($email,$subject,$msg);
		
		// delete entry in database
		
		$sql = "delete from account_maintenance where seqno = :seqno";
		$bind = array(':seqno'=>$account_maintenance_seqno);
		
		$db->query($sql,$bind);
		if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage;return false;}
	
		
		// automatic sign-in 
		
	//	$_POST['login'] = $login; 
	//	$_POST['password'] = $pass;
	//	$this->auth->login('User.php');
		
		return true;
		
	}
	protected function sendUserEmail($email,$subject,$msg)
	{
		$frmName = 'De Winter';

		$frmAddress = 'johan.dewinter@mumm.ac.be';
		
		$headers = "From: $frmAddress" . "\n" .
				   "Subject: $subject"."\n".	
   				    "Reply-To: $frmAddress" . "\n" .
   				 	'X-Mailer: PHP/' . phpversion(). "\n" .
    				'MIME-Version:1.0'."\n".
   					'Content-Transfer-Encoding:7bit'."\n".
   					'Content-Type:text/html; charset=iso-8859-1'."\n";
   					
   		mail($email, $subject, $msg, $headers);	
		
	}
	protected function clearIdentifier()
	{}
	
	
	
	
}

?>