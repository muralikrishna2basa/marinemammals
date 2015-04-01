<?php
/**
 * 	Batch Script import stations for each observation,
 *  all places must be already available
 * 	
 */

// conversion tables

$country_map = array('B'=>'BELGIUM',
				 'F'=>'FRANCE',
				 'NL'=>'NETHERLANDS',
				 'UK'=>'ENGLAND',
				 'PT'=>'PORTUGAL',
				 'D'=>'GERMANY');


require_once('../../classes/db/Oracle_class.php');
//development database
$dbOr = new ORACLE('BIOLIB_OWNER','BIOLIB123','BIOLIBD.mumm.ac.be');

// Access databae
$dbAc =  odbc_connect('zeezoogdieren','','');


// get places table

$sql = "select * from places";
$rsPce = odbc_exec($dbAc,$sql); 
$places = array();
while($row = odbc_fetch_array($rsPce)) // foreach Places 
{
	$code[] = $row['Code'];
	$placelink[] = $row['Place'];
	$lat[] = $row['RefLatDegrees'].'/'.$row['RefLatMinutes'];
	$long[] = $row['RefLonDegrees'].'/'.$row['RefLonMinutes'];
	$area_type[] = $row['AREA_TYPE'];
	$idod_place[] = $row['IDORA'];
	$description[] = $row['Description'];	
}


// browse observations table

$sql = "select * from observations";
$rsObs = odbc_exec($dbAc,$sql);

if(!$rsObs){ exit('Error in sql');}



$tt = array();
while($row = odbc_fetch_array($rsObs)) // foreach observation 
{
	$rowid = $row['ID'];
	if(in_array($row['Place'],$placelink))
	{
			
		$id = array_search($row['Place'],$placelink);
		$code_ins = $code[$id];
		$lat_ins = $lat[$id];
		$long_ins = $long[$id];
		$area_type_ins = $area_type[$id];
		$idod_place_int = $idod_place[$id];
		$description_int = $description[$id];
		
		// search if station not already entered 
		
		if($idod_place_int == null && $area_type_ins == null)
		{
		$sql = "select * from stations where pce_seqno is null and area_type is null";
	
		}
		elseif($idod_place_int == null)
		{
			$sql = "select * from stations where pce_seqno is null and area_type = '$area_type_ins'";
		}
		elseif( $area_type_ins == null) 
		{
			
			$sql = "select * from stations where pce_seqno = '$idod_place_int' and area_type is null";
		
		}
		else 
		{
		$sql = "select * from stations where pce_seqno = '$idod_place_int' and area_type = '$area_type_ins'";
		}
		
		$quer = $dbOr->query($sql);
		if($dbOr->iserror){ echo "error ID = $rowid SQL = $sql";return;}

		$res = $quer->fetch();
		
		if($res!=false)
		{
			$tt[] = $res['SEQNO'];
			$stn_seqno = $res['SEQNO'];
		
			$sql = "update observations set stn_seqno = '$stn_seqno' where id_access_tmp = '$rowid'";
		
			$quer = $dbOr->query($sql);
		
			if($dbOr->iserror){ echo "error ID = $rowid SQL = $sql";return;}
			
		}
		else 
		{
		// create station, link station to observation
		
		$sql = "insert into stations (area_type,description,latitude,longitude,pce_seqno,code) values (
				'$area_type_ins','$description_int','$lat_ins','$long_ins','$idod_place_int','
				$code_ins')";
		
		$dbOr->query($sql);
		if($dbOr->iserror){ echo "error ID = $rowid SQL = $sql error:$dbOr->errormessage";return;}
		
		$sql = "select cc_next_value -1 as testvalue from cg_code_controls where cc_domain = 'STN_SEQ'";
		
		$res = $dbOr->query($sql);
		if($dbOr->iserror){ echo "error ID = $rowid SQL = $sql";return;}
		$res = $res->fetch();
		
		// Link to observation 
		
		$stn_seqno = $res['TESTVALUE'];
		$sql = "update observations set stn_seqno = '$stn_seqno' where id_access_tmp = '$rowid'";
		
			$quer = $dbOr->query($sql);
		
			if($dbOr->iserror){ echo "error ID = $rowid SQL = $sql";return;}
			continue;
		}
		
	}
	else 
	{
		$rowid = $row['ID'];
		$rowPlace = $row['Place'];
		echo "not binded observation place : $rowid at $rowPlace <br>";
	}
}
echo implode('<br>',$tt);
?>