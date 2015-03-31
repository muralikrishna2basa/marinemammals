<?php
//
//require_once('../../classes/db/Oracle_class.php');
//
//$db = new ORACLE('BIOLIB_OWNER','BIOLIB123','BIOLIBD.mumm.ac.be');
//
//$toupdate = "select * from organ_lesions where lte_ogn_code = 'ROOT'";
//
//$res = $db->query($toupdate);




// create first a list of identical items in organ_lesions but pointing on whole body instead
//while($row = $res->fetch())
//{
//	$description = $row['DESCRIPTION'];
//	$ncy_ese =  $row['NCY_ESE_SEQNO'];
//	
//	$sql = "insert into organ_lesions(DESCRIPTION,LTE_OGN_CODE,LTE_SEQNO,NCY_ESE_SEQNO) values ('$description','WBY',160,$ncy_ese)";
//	$resa = $db->query($sql);	
//	if($resa->isError()){ return $res->errormessage();}
//	echo 'success';
//}
// then update 
?>

<select><option>Female Reproductive System</option><option>...</option><optgroup label = 'Childrens'><option>Vulva</option><option>Ear</option></optgroup></select>

