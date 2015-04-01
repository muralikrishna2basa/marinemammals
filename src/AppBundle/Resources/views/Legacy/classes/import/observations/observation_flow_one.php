<?php
/**
 * 	Observation importation tool v1.0.0
 *  Event Screen
 *  
 * 
 * 
 */



date_default_timezone_set('Europe/Paris');

$year = idate('Y');

require_once(Classes.'import/flow_class.php');
require_once(Functions.'Fixcoding.php');


// Database Access

$db = $this->db;

//  Set javascript & css files, to be loaded dynamically 
$css = "/legacy/css/observation_flow_one.css";

$js = "/legacy/js/observation_flow_one.js";
//

$months =array('january','february','march','april','may','june','july','augustus','october','november','december');

//$this->thread = 3768;
// VALIDATION PART 

$val = $this->validation;

//$val->set('input_test',$_POST['input_test'],'required');

$val->set('date_test',array($_POST['year_date'],$_POST['month_date'],$_POST['day_date']),'checkdate');
$val->set('date_flag',$_POST['date_flag'],'notChoose','Required');


if(strlen($val->getValue('time_flow'))!=0) // In case a time is specified
{
$val->set('time_flag',$_POST['time_flag'],'notChoose','Required');
}
if(strlen($val->getValue('station_longitude_freecoord'))!=0 || strlen($val->getValue('station_latitude_freecoord'))!=0) // In case a time is specified
{
$val->set('precision_flag',$_POST['precision_flag'],'notChoose','Required');
}



$val->set('osn_type',$_POST['osn_type'],'notChoose','Required');

$val->set('station_flow',$_POST['station_flow'],'notinit','Station Required');

/**
 *  In case all conditions are satisfied, then check a possible instantiation of the thread
 *  If the thread is already started, then update the necessary items 
 *  In case the thread wasn't already started, then insert the necessary items
 *  If nothing went wrong, then navigate to the next screen ( $this->navigate();) 
 */
if($val->getStatus())
{
	// convert the date to be inserted in oracle 

   	$date = date('d-M-Y', strtotime($val->getValue('day_date').' '.$val->getValue('month_date').' '.$val->getValue('year_date')));
    
   	$date_flag = $val->getValue('date_flag');
    

    $time_event = isset($_POST['time_flow'])?$_POST['time_flow']:'12:00';
    
    $this->addPost('time_flow');
    
    $time = date('H-i',strtotime($time_event));
    
    $time_flag = $val->getValue('time_flag')=='Choose'?'':$val->getValue('time_flag');
    
    $eventdescription = $val->getValue('eventdescription');
    
    $event_format = "DD-Mon-YYYY HH24:MI";
	
    $event_date = $date.' '.$time;    	
   // convert latitude & longitude to database format
    $latitude = str_replace(array('°','�','\'','\'\''),array("/","/","/",""),$val->getValue('station_latitude_freecoord'));
	
    $longitude =str_replace(array('°','�','\'','\'\''),array("/","/","/",""),$val->getValue('station_longitude_freecoord'));
	
    $precision_flag = $val->getValue('precision_flag')=='Choose'?'':$val->getValue('precision_flag');
    
    $bind_event = array(':event_date'=>$event_date,':date_flag'=>$date_flag,':description'=>$eventdescription,':time_flag'=>$time_flag);

    $bind_observation = array(':latitude'=>$latitude,
    			   ':longitude'=>$longitude,
    			   ':station_flow'=>$val->getValue('station_flow'),
    			   ':osn_type'=>$val->getValue('osn_type'),
    			   ':precision_flag'=>$precision_flag);
	
    if($this->getThread()==false) // In case an observation isn't already started
    {
   	
   	// INSERT NEW EVENT
 	$sql = "insert into event_states(EVENT_DATE,DATE_FLAG,TIME_FLAG,DESCRIPTION) VALUES (to_date(:event_date,'$event_format'),:date_flag,:time_flag,:description)";
    
    		
	$res = $db->query($sql,$bind_event);
    		
	if($res->isError()){$val->setError('globalerror',$res->errormessage());}
    	
    // THREAD REGISTRATION
	
    $sql = "select cc_next_value-1 as new_event from cg_code_controls where CC_DOMAIN='ESE_SEQ'";
    $res = $db->query($sql);
	$row = $res->fetch();
	$new_event = $row['NEW_EVENT'];

	$this->thread = $new_event; 

	// INSERT CORRESPONDING OBSERVATION 
    
 	$sql = "insert into observations(ESE_SEQNO,OSN_TYPE,STN_SEQNO,LATITUDE,LONGITUDE,PRECISION_FLAG) values ($new_event,:osn_type,:station_flow,:latitude,:longitude,:precision_flag)";
   
    $res = $db->query($sql,$bind_observation);			      
    if($res->isError()){ $val->setError('globalerror',$res->errormessage());}
       
  }
   else 
   {
   	  $event_toupdate = $this->getThread(); 
   	  // UPDATE EVENT
   	  
   	  $sql = "update event_states set EVENT_DATE=to_date(:event_date,'$event_format'),
   	  		  DATE_FLAG=:date_flag,TIME_FLAG=:time_flag,DESCRIPTION=:description where seqno = '$event_toupdate'";
   	   $res = $db->query($sql,$bind_event);
    		
	  if($res->isError()){ $val->setError('globalerror',$res->errormessage());}
	  
	  // UPDATE OBSERVATION
	  $sql = "update observations set  OSN_TYPE=:osn_type,STN_SEQNO=:station_flow,LATITUDE=:latitude,LONGITUDE=:longitude,PRECISION_FLAG=:precision_flag where ese_seqno = '$event_toupdate'";
	  
	$res = $db->query($sql,$bind_observation);			      
    if($res->isError()){ $val->setError('globalerror',$res->errormessage());}
   	
   } 	
	
	if($val->getStatus()){ $this->navigate(); return;} // In case the insert or update functionality worked =>navigate 
}

