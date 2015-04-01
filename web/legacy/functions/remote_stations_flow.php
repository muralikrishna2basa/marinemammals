<?php
/**
 *  First load the places, then populate the area_type at the end...to check the station availability for the corresponding place
 * 
 * 
 */



require_once('../../directory.inc');
require_once(Classes."db/Oracle_class.php");

$cred = parse_ini_file(Ini."db_credentials.ini",true);
$user = 'biolib_owner';
$usr_cred = $cred[$user];

$db = new ORACLE ($usr_cred['login'],$usr_cred['pass'],$usr_cred['alias']);

function station_exist($station)
{
	
	if(!is_string($station) || strlen($station)==0){ return false;}
	global $db;
	$sql = "select count(*) as station_exist from stations where seqno = :seqno ";
	$bind = array(':seqno'=>$station);
	$res = $db->query($sql,$bind);
	if($res->isError()){ return false;}
	$row = $res->fetch();
	if($row['STATION_EXIST']=='1')
	{
		return true;
	}
	else 
	{
		return false;
	}
}
function place_exist($place)
{
	if(!is_string($place) || strlen($place)==0){ return false;}
	global $db;
	$sql = "select count(*) as place_exist from places where seqno = :seqno ";
	$bind = array(':seqno'=>$place);
	$res = $db->query($sql,$bind);
	if($res->isError()){ return false;}
	$row = $res->fetch();
	if($row['PLACE_EXIST']=='1')
	{
		return true;
	}
	else 
	{
		return false;
	}
}

/* Separate treatment, get informations about station*/
if(isset($_POST['seqno']) && strlen($_POST['seqno'])>0) 
{ 
	$seqno = $_POST['seqno'];
	
	if($seqno == 'toadd'){ return;} // do nothing -- tbis case should not happen, prevented by javascript
	$bind = array(':seqno'=>$seqno);
	$sql = 'select code,description,latitude,longitude from stations where seqno = :seqno';
	$res = $db->query($sql,$bind);
	if($db->iserror){ return;}
	else 
	{
		$row = $res->fetch();
		$code = addcslashes($row['CODE'],"\\\'\"&\n\r<>"); // don't know how but it works like a charm
		$description = (!isset($row['DESCRIPTION'])?'':$row['DESCRIPTION']);
		$latitude = $row['LATITUDE'];
		$longitude = $row['LONGITUDE'];
		$html = "<div><label for='station_latitude_flow' class ='label_station'>Latitude:</label><span id='station_latitude_flow'>$latitude'</span</div>";
		$html .="<div><label for='station_longitude_flow' class ='label_station'>Longitude:</label><span id='station_longitude_flow'>$longitude'</span></div>";
		$html .="<div><label for='station_code_flow' class ='station_code'>Code:</label><span id='station_code_flow'>$code</span></div>";
		$html .="<div><label for='station_description_flow' class ='label_station'>Description:</label><span id ='station_description_flow'>$description</span></div>";

	echo stripcslashes(json_encode(array('html'=>$html,'test'=>'test')));	
	return;		
	}
}
elseif(isset($_POST['seqno']))
{
	$html = "<div><label for='station_latitude_flow' class ='label_station'>Latitude:</label><span id='station_latitude_flow'></span></div>";
	$html .= "<div><label for= 'station_longitude_flow' class ='label_station'>Longitude:</label><span id='station_longitude_flow'></span></div>";
	$html .= "<div><label for='station_code_flow' class ='label_station'>Code:</label><span id ='station_code_flow'></span></div>";	
    $html .= "<div><label for= 'station_description_flow' class ='label_station'>Description:</label><span id ='station_description_flow'></span></div>";

	echo stripcslashes(json_encode(array('html'=>$html,'test'=>'test')));	
	return;	
}


$datatosend = json_decode($_POST['datatosend'],true);



$level = count($datatosend);

// restrict to places specified in the api

$sql = 'places';
$bind = array();
$prev = "";
for($i = 1;$i <= $level;$i++)
{	
	$binded = current($datatosend);
	if($binded!='')
	{
		$bind_name = ":name_$i";
		
		$bind[$bind_name] = $binded;

		next($datatosend);
		$prev = "select seqno from ($sql) where name = $bind_name";
		$sql = "select * from places where pce_seqno in ( $prev )";
	}
}

$sql = $sql.' order by type';

$res = $db->query($sql,$bind);

$html = "<option value='init'></option>";
$newopt = '';
while($rs = $res->fetch())
{
	$rstype = $rs['TYPE'];
	$rsname = $rs['NAME'];
	$rsseqno = $rs['SEQNO'];
	if($newopt == $rstype)
	{
		$html .="<option value='$rsseqno'>$rsname</option>";
	}
	else 
	{
		$newopt = $rstype;
		$html .=($newopt == ''?'':'</optgroup>')."<optgroup label = '$rstype'><option value='$rsseqno'>$rsname</option>";
	}
}

// check number of stations attached to the selection, 
$sql = "select count(*) as cnt_stations from stations where pce_seqno in ( $prev )";
$end = end($datatosend);

$res = $db->query($sql,$bind);
$rs = $res->fetch();
if($rs['CNT_STATIONS'] >= 1)
{
	$sql = "select seqno,area_type from stations where pce_seqno in ( $prev )";
	
	$res = $db->query($sql,$bind);
	$station = "<option value='init'>Choose</option>";
	while($rs = $res->fetch())
	{
		$station .= '<option value=\''.$rs['SEQNO'].'\'>'.$rs['AREA_TYPE'].'</option>';
	}

	$isstation ='true';
}
else 
{
	
	$station = "<option value='init'>Choose</option>";
	$isstation = 'false';
}
echo stripcslashes(json_encode(array('level'=>$level,'station'=>$station,'isstation'=>$isstation,'html'=>$html)));

?>

