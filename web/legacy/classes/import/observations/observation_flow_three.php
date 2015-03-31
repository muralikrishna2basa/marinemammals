<?php
include_once(Classes.'import/flow_class.php');


$css = "css/observation_flow_three.css";
$js = "js/observation_flow_three.js";


// Database access & validation access
$db = $this->db;
$val = $this->validation;


$observation_seqno = $this->getThread();
// get the persons that belong to the informer group

$sql = "select a.* from persons a,groups b, person2groups c
where a.seqno = c.psn_seqno and b.name = c.grp_name and b.name = 'INFORMER'";

$res = $db->query($sql);

if($res->isError()){$val->setError('globalerror',$res->errormessage());}
else 
{
	$hidden_persons = array();
	while($row = $res->fetch())
	{
		$hidden_persons[] = array('LAST_NAME'=>$row['LAST_NAME'],'FIRST_NAME'=>$row['FIRST_NAME'],'SEQNO'=>$row['SEQNO']);
	}
}

// get the institutes that are also "persons" 

$sql = "select * from institutes";
$res = $db->query($sql);

if($res->isError()){$val->setError('globalerror',$res->errormessage());}
else 
{
	$hidden_institutes = array();
	while($row = $res->fetch())
	{
		$hidden_institutes[] = array('CODE'=>$row['CODE'],'NAME'=>$row['NAME'],'PSN_SEQNO'=>$row['PSN_SEQNO']);
	}
}


$sql = "select * from platforms";
$res = $db->query($sql);
if($res->isError()){$val->setError('globalerror',$res->errormessage());}
else 
{
	$hidden_platforms = array();
	
	while($row = $res->fetch())
	{
		$hidden_platforms[] = array('SEQNO'=>$row['SEQNO'],'NAME'=>$row['NAME']);
	}
}


// SET The validation rules



if(!isset($_POST['person_opt'])){$person_val = "";}
elseif(is_array($_POST['person_opt'])){$person_val = array_filter($_POST['person_opt']);}
elseif(is_string($_POST['person_opt'])) {$person_val = array_filter(array($_POST['person_opt']));}

if(!isset($_POST['institute_opt'])){$institute_val = "";}
elseif(is_array($_POST['institute_opt'])){$institute_val = array_filter($_POST['institute_opt']);}
elseif(is_string($_POST['institute_opt'])) {$institute_val = array_filter(array($_POST['institute_opt']));}

if($person_val == ""&& $institute_val == ""){	$contact_opt = null;}
elseif($person_val == "") { $contact_opt = $institute_val; }
elseif($institute_val == ""){$contact_opt = $person_val;}
else {$contact_opt = array_merge($person_val,$institute_val);}

$val->set('contact_opt',$contact_opt,'required','At least one contact must be specified');