// IN CASE, A THREAD is already registered, and the user came on the form from elsewhere in the flow ( or refresh the page) 
// a better use of this would be if($this->getThread()!=false && count($_POST)==0)
if($this->getThread()!=false && !isset($_POST['year_date']))
{
	$eventthread = $this->getThread();
	$sql = "select to_char(EVENT_DATE, 'DD-MM-YYYY') as EVENT_DATE,to_char(EVENT_DATE, 'HH24:MI') as EVENT_TIME,date_flag,time_flag,description from event_states where seqno = '$eventthread'";
	$res = $db->query($sql);
	if($res->isError()){$val->setError('globalerror',$res->errormessage()); }
	else 
	{
		$row = $res->fetch();
	}
	
	
	$event_date = explode('-',$row['EVENT_DATE']);
    
	$_POST['day_date'] = $event_date[0];
	$this->addPost('day_date');
	$_POST['month_date'] = $months[$event_date[1]-1];
	$this->addPost('month_date');
	$_POST['year_date']  = $event_date[2];
	$this->addPost('year_date');
	$_POST['date_flag'] = $row['DATE_FLAG'];
	$this->addPost('date_flag');
	$_POST['time_flag'] = $row['TIME_FLAG'];
	$this->addPost('time_flag');
	$_POST['eventdescription'] = $row['DESCRIPTION'];
	$this->addPost('eventdescription');
	$_POST['time_flow'] = $row['EVENT_TIME'];
	$this->addPost('time_flow');
	
	$sql = "select osn_type,stn_seqno,latitude,longitude,precision_flag from observations where ese_seqno='$eventthread'";
	$res = $db->query($sql);
	if($res->isError()){$val->setError('globalerror',$res->errormessage()); }
	else 
	{

		
		$row = $res->fetch();
		$_POST['station_longitude_freecoord'] = $row['LONGITUDE'];
		$this->addPost('station_longitude_freecoord');
		$_POST['station_latitude_freecoord'] = $row['LATITUDE'];
		$this->addPost('station_latitude_freecoord');
		$_POST['precision_flag'] = $row['PRECISION_FLAG'];
		$this->addPost('precision_flag');
		$_POST['osn_type'] = $row['OSN_TYPE'];
		$this->addPost('osn_type');
		$stn_seqno = $row['STN_SEQNO'];
		$sql = "select name,seqno
					from places b
					where name !='WORLD'
					connect by nocycle b.seqno = prior b.pce_seqno
					start with b.seqno =  (select pce_seqno from stations where seqno = '$stn_seqno')";
		
	    $res = $db->query($sql);
	    $results = $res->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
	    
	    $name_places = $results['SEQNO'];
	    $j = 0;
	    for($i = count($name_places)-1;$i>=0;$i--)
	    {
	    	$_POST['level'.$j] = $name_places[$i]; 
	    	$this->addPost('level'.$j);
		
	    	$j++;
	    }

	    
	    $_POST['station_flow'] = $stn_seqno;
	    $this->addPost('station_flow'); 
	    $sql = "select latitude,longitude,description,code from stations where seqno='$stn_seqno'";
	    $res = $db->query($sql);
	    $row = $res->fetch();
	    $_POST['station_latitude'] = $row['LATITUDE'];
	    $this->addPost('station_latitude'); 
	    $_POST['station_longitude'] = $row['LONGITUDE'];
	    $this->addPost('station_longitude'); 
	    $_POST['station_code']  = $row['CODE'];
	    $this->addPost('station_code'); 
	    $_POST['station_description'] = $row['DESCRIPTION'];
		$this->addPost('station_description'); 
	
	}
	
}

