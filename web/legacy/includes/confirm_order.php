<?php
/**
 *   Include File
 *   Confirm Order Admin Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();
$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="css/confirm_order.css" />',
					  '<script type="text/javascript" src="js/confirm_order.js"></script>'));

/* confirm order */

if(isset($_POST['confirm_order']))
{
	
if(isset($_POST['Rent_date'])) { $Rent_date = $_POST['Rent_date'];}
if(isset($_POST['Return_date'])) { $Return_date = $_POST['Return_date'];}
if(isset($_POST['rln_seqno'])) 
{ 
	$pk = $_POST['rln_seqno']; 
	$r = json_decode($pk); 
	$rln_seqno = $r->Seqno;
}
if(isset($_POST['confirmation_mail'])) { $confirmation_mail = $_POST['confirmation_mail'];}


$person_seqno = $auth->getSessionId();

if(isset($Rent_date) & isset($Return_date) & isset($rln_seqno) )
{
	$order = New Order($db,$rln_seqno);
	if($order->isError) { $Layout->isError = true; $Layout->errormessage = $order->errormessage; }
	if(isset($confirmation_mail) && $confirmation_mail =="on")
	{
		$order->ConfirmOrder($Return_date,$Rent_date,$person_seqno,true);
	}
	else 
	{
		$order->ConfirmOrder($Return_date,$Rent_date,$person_seqno);
	}
	
	
	if($order->isError) { $Layout->isError = true; $Layout->errormessage = $order->errormessage; }

	
}
// In case everything goes fine
if($Layout->isError == false)
{
	echo "The order has been successfully confirmed<br>
	      <form><button type='submit' class='to_order'>Go Back</button></form>";
}

}
else 
{
$server = $_SERVER['PHP_SELF'];

$confirm_order =  "<p>To successfully confirm the order, please fill-in the supposed date of return, as well as the rent date</p>";
$confirm_order .= "<form action = '$server' method = 'POST' >";
$confirm_order .= "<input type='text' style='display:none;' value ='true' name='confirm_order'></input>";
$confirm_order .= "<div class = 'div_confirm_order'>";
$confirm_order .= "<div><label>Return date</label><input class ='return_date' name ='Return date'></input></div>";
$confirm_order .= "<div><label>Rent date</label><input class ='rent_date' name ='Rent date'></input></div>";
$confirm_order .= "<div><label>Confirmation mail</label><input class ='confirmation_mail' name ='confirmation_mail' type='checkbox'></input></div>";
$confirm_order .= "<div><button type='submit'   class='confirm_order'>Confirm</button><button type='button'   class='cancel_deny'>Cancel</button></div>";
$confirm_order .= "</div></form>";
echo $confirm_order;
}
?>



<?php
$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>