if($val->getStatus())
{
	// In case all rules are validated
	
	// Check the existence of the person,institute link
	$sql = "select psn_seqno from event2persons where ese_seqno = :ese_seqno";
	$bind = array(':ese_seqno'=>$observation_seqno);
	$res = $db->query($sql,$bind);
	if($res->isError()){$val->setError('globalerror',$res->errormessage());}
	else 
	{
		$row = $res->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
		$psn_seqno = isset($row['PSN_SEQNO'])?$row['PSN_SEQNO']:array();
		
		$toinsert = array_diff($contact_opt,$psn_seqno);
		$todelete = array_diff($psn_seqno,$contact_opt);
		if(count($todelete)!=0)
		{	
			$bind_todelete = array(':ese_seqno'=>$observation_seqno);
			for($i=0;$i<count($todelete);$i++)
			{
				$bind_todelete[":todelete$i"] = $todelete[$i];
			}
			$bindsql_todelete = '('.implode(',',array_keys($bind_todelete)).')';
			$sql = "delete from event2persons where ese_seqno = :ese_seqno and psn_seqno in $bindsql_todelete";
			$res = $db->query($sql,$bindsql_todelete);
		}
		if(count($toinsert)!=0)
		{
			foreach($toinsert as $item)
			{
			$binds = array(':ese_seqno'=>$observation_seqno,':toinsert'=>$item);
			
			// The event2person type is supposed to be an observer
			$sql = "insert into event2persons(ese_seqno,psn_seqno,e2p_type) values (:ese_seqno,:toinsert,'OB')";	
			$res = $db->query($sql,$binds);
			if($res->isError()){$val->setError('globalerror',$res->errormessage());}	
			}
		}
	}
	// update observations set web comments 
	
	$sql = "update observations set webcomments_nl = :webnl, webcomments_fr = :webfr, webcomments_en = :weben where ese_seqno = :ese_seqno";
	$binds = array(':ese_seqno'=>$observation_seqno,
				   ':webnl'=>$val->getValue('Webcomments_du_flow'),
				   'webfr'=>$val->getValue('Webcomments_fr_flow'),
				   'weben'=>$val->getValue('Webcomments_en_flow'));
	$res = $db->query($sql,$binds);
	if($res->isError()){$val->setError('globalerror',$res->errormessage());}	
	
	// link to existing platform or create a platform and link it to the observation
	$platform_flow = $val->getValue('Platform_flow');
	$platform_seqno = "";
	if(strlen($platform_flow)>0)
	{
		
	$sql = "select count(*) as cntptm from platforms where name = :name";
	$bind = array(':name'=>$platform_flow);
	
	$res = $db->query($sql,$bind);
	if($res->isError()){$val->setError('globalerror',$res->errormessage());}
	else 
	{
		$row = $res->fetch();
		if($row['CNTPTM'] == 0) // in case the platform does not exist yet => create one 
		{
			$sql = "insert into platforms( name) values (:name)";
			$bind = array(':name'=>$platform_flow);
			$res = $db->query($sql,$bind);
			if($res->isError()){$val->setError('globalerror',$res->errormessage());}
			else 
			{
			// get the newly created platform
			$sql = "select cc_next_value - cc_increment as platform_seqno from cg_code_controls where cc_domain = 'PTM_SEQ'";
			$res = $db->query($sql,$bind);
			if($res->isError()){$val->setError('globalerror',$res->errormessage());}
			else 
			{
				$row = $res->fetch();
				$platform_seqno = $row['PLATFORM_SEQNO'];
			}
			
			}
		}
		elseif($row['CNTPTM'] == 1)
		{
			$sql = "select seqno from platforms where name = :name";
			$bind = array(':name'=>$platform_flow);
			$res = $db->query($sql,$bind);
			if($res->isError()){$val->setError('globalerror',$res->errormessage());}
			else 
			{
				$row = $res->fetch();
				$platform_seqno = $row['SEQNO'];
			}
		}
	}
	
	}
	// in case a platform has been identified or created => link it to the corresponding observation
	if(strlen($platform_seqno)!=0)
	{
		$sql = "update observations set ptm_seqno = :ptm_seqno where ese_seqno = :ese_seqno";
		$bind = array(':ese_seqno'=>$observation_seqno,':ptm_seqno'=>$platform_seqno);
		$res = $db->query($sql,$bind);
		if($res->isError()){$val->setError('globalerror',$res->errormessage());}
		
	}
	
}

// In case the user came from elsewhere in the thread ( at load time) 