// Fill the select
$year_select ="";

for($i=$year;$i>$year-100;$i--)
{
	if($i == $val->getValue("year_date"))
	{
	$year_select .='<option selected="selected" value="'.$i.'">'.$i.'</option>';
	}
	else 
	{
	$year_select .='<option value="'.$i.'">'.$i.'</option>';
	}
}
$month_select = "";
for($i=0;$i<11;$i++)
{
	if($months[$i] == $val->getValue("month_date"))
	{
	$month_select .='<option selected="selected" value="'.$months[$i].'">'.$months[$i].'</option>';
	}
	else 
	{
	$month_select .='<option value="'.$months[$i].'">'.$months[$i].'</option>';
	}
}
$day_select = "";
for($i=1;$i<=31;$i++)
{
	if($i == $val->getValue("day_date"))
	{
	$day_select .='<option selected="selected" value="'.$i.'">'.$i.'</option>';
	}
	else 
	{
	$day_select .='<option value="'.$i.'">'.$i.'</option>';
	}
}


$sql = "select rv_meaning,rv_low_value from cg_ref_codes where rv_domain = 'VALUE_FLAG'";

$r = $db->query($sql);

$time_flag = "";
$date_flag = "";
$precision_flag = "";
if(!$r->isError())
{
	while($row = $r->fetch())
	{
		if($row['RV_LOW_VALUE'] == $val->getValue('precision_flag'))
		{
			$precision_flag .='<option selected="selected" value="'.$row['RV_LOW_VALUE'].'">'.$row['RV_MEANING'].'</option>';
		}
		else 
		{
			$precision_flag .='<option  value="'.$row['RV_LOW_VALUE'].'">'.$row['RV_MEANING'].'</option>';
		}
		if($row['RV_LOW_VALUE'] == $val->getValue('time_flag'))
		{
			$time_flag .='<option selected="selected" value="'.$row['RV_LOW_VALUE'].'">'.$row['RV_MEANING'].'</option>';
		}
		else 
		{
			$time_flag .='<option  value="'.$row['RV_LOW_VALUE'].'">'.$row['RV_MEANING'].'</option>';
		}
		if($row['RV_LOW_VALUE'] == $val->getValue('date_flag'))
		{
			$date_flag .='<option selected="selected" value="'.$row['RV_LOW_VALUE'].'">'.$row['RV_MEANING'].'</option>';
		}
		else 
		{
			$date_flag .='<option  value="'.$row['RV_LOW_VALUE'].'">'.$row['RV_MEANING'].'</option>';
		}
	} 
}

$sql = "select rv_meaning,rv_low_value from cg_ref_codes where rv_domain = 'OSN_TYPE'";
$r = $db->query($sql);
$osn_type = "";
if(!$r->isError())
{
	while($row = $r->fetch())
	{
		if($row['RV_LOW_VALUE'] == $val->getValue('osn_type'))
		{
			$osn_type .='<option selected="selected" value="'.$row['RV_LOW_VALUE'].'">'.$row['RV_MEANING'].'</option>';
		}
		else 
		{
			$osn_type .='<option  value="'.$row['RV_LOW_VALUE'].'">'.$row['RV_MEANING'].'</option>';
		}
	} 
}



