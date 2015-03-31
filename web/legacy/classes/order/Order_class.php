<?php
/**
 * 	Class Order v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 *  
 *  Details:
 * ---------
 * 
 * Helper for processing orders 
 * if a valid order is set at construction time, 
 * then all related infos of the order are created in their respective attributes
 *
 */  
require_once(Functions.'Fixcoding.php');

class Order 
{
	/**
	 *  Array of order elements
	 */
	private $orders = array();
	/**
	 * Array of samples ( identification numbers)
	 * array(1,2,3,24,43)
	 * @var array
	 */
	private $samples = array();
	
	
	/**
	 * Identification of the last request made
	 *
	 * @var integer
	 */
	private $rln_seqno = null;
	
	/**
	 * 	Database ressource
	 *
	 * @var ORACLE
	 */
	private $db;
	
	/**
	 * Array of persons( identification numbers) ordering the samples
	 * keyed with their respective types ( researcher, responsible) 
	 * @var array
	 */
	private $persons = array();
	
	/**
	 * Return possible errors
	 *
	 * @var Bool
	 */
	public $isError = false;
	
	public $errormessage;
	
	/** name and address used in the confirmation email
	 *
	 * @var array
	 */
	protected $from;
	
	/**
	 * Variables caracterizing the order
	 *
	 * @var array
	 */

	protected $request_loan;
		
	public function __construct(ORACLE $db,$rln_seqno = null,$frmName='De Winter',$frmAddress ='johan.dewinter@mumm.ac.be')
	{	
		date_default_timezone_set('Europe/Brussels');
		
		$this->db = $db;
		
		$this->from[$frmName] = $frmAddress;
		
		if($rln_seqno != null)
		{
		$sql = "select count(*) as num_rows from request_loans where seqno = :rln_seqno";
		$bind = array(':rln_seqno'=>$rln_seqno);
		$r = $this->db->query($sql,$bind)->fetch();	
	
		if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}
	
		if($r['NUM_ROWS'] == 0){ $this->isError = true;$this->errormessage = "not a valid order";return false;}
		/* set request_loan seqno*/
		$this->rln_seqno = $rln_seqno;
		
		$sql = "select spe_seqno from sample2requests where rln_seqno = $rln_seqno"; 
		
		$samples = $db->query($sql);
		
		if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage(); return false;}
		
		while($r = $samples->fetch())
		{
			$this->samples[] = $r['SPE_SEQNO'];
			
		}
		
			if(count($this->samples) == 0) 
			{ $this->isError = true;$this->errormessage = " no samples associated with the request"; return false;}
		
		$sql = "select psn_seqno,p2r_type from person2requests where rln_seqno = $rln_seqno";	
		
		$persons = $db->query($sql);
		
