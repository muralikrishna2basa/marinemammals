<?php



require_once('../../directory.inc');

require_once(Classes."auth/Session_class.php");


$session = new Session();


if(isset($_POST['navigation']))
{
	$navigation = json_decode(stripcslashes($_POST['navigation']),true);
	
	if($session->get('navigation') == false)
	{
	$session->set('navigation',$navigation);
	return true;	
	}
	
	if(!array_key_exists(key($navigation),$session->get('navigation')))
	{
	$session->set('navigation',$session->get('navigation') + $navigation);
	return true;		
	}
	else 
	{
	$toset = $session->get('navigation'); $toset[key($navigation)] = current($navigation);	
	$session->set('navigation',$toset);
	return true;		
	}
	
}
return true;
?>