?>
<form class='<?php echo $this->flowname.'_form';?> default_form event_state'>
<fieldset id="date_fs">
<legend>Event Information</legend>
<div class="qfrow">
<div class="qfelement twodiv">
<label for="Date-0" class="qflabel"><span class="required">*</span>Date:</label> 
<select name="year_date" ><option value="">Year</option><?php echo $year_select;?></select>
<select name= "month_date" ><option value="">Month</option><?php echo $month_select;?></select>
<select name= "day_date" ><option value="">Day</option><?php echo $day_select;?></select>
<?php echo $val->getError("date_test")?>
</div>
<div class="qfelement twodiv">
<label for="Date_flag-0" class="qflabel"><span class="required">*</span>Date flag:</label>
<select  id="Date_flag-0" name="date_flag"> 
<option value='Choose'>Choose</option>
<?php echo $date_flag;?>
</select>
<?php echo $val->getError("date_flag")?>
</div>
</div>
<div class="qfrow">
<div class="qfelement twodiv">
<label for="time_flow" class="qflabel">Time:</label>
<input id="time_flow" name="time_flow" value="<?php echo $val->getValue('time_flow');?>"/>
</div>
<div class="qfelement twodiv">
<label for="Time_flag-0" class="qflabel">Time flag:</label>
<select  id="Time_flag-0" name='time_flag'><option value='Choose'>Choose</option><?php echo $time_flag;?></select>
<?php echo $val->getError("time_flag")?>
</div>
</div>
<div class="qfrow">
<div class="qfelement">
<label for="Type_observation" class="qflabel"><span class="required">*</span>Type:</label>
<select name="osn_type" id = "Type_observation">
<option value='Choose'>Choose</option>
<?php echo $osn_type; ?>
</select>
<?php echo $val->getError("osn_type")?>
</div>
</div>
<div class="qfrow">
<div class="qfelement">
<label for="event_description-0" class="qflabel">Description:</label>
<textarea id = "event_description-0" name="eventdescription" rows="2" cols="20">
<?php echo $val->getValue('eventdescription');?>
</textarea>
</div>
</div>
</fieldset>
<?php  
/**
 * Stations Part
 */
?>
<fieldset id='event_station'>
<legend>Event Station</legend>
<fieldset id="obplaces_flow">
<legend>Places</legend>
<select  class="level0" name = "level0">
<?php
$sql ="select * from places where type = 'CTY'";
$res = $db->query($sql);
$html_places_stations = '<option value="init"></option>';
while($row = $res->fetch())
{
			$rsname = $row['NAME'];
			$rsseqno = $row['SEQNO'];
			if($rsseqno == $val->getValue('level0'))
			{
			$html_places_stations .='<option value="'.$rsseqno.'" selected="selected">'.$rsname."</option>";
			}
			else 
			{
			$html_places_stations .='<option value="'.$rsseqno.'">'.$rsname."</option>";
			}
}
echo $html_places_stations;
?>
</select>
<?php
// FILL THE CORRESPONDING SELECT, SO THAT NOTHING IS LOST AFTER A TRY 
 if(strlen($val->getValue('level1'))!=0)
 {
 	$sql  = 'select * from places where seqno =:seqno';
 	$bind = array(':seqno'=>$val->getValue('level1'));
 	$res = $db->query($sql,$bind);
 	$row = $res->fetch(); 
 	$level1name = $row['NAME'];
 	$level1seqno = $val->getValue('level1');
 }
 else 
 {
 	$level1name = '';
 	$level1seqno = '';
 }
 if(strlen($val->getValue('level2'))!=0)
 {
 	$sql  = 'select * from places where seqno =:seqno';
 	$bind = array(':seqno'=>$val->getValue('level2'));
 	$res = $db->query($sql,$bind);
 	$row = $res->fetch(); 
 	$level2name = $row['NAME'];
 	$level2seqno = $val->getValue('level2');
 }
 else 
 {
 	$level2name = '';
 	$level2seqno = '';
 }