		if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage(); return false;}
		
		while($r = $persons->fetch())
		{
			$this->persons[$r['PSN_SEQNO']] = $r['P2R_TYPE'];
			
		}
		
		$sql = "select * from request_loans where seqno = $rln_seqno";
		
		$row = $db->query($sql)->fetch();
		
		if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage(); return false;}
		
		$this->request_loan = $row;
		
		return true;
			
		}
	 
		
	}
	
	public function getPersons() { return $this->persons;}
	
	public function getSamples() { return $this->samples;}
	

	
	protected function setPersons($persons,$check)
	{	
		if($check == true) 
		{
		foreach($persons as $key=>$value)
		{
		$sql = "select count(*) as num_rows from persons where seqno = :seqno";
		$bind = array(':seqno'=>$key);
		$r = $this->db->query($sql,$bind)->fetch();
		if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}
		if($r['NUM_ROWS'] != 1){ $this->isError = true;$this->errormessage = "not a valid person : $key ";return false; }	
		}
		
		}
		$this->persons += $persons ; // array union operator 
		return true;
	}
	
	protected function setSamples($samples,$check)
	{	
		if($check == true) 
		{
		foreach($samples as $sample)
		{
		$sql = "select count(*) as num_rows from samples where seqno = :seqno";
		$bind = array(':seqno'=>$sample);
		$r = $this->db->query($sql,$bind)->fetch();
		if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}
		if($r['NUM_ROWS'] != 1){ $this->isError = true;$this->errormessage = "not a valid sample : $sample";return false; }	
		}
		
		}
		$this->samples += $samples ; // array union operator 
		return true;
	}
	
	/**
	 * Create a specific order 
	 * i.e insert into tables (samples2requests, request_loans,person2requests) and other necessary items
	 * @return bool true => order created successfuly, false => order creation failed 
	 *
	 */
	public function CreateOrder($study_description,$samples,$persons,$check)
	{
    	
	$person = each($persons);$person = key($person);
	reset($persons);
	/* Instantiate samples and persons, perform an additional check if $check is set to true*/	

	if(!$this->setPersons($persons,$check)){ return false;}
	if(!$this->setSamples($samples,$check)){ return false;}
	
		
	date_default_timezone_set('Europe/Brussels');
	$db = $this->db;
	$date = date("d M Y");	
	
	// sanitary checks 

	if(!is_array($this->persons) || count($this->persons) <= 0)
	{
		$this->isError = true;
		$this->errormessage = 'A person must at least order';
	}
	
	if(!is_array($this->samples) || count($this->samples) <= 0 )
	{
		$this->isError = true;
		$this->errormessage = 'At least one samples must be ordered';
	}
	
	if(!$this->CheckAuth($person,'USER')){ $this->isError = true;$this->errormessage =" not autorized to create order";return false;}
	
	
	// insert Request	
	$sql = "insert into REQUEST_LOANS (status,date_request,study_description) values
	(0,to_date(:date_r,'DD Mon YYYY'),:study)";
	
	$binds = array(':date_r'=>$date,':study'=>$study_description);
	
	$db->query($sql,$binds);
	
	if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage(); return false;}
	
	// get last request 
	
	$sql = " select seqno as SEQNO from REQUEST_LOANS where SEQNO = 
	         (select CC_NEXT_VALUE from CG_CODE_CONTROLS where CC_DOMAIN = 'RLN_SEQ')-1";
	
	$r = $db->query($sql)->fetch();
	
	if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage(); return false;}
	
	if(!isset($r['SEQNO']) || $r['SEQNO'] == null )
	{$this->isError = true;$this->errormessage = 'not a valid seqno';return false;}
	
	$rln_seqno = $r['SEQNO'];
	
	$this->rln_seqno =  $rln_seqno;
	
	foreach($this->samples as $sample)
	{
	$sql = "insert into SAMPLE2REQUESTS (rln_seqno,spe_seqno) values( :rln_seqno,:sample)";
	$bind = array(':rln_seqno'=>$rln_seqno,':sample'=>$sample);
	$db->query($sql,$bind);
	
	if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage(); return false;}
	
	}
	// insert persons concerned by the request 
	foreach($this->persons as $person =>$type)
	{
	$sql = "insert into PERSON2REQUESTS (psn_seqno, rln_seqno,p2r_type) values (:person,:rln_seqno,:p2r_type)";
	$bind = array(':person'=>$person,':rln_seqno'=>$rln_seqno,':p2r_type'=>$type);
	
	$db->query($sql,$bind);
	
	if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage(); return false;}
	
	}