if($this->getThread()!=false && $val->getValue('person_opt')=='' && $val->getValue('institute_opt')=='')
{
	// select a person ( pseudo institutes are therefore excluded)
	$sql = "select psn_seqno from event2persons
			where ese_seqno = :ese_seqno
			and psn_seqno not in (select c.psn_seqno from institutes c)";
	$bind = array(':ese_seqno'=>$observation_seqno);
	$res = $db->query($sql,$bind);
	if($res->isError()){$val->setError('globalerror',$res->errormessage());}
	else 
	{
		while($row = $res->fetch())
		{
			isset($row['PSN_SEQNO'])?$_POST['person_opt'][] = $row['PSN_SEQNO']:'';
			$this->addPost('person_opt');
		}
	}
	// select pseudo institutes
	$sql = "select psn_seqno from event2persons
			where ese_seqno = :ese_seqno
			and psn_seqno in (select c.psn_seqno from institutes c)";
	$bind = array(':ese_seqno'=>$observation_seqno);
	$res = $db->query($sql,$bind);
	if($res->isError()){$val->setError('globalerror',$res->errormessage());}
	else 
	{
		
		while($row = $res->fetch())
		{
			isset($row['PSN_SEQNO'])?$_POST['institute_opt'][] = $row['PSN_SEQNO']:'';
			$this->addPost('institute_opt');
		}
	}
	$sql = "select a.name from platforms a,observations b where a.seqno = b.ptm_seqno and b.ese_seqno =:ese_seqno";
	$bind = array(':ese_seqno'=>$observation_seqno);
	$res = $db->query($sql,$bind);
	if($res->isError()){$val->setError('globalerror',$res->errormessage());}
	else 
	{
		$row = $res->fetch();
	
		isset($row['NAME'])?$_POST['Platform_flow'] = $row['NAME']:'';	
		$this->addPost('Platform_flow');
	}
	$sql = "select * from observations where ese_seqno =:ese_seqno";
	$bind = array(':ese_seqno'=>$observation_seqno);
	$res = $db->query($sql,$bind);
	if($res->isError()){$val->setError('globalerror',$res->errormessage());}
	else 
	{
		$row = $res->fetch();
		isset($row['WEBCOMMENTS_FR'])?$_POST['Webcomments_fr_flow'] = $row['WEBCOMMENTS_FR']:"";
		$this->addPost('Webcomments_fr_flow');
		isset($row['WEBCOMMENTS_NL'])?$_POST['Webcomments_du_flow'] = $row['WEBCOMMENTS_NL']:"";
		$this->addPost('Webcomments_du_flow');
		isset($row['WEBCOMMENTS_EN'])?$_POST['Webcomments_en_flow'] = $row['WEBCOMMENTS_EN']:"";
		$this->addPost('Webcomments_en_flow');
		

		
		
	}
	
}

if($val->getStatus()) {$this->navigate(); return;}

echo "<div class ='hidden_persons' style = 'display:none;'>".json_encode($hidden_persons )."</div>";
echo "<div class ='hidden_institutes' style = 'display:none;'>".json_encode($hidden_institutes )."</div>";
echo "<div class ='hidden_platforms' style = 'display:none;'>".json_encode($hidden_platforms )."</div>";
?>
<form class='<?php echo $this->flowname.'_form';?> default_form'>
<input name ='person_opt' style='display:none;'/>
<input name ='institute_opt' style='display:none;'/>
<div id = "contact_flow" class="ui-widget" >
<fieldset id="contact_fs">
<legend>Contact Details</legend>

<div class="qfrow">
<div class="qfelement">
<label for="Person_flow" class="qflabel">Person </label> 
<input type="text" id="Person_flow" class="contact_attribute"  name="Person_flow" />
<button class="addtab ui-state-default persons_opt" type="button"><span class="ui-icon ui-icon-plus"></span></button>
</div>
</div>

<div class="qfrow">
<div class="qfelement">
<label for="Institute_flow" class="qflabel">Institute </label> 
<input type="text" id="Institute_flow" class="contact_attribute"  name="Institute_flow" />
<button class="addtab ui-state-default institutes_opt" type="button"><span class="ui-icon ui-icon-plus"></span></button>
</div>
</div>