if(strlen($val->getValue('level3'))!=0)
 {
 	$sql  = 'select * from places where seqno =:seqno';
 	$bind = array(':seqno'=>$val->getValue('level3'));
 	$res = $db->query($sql,$bind);
 	$row = $res->fetch(); 
 	$level3name = $row['NAME'];
 	$level3seqno = $val->getValue('level3');
 }
 else 
 {
 	$level3name = '';
 	$level3seqno = '';
 }  
?>
<select class="level1" name = "level1"><?php echo $level1name==''?'':'<option value="'.$level1seqno.'">'.$level1name.'</option>';?></select>
<select class="level2" name = "level2"><?php echo $level1name==''?'':'<option value="'.$level2seqno.'">'.$level2name.'</option>';?></select>
<select class="level3" name = "level3"><?php echo $level1name==''?'':'<option value="'.$level3seqno.'">'.$level3name.'</option>';?></select>
</fieldset>
<fieldset id="station_detail_flow">
<legend>Station</legend>
<div class="station_choice">
<?php
if($val->getValue('station_flow')!='init')
 {
 	$sql  = 'select * from stations where seqno =:seqno';
 	$bind = array(':seqno'=>$val->getValue('station_flow'));
 	$res = $db->query($sql,$bind);
 	$row = $res->fetch(); 
 	$areatype = isset($row['AREA_TYPE'])?$row['AREA_TYPE']:'';
 	$stationseqno = $val->getValue('station_flow');
 }
 else 
 {
 	$areatype = '';
 	$stationseqno = '';
 }  
?>
<label for="station_flow" class="qflabel"><span class="required">*</span>Area Type:</label><select id="station_flow" name = "station_flow"><option value="init">Choose</option>
 <?php echo $stationseqno==''?'':'<option value="'.$stationseqno.'" selected="selected">'.$areatype.'</option>'; ?>
</select>
</div>
<div class="station_items_flow">
<div>
<label for="station_latitude_flow" class ="label_station">Latitude</label>
<span id="station_latitude_flow" name="station_latitude"><?php echo $val->getValue('station_latitude');?></span>
</div>
<div>
<label for= "station_longitude_flow" class ="label_station">Longitude</label>
<span id="station_longitude_flow" name="station_longitude"><?php echo $val->getValue('station_longitude');?></span>
</div>
<div>
<label for="station_code_flow" class ="label_station">Code</label>
<span id ="station_code_flow" name="station_code"><?php echo $val->getValue('station_code');?></span>
</div>
<div>
<label for= "station_description_flow" class ="label_station">Description</label>
<span id ="station_description_flow" name="station_description"><?php echo $val->getValue('station_description');?></span>
</div>
</div>
<div class = "hasstation">
<img width="20" height="20" align="center" style = "display:none;" class ="ok" src="img/green.png">
<img width="20" height="20" align="center" class ="nonok" src="img/red.png">
</div>
<div style="clear:both;"></div>
</fieldset>
<div class='errormessage'><?php echo $val->getError("station_flow");?></div>
</fieldset>
<fieldset id='free_coordinates'>
<legend>Free Coordinates</legend>
<div class="item item1">
<label for="station_latitude_freecoord" class ="label_station">Latitude</label>
<input id="station_latitude_freecoord" name="station_latitude_freecoord" value="
<?php 
$latitude = str_replace(array('°','�','\'','\'\''),array("/","/","/",""),$val->getValue('station_latitude_freecoord'));
$longitude =str_replace(array('°','�','\'','\'\''),array("/","/","/",""),$val->getValue('station_longitude_freecoord'));
echo $latitude;
?>"/>
</div>
<div class="item item2">
<label for="station_longitude_freecoord" class ="label_station">Longitude</label>
<input id="station_longitude_freecoord" name="station_longitude_freecoord" value="<?php echo $longitude;?>"/>
</div>
<div class="item item3">
<label for="precision_flag" class ="label_station">Precision Flag</label>
<select  id="precision_flag" name='precision_flag'><option value='Choose'>Choose</option><?php echo $precision_flag;?></select>
<?php echo $val->getError("precision_flag");?>
</div>
<div class='errormessage'><?php  echo $val->getError('globalerror');?></div>
</fieldset>
<?php echo $this->getButtons(); ?>
</form>


