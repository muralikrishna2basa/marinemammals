<?php
/**
 *   Include File
 *   Deny Order Admin Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/deny_order.css" />',
					  '<script type="text/javascript" src="/legacy/js/deny_order.js"></script>'));

if(isset($_POST['deny_order']) & isset($_POST['rln_seqno']) )
{

$pk = $_POST['rln_seqno']; 
$r = json_decode($pk); 
$rln_seqno = $r->Seqno;

$auth = $Layout->getAuth();	

$db = $Layout->getDatabase();

$person_seqno = $auth->getSessionId();

$order = New Order($db,$rln_seqno);

$order->DenyOrder($person_seqno);

if($order->isError == true) { $Layout->isError = true; $Layout->errormessage = $order->errormessage; }

if($Layout->isError == false)
{
		echo "The order has been successfully denied<br>
	      <form><button type='submit' class='to_order'>Go Back</button></form>";
}
}
else 
{
	$server = $_SERVER['PHP_SELF'];

	$deny_order  =  "<p>To deny the order, please press the button deny</p>";
	$deny_order .= "<form action = '$server' method = 'POST' >";
	$deny_order .= "<input type='text' style='display:none;' value ='true' name='deny_order'></input><div>";
	$deny_order .= "<button type='submit'   class='deny_order'>Deny</button>";
	$deny_order .= "<button type='button'   class='cancel_deny'>Cancel</button></div></form>";
	echo $deny_order;
}
?>



<?php
$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>