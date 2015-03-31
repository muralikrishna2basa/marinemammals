<?php

/**
 * 	Class Signup  v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */

class Signup 
{
	/**
	 * Database instance
	 *
	 * @var Oracle
	 */
	protected $db;
	
	/**
  	* contains the binding parameter of  the signup table in an array
  	*
  	* @var unknown_type
  	*/
 	protected $signupbinds;
 	
 	protected $userbinds;
	/**
	 * name and address used in the confirmation email
	 *
	 * @var array
	 */
	protected $from;
	/**
	 * Contain the name and address the email is sent to 
	 *
	 * @var array
	 */
	private $to;
	
	/**
	 * Email subject 
	 *
	 * @var string
	 */
	
	protected $subject;
	
	/**
	 * Email body 
	 *
	 * @var unknown_type
	 */
	protected $message;
	
	/**
	 * Configuration 
	 *
	 * @var array
	 */
	protected $cfg;
	
	/**
	 * whether or not the message is in html 
	 *
	 * @var bool
	 */
	protected $html;
	/**
	 * contain the url listed as the email confirmation link
	 *
	 * @var unknown_type
	 */
	protected $listener;
	/**
	 * Unique code needed to confirm the user registration 
	 *
	 * @var string
	 */
	private $confirmCode;
	
	protected $isError = false;
	
	public $errormessage;
	
	public function isError(){ return $this->isError;}
	public function errormessage(){ return $this->errormessage;}
	
	

	
	public function __construct(ORACLE $db, $listener, $frmName,$frmAddress,$subj,$msg,$html)
	{   
		
		$this->db = $db;
		$this->listener = $listener;
		/*
		a configuration file is set up to avoid modifying the class when the api rendering is modified
		*/
		$this->cfg = parse_ini_file('../ini/access_control.ini',true); 
		$this->from[$frmName] = $frmAddress;
	    $this->subject = $subj;
	    $this->message = $msg;
	    $this->html = $html;
	    $this->initBindings();
		
	}
	
	private function initBindings() {
  		$sign = $this->cfg['signup_vars'];
  	
  		foreach($sign as $bind_sign){
  		$this->signupbinds[] = ":$bind_sign";
  		}
  		
  		$usr = $this->cfg['users_table'];
  		foreach($usr as $key => $bind_sign){
  		if($key!='table'& $key !='seqno') {	
  		$this->userbinds[] = ":$bind_sign";}
  		}
  		
  	
  	}
	/**
	 * Create the surely unique registration code
	 *
	 * @param string $login
	 */
	private function createCode($login)
	{
		srand((double)microtime()*1000000); // initialize the random engine creator
		$this->confirmCode = md5($login.time().rand(1,1000000));
	
	}
	
	public function createSignup($userdetails)
	{
		
		$db = $this->db;
		// user detail is an array containing as key the login form elements [ array(login => 'clifton',password =>'AUNTNX')]
		// check that user is not already signed up 
		$usertable = $this->cfg['users_table'];
		$usersignup = $this->cfg['signup_vars'];
		$signuptable = $this->cfg['signup_table'];
		
		$bindlogin = ":".$usertable['login'];
		$bindmail = ":".$usertable['email'];
		
		$sql = "select count(*) as num_row from ".$usertable['table']." where ".$usertable['login']." =$bindlogin OR ".
																				$usertable['email']." =$bindmail";
		$binds = array($bindlogin=>$userdetails['login'],$bindmail=>$userdetails['email']);																		
																				
		$r = $db->query($sql,$binds)->fetch();

		if($db->isError()){ 
			$this->isError = true;$this->errormessage = "database problem"; return false;}
	
		if($r['NUM_ROW'] != 0)
		{    
			$this->isError = true;
		    $this->errormessage  = "Already registered";
			return false; 
	    }
	    
	    $this->createCode($userdetails['login']); // create code
	    $to_name = $userdetails['first_name'].' '.$userdetails['last_name'];
	    $this->to[$to_name] = $userdetails['email'];
	    
	    
	    // insert registration form into the signup table 
	    $usersignuptable = $signuptable['table'];

	    $usersignupvar = array_diff_key($signuptable,array_flip(array('table','seqno'))); // remove the table definition,etc
	    
	    $sql = "insert into ". $usersignuptable."(".implode(',',$usersignupvar).") values (".implode(',',$this->signupbinds).",:confirm,:time)";
		
	    $binds = array_combine($this->signupbinds,$userdetails);
	    
	    $binds[':time'] = time();
	    $binds[':confirm'] = $this->confirmCode;
	    
	    $db->query($sql,$binds);
	    
	    if($db->isError()) { $this->isError = true; $this->errormessage = $this->db->errormessage; return false;}

	    return true;
	}
	