<div class="qfrow">
<div class="qfelement">
<label for="multiselect_contact" class="qflabel"><span class="required">*</span>Selected Contacts</label> 
<select size="8" id='multiselect_contact' multiple="" >
<optgroup id="persons_opt" label="Persons">
<?php 
$persons_opt = $val->getValue('person_opt'); // get a list of id's
$institutes_opt = $val->getValue('institute_opt'); // get a list of id's
if(is_array($persons_opt))
{
	$bind_persons = array();
	for($i=0;$i<count($persons_opt);$i++)
	{
		$bind_persons[":person$i"] = $persons_opt[$i];
	}
	$bindsql_persons = '('.implode(',',array_keys($bind_persons)).')';
	
$sql = "select * from persons where seqno in $bindsql_persons";
$res = $db->query($sql,$bind_persons);
if($res->isError()){$val->setError('globalerror',$res->errormessage());}
else 
{
	$inputs_persons = "";
	while($row = $res->fetch())
	{
		$seqno = $row['SEQNO'];
		$name = $row['LAST_NAME'];
		echo "<option pk='$seqno'>$name</option>";
		$inputs_persons .="<input name='person_opt[]' style='display:none;' value='$seqno'>";
	}
}
}
?>
</optgroup>
<optgroup id="institutes_opt" label="Institutes">
<?php 
$inputs_institutes = "";
if(is_array($institutes_opt))
{
	$binds = array();
	for($i=0;$i<count($institutes_opt);$i++)
	{
		$binds[":institute$i"] = $institutes_opt[$i];
	}
	$bindsql = '('.implode(',',array_keys($binds)).')';
	
$sql = "select * from institutes where psn_seqno in $bindsql";
$res = $db->query($sql,$binds);

if($res->isError()){$val->setError('globalerror',$res->errormessage());}
else 
{
	
	while($row = $res->fetch())
	{
		$seqno = $row['SEQNO'];
		$psn_seqno = $row['PSN_SEQNO'];
		$name = $row['NAME'];
		echo "<option pk='$psn_seqno'>$name</option>";
		$inputs_institutes .="<input name='institute_opt[]' style='display:none;' value='$psn_seqno'>";
	}
}

}
?>
</optgroup>
</select>
<?php echo $val->getError("contact_opt");
echo $inputs_persons;
echo $inputs_institutes;
?>
</div>
</div>
</fieldset>
<fieldset id='Platform_fs'>
<div class="qfrow">
<div class="qfelement">
<label for="Platform_flow" class="qflabel">Platform:</label>
<textarea id = "Platform_flow" name="Platform_flow" rows="2" cols="20">
<?php echo $val->getValue('Platform_flow');?>
</textarea>
</div>
</div>
</fieldset>
</div>
<fieldset id='Webcomments_fs'>
<legend>Web Comments</legend>
<div class="qfrow">
<div class="qfelement">
<label for="Webcomments_du_flow" class="qflabel">Dutch:</label>
<textarea id = "Webcomments_du_flow" name="Webcomments_du_flow" rows="3" cols="30">
<?php echo $val->getValue('Webcomments_du_flow');?>
</textarea>
</div>
</div>
<div class="qfrow">
<div class="qfelement">
<label for="Webcomments_fr_flow" class="qflabel">French:</label>
<textarea id = "Webcomments_fr_flow" name="Webcomments_fr_flow" rows="3" cols="30">
<?php echo $val->getValue('Webcomments_fr_flow');?>
</textarea>
</div>
</div>
<div class="qfrow">
<div class="qfelement">
<label for="Webcomments_en_flow" class="qflabel">English:</label>
<textarea id = "Webcomments_en_flow" name="Webcomments_en_flow" rows="3" cols="30">
<?php echo $val->getValue('Webcomments_en_flow');?>
</textarea>
</div>
</div>
</fieldset>
<div class='errormessage'><?php  echo $val->getError('globalerror');?></div>
<?php echo $this->getButtons();?>
</form>

<?php

//		unset($_POST['person_opt']);
//		unset($_POST['institute_opt']);
//		unset($_POST['Platform_flow']);
//		unset($_POST['Webcomments_fr_flow']);
//		unset($_POST['Webcomments_du_flow']);
//		unset($_POST['Webcomments_en_flow']);