/**
 *  To be modifed, customize the notification message
 */
	if(!$this->SendConfirmation()){ return false;}
	
	return true; 
	
	}
	/**
	 * Send message to all users belonging to the admin group
	 *
	 * @param string $subject
	 * @param string $msg
	 */
	protected function SendAdminMessage($subject = 'Request Order Confirmation',$msg = null)
	{
		if($msg == null)
		{
		$msg = <<<EOD
		<p>Your request has been successfully entered</p> <br>
		<p> The team in charge, will process your demand as soon as possible</p> <br>
		<p> Thank you,</p>
EOD;
		}
		$db = $this->db;
		
		$rln_seqno = $this->rln_seqno;
		
		// get all persons email belonging to the admin group, and send them a message
		$sql = "select a.email as email from (persons) a, (person2groups) b, (groups c) where 
				a.seqno = b.psn_seqno and b.grp_name = c.name and name = 'ADMIN'";
		
		$emails = $this->db->query($sql);
		
		if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage(); return false;}
		
		$fromName = $this->from[key($this->from)];
		
		$headers = "From: $fromName" . "\n" .
				   "Subject: $subject"."\n".	
   				    'Reply-To: webmaster@mumm.ac.be' . "\n" .
   				 	'X-Mailer: PHP/' . phpversion(). "\n" .
    				'MIME-Version:1.0'."\n".
   					'Content-Transfer-Encoding:7bit'."\n".
   					'Content-Type:text/html; charset=iso-8859-1'."\n";
	
		
		while($email = $emails->fetch())
		{	
			mail($email['EMAIL'], $subject, $msg, $headers);	
		}			
	}
	
	protected function SendUserConfirmation($subject,$msg = null)
	{
		if($msg == null)
		{
		$msg = <<<EOD
		<p>Your request has been successfully entered</p> <br>
		<p> The team in charge, will process your demand as soon as possible</p> <br>
		<p> Thank you,</p>
EOD;
		}
		$db = $this->db;
		
		$fromName = $this->from[key($this->from)];
		
		$headers = "From: $fromName" . "\n" .
				   "Subject: $subject"."\n".	
   				    'Reply-To: webmaster@mumm.ac.be' . "\n" .
   				 	'X-Mailer: PHP/' . phpversion(). "\n" .
    				'MIME-Version:1.0'."\n".
   					'Content-Transfer-Encoding:7bit'."\n".
   					'Content-Type:text/html; charset=iso-8859-1'."\n";
   					
   		foreach($this->persons as $key=>$value)
		{
			$sql = "select email from persons where seqno = :seqno";
			$bind = array(':seqno'=>$key);
			$r = $db->query($sql,$bind)->fetch();	
			if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage(); return false;}
			
			if(!isset($r['EMAIL'])) 
			{ $this->isError = true;$this->errormessage ="not valid email addresses"; return false;}
			
			mail($r['EMAIL'],$subject,$msg,$headers);
			
		}			
		
	}
	/**
	 * Send email notification, so that the group of autorized peoples receive an informative mail 
	 * specifying that a new order has been made
	 * Send also a message to all peoples having order the samples, that their request have been taken 
	 * into account and that it will be processed as soon as possible
	 */
	public function SendConfirmation($subject="Request Order Confirmation",$msg=null)
	{
	$db = $this->db;
	$user_order = "";	
	foreach($this->persons as $key=>$value)
	{
		$sql = "select * from persons where seqno = :seqno";
		$bind = array(':seqno'=>$key);
		$r = $db->query($sql,$bind)->fetch();	
		
		if($db->isError()){ $this->isError = true;$this->errormessage = $db->errormessage(); return false;}
			
		if(isset($r['EMAIL']) && isset($r['FIRST_NAME']) && isset($r['LAST_NAME']) && isset($r['PHONE_NUMBER']))
		{
			$user_order .= "Last Name: ".$r['LAST_NAME'].". First Name: ".$r['FIRST_NAME'].". Tel: ".$r['PHONE_NUMBER'].". Email: ".$r['EMAIL'].".<br>";
		} 

		
	}
	$admin_msg = <<<EOD
		<p>Dear Admin User</p> <br>
		<p> A request has been successfully entered</p> <br>
		<p> Please contact the following person(s),</p><br>
		<p> $user_order </p><br>
	    <p> Please login to the web-application for more details.
EOD;
		
	$this->SendAdminMessage($subject,$admin_msg);
	
	
	$this->SendUserConfirmation($subject,$msg);
		
	}

	
	/**
	 * Complete the order tables, set the corresponding samples to unavailable,
	 * set a notification mail to the user, for him to be aware that the samples are rented
	 * this method can only be called when an admin has instantiated the class specifying the order 
	 * as input
	 */
	public function ConfirmOrder($date_rt,$date_out,$person,$sendmessage = false,$msg = null,$subject ="Request Confirmed")
	{
	// date format in,out '31 jul 2009'	
		
	
	$rln_seqno = $this->rln_seqno;

	if($rln_seqno == null) { $this->isError = true;$this->errormessage = "A valid order has not been set";return false;}
	
	if(count($this->samples) == 0) { $this->isError = true;$this->errormessage = " no samples to confirm"; return false;}
	
	// person is the guy that will confirm the order -- must be part of the admin group
	
	if(!$this->CheckAuth($person,'ADMIN')){ $this->isError = true;$this->errormessage =" not autorized to confirm order";return false;}
	
	// set the date of return and date out
	$sql = "update request_loans set date_rt = to_date(:date_rt),
                          date_out = to_date(:date_out),
                          status    = '1'
                			where seqno = :rln_seqno";

	$bind = array(':date_rt'=>$date_rt,':date_out'=>$date_out,':rln_seqno'=>$rln_seqno);

	$this->db->query($sql,$bind);
	
	if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}

	// set the availability of samples to no 
	$samples = implode(',',$this->samples);
	$sql = "update samples set availability = 'no' where seqno in ($samples)";
	
	$this->db->query($sql);
	
	if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}
	
	if($msg == null) {
	$msg = <<<EOD
		<p>Request Confirmed</p> <br>
		<p> Your demand has been approved by the team in charge</p> <br>
		<p> Thank you,</p>
EOD;
	}
	
	if($sendmessage == true) {$this->SendConfirmation($subject,$msg); }
	}
	/**
	 * Enumerate the orders made by the user ( for each order, the number of samples is supplied)
	 *
	 */
	public function ViewOrdersbyPerson($person)
	{

	// sanitary check 
	
	$sql = "select count(*) as num_rows from persons where seqno = :seqno";
	
	$bind = array(':seqno'=>$person);
	
	$r = $this->db->query($sql,$bind)->fetch();
	
	if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}
	if($r['NUM_ROWS'] !=1){$this->isError = true;$this->errormessage = "Not a valid user";return false;}
	
	$sql = "select rln_seqno from person2requests where psn_seqno = $person";
	
	$requests = $this->db->query($sql);
	if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}
	

	while ($request = $requests->fetch()) {
		
		$rln_seqno = $request['RLN_SEQNO'];
		$this->orders[] = new Order($this->db,key($this->from),current($this->from),$rln_seqno);		
	}
	
	
	return $this->orders;
	
	}
	

	protected function CheckAuth($person,$group)
	{
			
	$sql = "select count(*) as num_rows from (persons) a, (person2groups) b, (groups c) where 
				a.seqno = b.psn_seqno and b.grp_name = c.name and name = :groupname and a.seqno = :person" ;
	
	$bind = array(':person'=>$person,':groupname'=>$group);
	
	$r = $this->db->query($sql,$bind)->fetch();
  	if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}
	if($r['NUM_ROWS'] == 0)
	{ $this->isError = true;$this->errormessage = "User not belonging to group $group";return false;}

	return true;	
		
	}
	
	
	
	/**
	 * Delete order from list, send the user a message specifying the reason of this "veto"
	 *
	 */
	public function DenyOrder($person,$sendmessage = false,$msg = null,$subject =" Delete order")
	{
	/* Check the user existence and permission level, check the request */ 
	

	$rln_seqno = $this->rln_seqno;

	// IN case no rln_seqno has been provided at class instantiation
	if($rln_seqno == null) 
	{ $this->isError = true;$this->errormessage = "A valid order has not been set";return false;}
	
	if(count($this->samples) == 0) 
	{ $this->isError = true;$this->errormessage = " no samples to confirm"; return false;}
	
	// person is the guy that will deny the order -- must be part of the admin group
	
	if(!$this->CheckAuth($person,'ADMIN'))
	{ $this->isError = true;$this->errormessage =" not authorized to deny order";return false;}
			
	
	$sql = "delete from person2requests where rln_seqno = :rln_seqno";
	
	$bind = array(':rln_seqno'=>$rln_seqno);
	$this->db->query($sql,$bind);
	if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}

	$sql = "delete from sample2requests where rln_seqno = :rln_seqno";
	
	$bind = array(':rln_seqno'=>$rln_seqno);
	$this->db->query($sql,$bind);
	if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}

	$sql = "delete from request_loans where seqno = :rln_seqno";
	
	$this->db->query($sql,$bind);
	if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}

	if($msg == null) {
	
	$msg = <<<EOD
		<p>Request Denied</p> <br>
		<p>  The team in charge has denied your request </p> <br>
		<p> Thank you,</p>
EOD;
	}
	// send confirmation to the peoples doing the request and to the admin group
	if($sendmessage == true ) {$this->SendConfirmation($subject,$msg);}
	
	}
	


public function __destruct(){$this->db->close();}	
	
}

?>