	public function sendConfirmation()
	{
		
		$db = $this->db;
		$fromName = $this->from[key($this->from)];
		
		$headers = "From: $fromName" . "\n" .
				   "Subject: $this->subject"."\n".	
   				    'Reply-To: webmaster@mumm.ac.be' . "\n" .
   				 	'X-Mailer: PHP/' . phpversion(). "\n" .
    				'MIME-Version:1.0'."\n".
   					'Content-Transfer-Encoding:7bit'."\n".
   					'Content-Type:text/html; charset=iso-8859-1'."\n";
	
		
		if($this->html)
		{
			$replace = "<a href =$this->listener?code=$this->confirmCode >$this->listener?code=$this->confirmCode</a>";
		}
		else 
		{
			$replace = "$this->listener?code=$this->confirmCode";
		}
		
		$this->message = str_replace('<confirm_url/>',$replace,$this->message);
		
		$to = current($this->to);
		
		$success = mail($to, $this->subject, $this->message, $headers);
		if(!$success) {$this->isError = true;$this->errormessage = "Mail not successfully sended";}
	}
	
	public function confirm($confirmCode)
	{
		
		$db = $this->db;
		$usertable = $this->cfg['users_table'];
		
		$usersignup = $this->cfg['signup_vars'];
		
		$signuptable = $this->cfg['signup_table'];
		
		$signup_confirm = $signuptable['confirm_code'];
		
		$sql = "select * from ".$signuptable['table']." where $signup_confirm = :confirmCode";
		
		$bind = array(':confirmCode'=>$confirmCode);
		
		$results = $db->query($sql,$bind);
	 	
		if($db->isError()) { $this->isError = true; $this->errormessage = "confirmation problem"; return false;}
		
		$r = $results->fetch();
		
		if($r == false)
		{
			$this->isError = true;$this->errormessage = "The confirmation code isn't correct";return false;
		}
		
		if($results->fetch()){
			// meaning that there is more than exactely one record
			$this->isError = true; $this->errormessage = "Either the confirmation code is wrong, or there is a serious problem";
			return false;
		}
		
		
	    $uservar = array_diff_key($usertable,array_flip(array('table','seqno'))); // remove the table definition,etc
		$sql = "insert into " .$usertable['table']. " ( ".implode(',',$uservar).") values (".implode(',',$this->userbinds).")";
		
		
		$binds = array_combine($this->userbinds,array($r[strtoupper($signuptable['login'])],
														md5($r[strtoupper($signuptable['password'])]),
														$r[strtoupper($signuptable['address'])],
														$r[strtoupper($signuptable['phone_number'])],
														$r[strtoupper($signuptable['email'])],
														$r[strtoupper($signuptable['first_name'])],
														$r[strtoupper($signuptable['last_name'])],
														$r[strtoupper($signuptable['title'])]));
		
	
		$db->query($sql,$binds);
		
		if($db->isError()){$this->isError = true;$this->errormessage= $db->errormessage();return false;}
		
		
		// delete row from sign-up table
		
		$sql = "delete from ".$signuptable['table']." where SEQNO = :SEQNO";
		$bind = array(':SEQNO'=>$r[strtoupper($signuptable['seqno'])]);
		$db->query($sql,$bind);
		
		if($db->isError()){$this->isError = true;$this->errormessage = $db->errormessage();return false;}

			// get the identifier
		$sql = "select CC_NEXT_VALUE - CC_INCREMENT AS SEQ FROM CG_CODE_CONTROLS WHERE CC_DOMAIN = 'PSN_SEQ'";
		$res = $db->query($sql);
		if($db->isError()){$this->isError = true;$this->errormessage= $db->errormessage();return false;}
		$row = $res->fetch();
		
		return $row['SEQ'];
	
	}
	
}


?>