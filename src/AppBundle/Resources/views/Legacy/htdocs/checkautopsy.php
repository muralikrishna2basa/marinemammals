<?php
// Access databae
$dbAc =  odbc_connect('zeezoogdieren','','');

$sql = "select count(*) as cnt_observations from observations where AutopsyReference is not null";

$rs = odbc_exec($dbAc,$sql);

$row = odbc_fetch_array($rs);


require_once('../../classes/db/Oracle_class.php');
require_once('../../classes/export/Export_interface.php');

//development database
$dbOr = new ORACLE('BIOLIB_OWNER','BIOLIB123','BIOLIBD.mumm.ac.be');

$sql = " select * from observations where AutopsyReference is not null";


$rs = odbc_exec($dbAc,$sql);
$autopsies  = array();
$counter = 0;

	$exports = new Exports();
	
	$xls = $exports->loadClass('CSV');

while($row = odbc_fetch_array($rs))
{
	$autopsy_reference = $row['AutopsyReference'];
	$date = $row['Date'];
	$place =$row['Place'];
	$comments =$row['Comments'];
	$specie = $row['Species'];
	$deccode = $row['DecompCode'];
	$sex = $row['Sex'];
	$length = $row['Length'];
	
	$sql = "select count(*) as cnt_nec from necropsies where ref_aut like '%$autopsy_reference%'";
	$res = $dbOr->query($sql)->fetch();
	if($res['CNT_NEC'] == 1) { $counter +=1; }
	else 
	{
		$xls->AddRow($row);
		//echo "$autopsy_reference,$date,$place,$comments,$specie,$deccode,$sex,$length";
	} 
}
$xls->Download("Autopsies");
$sql = "select ref_aut from necropsies ";
$res  = $dbOr ->query($sql);

$toto = $res->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
$ref_aut = $toto['REF_AUT'];



?>