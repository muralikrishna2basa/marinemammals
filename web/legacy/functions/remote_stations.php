<?php
/**
 *  First load the places, then populate the area_type at the end...to check the station availability for the corresponding place
 * 
 * 
 */



require_once('../../directory.inc');
require_once(Classes."db/Oracle_class.php");

//	$cred = parse_ini_file(Ini."db_credentials.ini",true);
//	$user = 'biolib_test';
//	$usr_cred = $cred[$user];
//	$db = new ORACLE ($usr_cred['login'],$usr_cred['pass'],$usr_cred['alias']);
include_once(Functions.'getAuthDb.php');

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
if(isset($_POST['action']) && is_string($_POST['action']) && strlen($_POST['action'])>0)
{
	$action = $_POST['action'];
	$place =  isset($_POST['place'])?$_POST['place']:"";
	$area_type =   isset($_POST['station_area_type'])?$_POST['station_area_type']:"";
	$latitude =   isset($_POST['station_latitude'])?$_POST['station_latitude']:"";
	$longitude =   isset($_POST['station_longitude'])?$_POST['station_longitude']:"";
	$code =        isset($_POST['station_code'])?$_POST['station_code']:"";
	$description = isset($_POST['station_description'])?$_POST['station_description']:"";
	$station  = isset($_POST['station'])?$_POST['station']:"";


	if($action == 'delete' && station_exist($station))
	{
		$sql = "delete from stations where seqno = $station";
		$res = $db->query($sql);
		if($res->isError()){ echo json_encode(array('isError'=>'true','errormessage'=>$db->errormessage()));}
		else { echo json_encode(array('isError'=>'false','errormessage'=>'item successfuly deleted'));}
     	return;
	}
    if($action =='update' && station_exist($station))
    {
    	$sql = "update stations set area_type = :area_type, code= :code,latitude=:latitude,longitude=:longitude,description=:description where seqno = '$station'";

		$bind = array(':area_type'=>$area_type,':code'=>$code,':latitude'=>$latitude,':longitude'=>$longitude,':description'=>$description);
		
		$res = $db->query($sql,$bind);
		if($res->isError()){ echo json_encode(array('isError'=>'true','errormessage'=>$db->errormessage()));}
		else { echo json_encode(array('isError'=>'false','errormessage'=>'item successfuly updated'));}
     	return;
				
    	
    }
    if($action =='add' && place_exist($place))
    {
    	$sql = "insert into stations (area_type,code,description,latitude,longitude,pce_seqno) values (:area_type,:code,:description,:latitude,:longitude,'$place')";
    	$bind = array(':area_type'=>$area_type,':code'=>$code,':latitude'=>$latitude,':longitude'=>$longitude,':description'=>$description);
    	$res = $db->query($sql,$bind);
		if($res->isError()){ echo json_encode(array('isError'=>'true','errormessage'=>$db->errormessage()));}
		else { echo json_encode(array('isError'=>'false','errormessage'=>'item successfuly added'));}
        return;
    }
	 return;	
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
		$html = "<div><label for='station_latitude' class ='label_station'>Latitude:</label><input id='station_latitude' value='$latitude' name='station_latitude'/></div>";
		$html .="<div><label for='station_longitude' class ='label_station'>Longitude:</label><input id='station_longitude' value='$longitude' name='station_longitude'/></div>";
		$html .="<div><label for='station_code' class ='station_code'>Code:</label><input id='station_code' value='$code' name='station_code'/></div>";
		$html .="<div><label for='station_description' class ='label_station'>Description:</label><input id ='station_description' value='$description' name='station_description'/></div>";

	echo stripcslashes(json_encode(array('html'=>$html,'test'=>'test')));	
	return;		
	}
}
elseif(isset($_POST['seqno']))
{
	$html = "<div><label for='station_latitude' class ='label_station'>Latitude:</label><input id='station_latitude' name='station_latitude'/></div>";
	$html .= "<div><label for= 'station_longitude' class ='label_station'>Longitude:</label><input id='station_longitude' name='station_longitude' /></div>";
	$html .= "<div><label for='station_code' class ='label_station'>Code:</label><input id ='station_code'  name='station_code'/></div>";	
    $html .= "<div><label for= 'station_description' class ='label_station'>Description:</label><input id ='station_description' name='station_description' /></div>";

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