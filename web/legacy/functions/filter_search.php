<?php
/**
 *  Function : 
 *  
 *  input  =  get items 
 *  output =  array of items in json format 
 */

$filtername = false;
$searcher = false;

if($_POST['filter']){ $filtername = $_POST['filter'];} 
if($_POST['searcher']){$searcher = $_POST['searcher'];}

require_once('../../directory.inc');

include_once(Functions.'getAuthDb.php');
	
include_once(Classes."search/searcher_class.php");

if(!$searcher){return;} // 

$grouplevel = $auth->getSessionGrouplevel();

$samples = new $searcher($db,$grouplevel);
 
if($filtername == 'null' || !$filtername ) // starting point 
{ 
  $filters = $samples->getFiltersname();

  $db->close(); // close the ressource

  echo json_encode(array('filters'=>$filters));
  return;
}
else 
{

  $tokens = $samples->getTokens($filtername);

  $domain = $samples->getDomain($filtername);

  
//  for($i = 0;$i<count($domain);$i++)
//  {
//  	$res = mb_detect_encoding($domain[$i]);
//  	$domain[$i] = $res==false?'problem':$res;
//  }
  $db->close(); // close the ressource	
  
  if($domain !=null) { $domain = fixEncoding($domain);}
  
  echo json_encode(array('tokens'=>$tokens,'domain'=>$domain));
  
  return;
}






?>