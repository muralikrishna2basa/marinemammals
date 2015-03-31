<?php
/**
 * 	Observation importation tool v1.0.0
 *  Specimens Screen
 *  
 * 
 * 
 */

include_once(Classes.'import/flow_class.php');


$css = "css/observation_flow_two.css";
$js = "js/observation_flow_two.js";


// get list of specimens 
$db = $this->db;
$val = $this->validation;

$sql = "select idod_id,trivial_name from taxas order by taxa";
$res = $db->query($sql);
$taxaoptions = "<option></option>";
if($res->isError()){$val->setError('globalerror',$res->errormessage());}
else 
{
	while($row = $res->fetch())
	{
		if($val->getValue('specie_flow') == $row["IDOD_ID"])
		{
		$taxaoptions .= '<option selected="selected" value="'.htmlentities($row["TRIVIAL_NAME"]).'">'.htmlentities($row["TRIVIAL_NAME"]).'</option>';
		}
		else 
		{
		$taxaoptions .= '<option value="'.htmlentities($row["TRIVIAL_NAME"]).'">'.htmlentities($row["TRIVIAL_NAME"]).'</option>';
		}
	}
}

$sql = "select rv_meaning,rv_low_value from cg_ref_codes where rv_domain = 'VALUE_FLAG'";

$r = $db->query($sql);

$specie_flag = "";
if(!$r->isError())
{
	while($row = $r->fetch())
	{
		if($row['RV_LOW_VALUE'] == $val->getValue('Specie_flag'))
		{
			$specie_flag .='<option selected="selected" value="'.$row['RV_LOW_VALUE'].'">'.$row['RV_MEANING'].'</option>';
		}
		else 
		{
			$specie_flag .='<option  value="'.$row['RV_LOW_VALUE'].'">'.$row['RV_MEANING'].'</option>';
		}
		
	} 
}
else 
{
$val->setError('globalerror',$res->errormessage());	
}
$sex_options_flow = "";
$sex_options_flow .= $val->getValue('Sex')=='ML'?"<option selected='selected' value='ML'>ML</option>":"<option value='ML'>ML</option>";
$sex_options_flow .= $val->getValue('Sex')=='FM'?"<option selected='selected' value='FM'>FM</option>":"<option value='FM'>FM</option>";
$sex_options_flow .= $val->getValue('Sex')=='UNK'?"<option selected='selected' value='UNK'>UNK</option>":"<option value='UNK'>UNK</option>";


$number_options = ""; 
for($i=1;$i<=100;$i++)
{
	if($i==$val->getValue('nbr_specimens')){$number_options .="<option selected='selected' value='$i'>$i</option>";}
	else {$number_options .="<option value='$i'>$i</option>";}
}

// Cause of death 

$sql = "select a.code,a.description from parameter_domains a, parameter_methods b
where a.pmd_seqno = b.seqno 
and name='Cause Of Death'";

$res = $db->query($sql);
if($res->isError()){ $val->setError('globalerror',$res->errormessage());}

$cause_of_death = "<option></option>";
while($row = $res->fetch())
{
	if($val->getValue('cause_of_death_flow') == $row['CODE'])
	{
	$cause_of_death .= "<option selected='selected' value='".$row['CODE']."'>".$row['DESCRIPTION']."</option>";
	}
	else 
	{
	$cause_of_death .= "<option value='".$row['CODE']."'>".$row['DESCRIPTION']."</option>";
	}
}

$val->set('globalerror',array($_POST['specimen_data'],$_POST['observed_specimen']),'required','Create at least one specimen or link it to another specimen');

$inserted_specimens = array();

if($val->getStatus())
{
				
				
	$observation_seqno = $this->getThread();
	$specimen_data = $val->getValue('specimen_data');
	$observed_specimen = $val->getValue('observed_specimen');
	
	// Transform data's into usable ones.
	$specimens_creat = array();

	$i = 0;
	foreach($specimen_data as $spec_data)
	{
		
		if(strlen($spec_data)!=0)
		{
			$specimen_creat = json_decode($spec_data,true);
			
			// Convert Specie to database format
			$sql = "select idod_id from taxas where trivial_name = :taxa";
			$bind = array(':taxa'=>$specimen_creat['specie_flow']);
			$res = $db->query($sql,$bind);
			$row = $res->fetch();
			$taxa = $row['IDOD_ID'];
			
			if(array_key_exists('seqno',$specimen_creat)) // In case a specimen already exist then update
			{
				// additional check, so that we are sure that the seqno correspond to a unique specimen
				// It would be a pity to update the whole set of specimens 
				$sql = "select count(*) as num_specimen from specimens where seqno = :seqno";
				$bind = array(':seqno'=>$specimen_creat['seqno']);
				$res = $db->query($sql,$bind);
				if($res->isError()){$val->setError('globalerror',$res->errormessage());}
				else 
				{
					$row = $res->fetch();
					$num_specimen = $row['NUM_SPECIMEN'];
					
					if($num_specimen == '1')
					{
							
						$sql = "update specimens set scn_number=:scn_number,sex=:sex,rbins_tag=:rbins_tag,specie_flag=:specie_flag,
						txn_seqno='$taxa',mummtagserie=:mummtagserie,mummtag=:mummtag where seqno = :seqno ";

						$binds = array(':scn_number'=>$specimen_creat['nbr_specimens'],
								':sex'=>$specimen_creat['Sex'],
								':rbins_tag'=>$specimen_creat['Rbins_flag'],
								':specie_flag'=>$specimen_creat['specie_flag'],
								':mummtagserie'=>$specimen_creat['mummtagserie'],
								':mummtag'=>$specimen_creat['mummtag'],
								':seqno'=> $specimen_creat['seqno']);			
						$res = $db->query($sql,$binds);
						if($res->isError()){$val->setError('globalerror',$res->errormessage());}
						
						// even if the specimen didn't update well, the variable will still be incremented
						$inserted_specimens[$specimen_creat['seqno']] = $i;
						
					
					}
				}

				
			}
			else // Create new specimen
			{
				$sql = "insert into specimens (scn_number,sex,rbins_tag,specie_flag,txn_seqno,mummtagserie,mummtag) 
						values (:scn_number,:sex,:rbins_tag,:specie_flag,'$taxa',:mummtagserie,:mummtag)";
				$binds = array(':scn_number'=>$specimen_creat['nbr_specimens'],
								':sex'=>$specimen_creat['Sex'],
								':rbins_tag'=>$specimen_creat['Rbins_flag'],
								':specie_flag'=>$specimen_creat['specie_flag'],
								':mummtagserie'=>$specimen_creat['mummtagserie'],
								':mummtag'=>$specimen_creat['mummtag']);
				$res = $db->query($sql,$binds);
				if($res->isError()){$val->setError('globalerror',$res->errormessage());}
				else 
				{
				// If the specimen has been created => retrieve just created animal seqno

				$sql = "select cc_next_value - cc_increment as seqno from cg_code_controls where cc_domain = 'SCN_SEQ'";
				$res = $db->query($sql);$row = $res->fetch();
				if($res->isError()){$val->setError('globalerror',$res->errormessage());}
				$specimen_seqno = $row['SEQNO'];
				
				// get the inserted specimen into that variable
				$inserted_specimens[$specimen_seqno] = $i;
				
				$sql = "insert into spec2events ( ese_seqno,scn_seqno) values (:ese_seqno,:scn_seqno)";
				$bind = array(':ese_seqno'=>$observation_seqno,':scn_seqno'=>$specimen_seqno);
				$res = $db->query($sql,$bind);
				
				if($res->isError()){$val->setError('globalerror',$res->errormessage());}
				
				// Add the known specimen properties to the just created specimen
				
				$length = $specimen_creat['Length'];
				$weight = $specimen_creat['Weigth'];
			//	$blubber_thickness = $specimen_creat['Blubber_thickness'];
				$cause_of_death = $specimen_creat['cause_of_death_flow'];
				
				// GET THE SEQNO OF THE CORRESPONDING PARAMETERS
				$sql = "select seqno from parameter_methods where name = 'Length'";
				$res = $db->query($sql);
				$row = $res->fetch();
				$length_seqno = $row['SEQNO'];
			//	$sql = "select seqno from parameter_methods where name = 'Blubber Thickness'";
			//	$res = $db->query($sql);
			//	$row = $res->fetch();
			//	$blubber_thickness_seqno = $row['SEQNO'];
				$sql = "select seqno from parameter_methods where name = 'Cause Of Death'";
				$res = $db->query($sql);
				$row = $res->fetch();
				$cause_of_death_seqno = $row['SEQNO'];
				$sql = "select seqno from parameter_methods where name = 'Weight'";
				$res = $db->query($sql);
				$row = $res->fetch();
				$weight_seqno = $row['SEQNO'];
				
				// It is assumed that the length,... are good values so that value_flag = 1
				
				if(strlen($length)!=0)
				{
					$sql = "insert into specimen_values(PMD_SEQNO,S2E_ESE_SEQNO,S2E_SCN_SEQNO,VALUE,VALUE_FLAG) values
					($length_seqno ,$observation_seqno,$specimen_seqno,:value,1)";			
					$bind = array(':value'=>$length);
					$res = $db->query($sql,$bind);
					if($res->isError()){$val->setError('globalerror',$res->errormessage());}
				}
				
//				if(strlen($blubber_thickness)!=0)
//				{
//					$sql = "insert into specimen_values(PMD_SEQNO,S2E_ESE_SEQNO,S2E_SCN_SEQNO,VALUE,VALUE_FLAG) values
//					($blubber_thickness_seqno ,$observation_seqno,$specimen_seqno,:value,1)";			
//					$bind = array(':value'=>$blubber_thickness);
//					$res = $db->query($sql,$bind);
//					if($res->isError()){$val->setError('globalerror',$res->errormessage());}
//				}
								
				if(strlen($cause_of_death)!=0)
				{
					$sql = "insert into specimen_values(PMD_SEQNO,S2E_ESE_SEQNO,S2E_SCN_SEQNO,VALUE,VALUE_FLAG) values
					($cause_of_death_seqno ,$observation_seqno,$specimen_seqno,:value,1)";			
					$bind = array(':value'=>$cause_of_death);
					$res = $db->query($sql,$bind);
					if($res->isError()){$val->setError('globalerror',$res->errormessage());}
				}
				
				if(strlen($weight)!=0)
				{
					$sql = "insert into specimen_values(PMD_SEQNO,S2E_ESE_SEQNO,S2E_SCN_SEQNO,VALUE,VALUE_FLAG) values
					($weight_seqno ,$observation_seqno,$specimen_seqno,:value,1)";			
					$bind = array(':value'=>$weight);
					$res = $db->query($sql,$bind);
					if($res->isError()){$val->setError('globalerror',$res->errormessage());}
				}
				
				}
				 
							
			}
			
			
		}
		$i++;
	}
	$specimens_obs = array();
	
	
	
	$sql = "select scn_seqno from spec2events where ese_seqno = :ese_seqno";
	$bind = array(':ese_seqno'=>$observation_seqno);
	$res = $db->query($sql,$bind);
	$row = $res->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
	$scns_seqno = $row['SCN_SEQNO']; // deliver array of specimens seqno
	
	$observed_specimen = array_merge($observed_specimen,array_keys($inserted_specimens)); // add the newly created specimens to the list so that they don't get deleted

	// Delete necessary specimens, observations links in the gui, this corresponds to a delete in the list of specimens
    if($scns_seqno != null)
    {
		foreach($scns_seqno as $scn_seqno) { 
			if(!in_array($scn_seqno,array_keys($inserted_specimens))){
			
				$sql = "delete from specimen_values where s2e_ese_seqno = :ese_seqno and s2e_scn_seqno = :scn_seqno";
				$bind = array(':ese_seqno'=>$observation_seqno,':scn_seqno'=>$scn_seqno);
				$res = $db->query($sql,$bind);
				if($res->isError()){$val->setError('globalerror',$res->errormessage());}
			
				$sql = "delete from spec2events where ese_seqno = :ese_seqno and scn_seqno = :scn_seqno";
				$bind = array(':ese_seqno'=>$observation_seqno,':scn_seqno'=>$scn_seqno);
				$res = $db->query($sql,$bind);
				if($res->isError()){$val->setError('globalerror',$res->errormessage());}
			}
		
		}
    }
    if($scns_seqno == null) 
    {
    	$scns_seqno = array(); // so that every new links are updated in the next insert statement 
    }
// Insert necessary specimens, observations links
	$toinsert = array();
	
	foreach($observed_specimen as $obs_spec) { 
		if(strlen($obs_spec)!=0 && !in_array($obs_spec,$scns_seqno))
		{
			$sql = "insert into spec2events(ese_seqno,scn_seqno) values (:ese_seqno,:scn_seqno)";
			$bind = array(':ese_seqno'=>$observation_seqno,':scn_seqno'=>$obs_spec);
			$res = $db->query($sql,$bind);
			if($res->isError()){$val->setError('globalerror',$res->errormessage());}
		}
	}

    
	

	// Convert specie to database format 
	

//	 return;
}

// In case the user came from elsewhere in the thread

if($this->getThread()!=false && $val->getValue('specimen_data')=='')
{
	$observation_seqno = $this->getThread();
	// Check the number of specimen attached to it 
	
	$sql = "select a.seqno, a.specie_flag,a.mummtag, a.mummtagserie, a.rbins_tag,a.scn_number, a.sex, c.trivial_name,
	(select value from specimen_values where pmd_seqno = (select seqno from parameter_methods where name = 'Length')
	and specimen_values.s2e_ese_seqno = b.seqno and specimen_values.s2e_scn_seqno = a.seqno
	) as LENGTH, 
	(select value from specimen_values where pmd_seqno = (select seqno from parameter_methods where name = 'Weight')
	and specimen_values.s2e_ese_seqno = b.seqno and specimen_values.s2e_scn_seqno = a.seqno
	) as WEIGHT, 
	(select value from specimen_values where pmd_seqno = (select seqno from parameter_methods where name = 'Blubber Thickness')
	and specimen_values.s2e_ese_seqno = b.seqno and specimen_values.s2e_scn_seqno = a.seqno
	) as Blubber_Thickness,
	(select value from specimen_values where pmd_seqno = (select seqno from parameter_methods where name = 'Cause Of Death')
	and specimen_values.s2e_ese_seqno = b.seqno and specimen_values.s2e_scn_seqno = a.seqno
	) as Cause_Of_Death
	from specimens a, event_states b, taxas c, spec2events d
	where a.seqno = d.scn_seqno and c.idod_id = a.txn_seqno and b.seqno = d.ese_seqno 
	and ese_seqno = '$observation_seqno'";
	$res = $db->query($sql);
	if($res->isError()){$val->setError('globalerror',$res->errormessage());}
	else 
	{
		
		while($row = $res->fetch()) // specimen browsing 
		{
			$tmp_specimen_data = array(); // init array 
			// fill the specimen_data array
			
			isset($row['SEQNO'])?$tmp_specimen_data['seqno'] =  $row['SEQNO']:'';
			isset($row['SPECIE_FLAG'])?$tmp_specimen_data['specie_flag'] =  $row['SPECIE_FLAG']:'';
			isset($row['MUMMTAG'])?$tmp_specimen_data['mummtag'] =  $row['MUMMTAG']:'';
			isset($row['MUMMTAGSERIE'])?$tmp_specimen_data['mummtagserie'] =  $row['MUMMTAGSERIE']:'';
			isset($row['RBINS_TAG'])?$tmp_specimen_data['Rbins_flag'] =  $row['RBINS_TAG']:'';
			isset($row['SCN_NUMBER'])?$tmp_specimen_data['nbr_specimens'] =  $row['SCN_NUMBER']:'';
			isset($row['SEX'])?$tmp_specimen_data['Sex'] =  $row['SEX']:'';
			isset($row['TRIVIAL_NAME'])?$tmp_specimen_data['specie_flow'] =  $row['TRIVIAL_NAME']:'';
			isset($row['LENGTH'])?$tmp_specimen_data['Length'] =  $row['LENGTH']:'';
			isset($row['WEIGHT'])?$tmp_specimen_data['Weight'] =  $row['WEIGHT']:'';
			isset($row['BLUBBER_THICKNESS'])?$tmp_specimen_data['Blubber_thickness'] =  $row['BLUBBER_THICKNESS']:'';
			isset($row['CAUSE_OF_DEATH'])?$tmp_specimen_data['cause_of_death_flow'] =  $row['CAUSE_OF_DEATH']:'';
			
			
			$_POST['specimen_data'][] = json_encode($tmp_specimen_data);
			$this->addPost('specimen_data');
		}
	}
	
}

	if($val->getStatus()) {$this->navigate(); return;}


?>
<form class='<?php echo $this->flowname.'_form';?> default_form'>
<div id = "multiselect_specimen" class = "ui-widget multiselect_all" >
<div class ="ui-widget-content">
<ul class="selected connected-list ui-sortable boxlist">
<input name='specimen_data[]' style='display:none;'/>
<input name = 'seqno_specimen' style='display:none;'/>
<?php 
$specimen_data = $val->getValue('specimen_data');

	$i=1;
	foreach($specimen_data as $spec_data)
	{
		if(strlen($spec_data)!=0)
		{
			$specimen = json_decode($spec_data,true);
		    // If the specimen has been successfuly loaded, then add a property to the specimen array
		    
			if(in_array($i-1,$inserted_specimens)){$specimen['seqno'] = current(array_keys($inserted_specimens,$i-1));}
		
			$spec_data = json_encode($specimen);
			
			$color_item_class = $i%2==1?'items_even':'items_odd';
			$li_html = '<li title="' . $specimen['specie_flow'] . '" class="' . $color_item_class . ' ui-multiselect-default ui-element ui-state-temp" style="display: list-item;">';
			$li_html .= '<input name="specimen_data[]" value= \''. $spec_data .'\' style="display:none;"/> ';
			$li_html .= '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
			$li_html .= '<span class ="number element">' . $specimen['nbr_specimens'] . '</span>'; 
			$li_html .= '<span class ="element_specie element">' . $specimen['specie_flow'] . '</span>';
			$li_html .= '<span class="element">'. $specimen['Sex'].'</span>';
			if($specimen['mummtag']!=''){ $li_html .= '<span class="element">M.T.: '. $specimen['mummtag'].'</span>';}
			if($specimen['mummtagserie']!=''){$li_html .= '<span class="element">M.T.S.: '. $specimen['mummtagserie'].'</span>';}
			if($specimen['Length']!=''){$li_html .= '<span class="element">Length: '. $specimen['Length'].' m</span>';}
			if($specimen['Weigth']!=''){$li_html .= '<span class="element">Weight: '. $specimen['Weigth'].' Kg</span>';}
			if($specimen['Blubber_thickness']!=''){$li_html .= '<span class="element">B.T.: '. $specimen['Blubber_thickness'].' mm</span>';}
			if($specimen['cause_of_death_flow']!='' && $specimen['cause_of_death_flow']  != null){
			$li_html .= '<span class="element">Cause of Death : '. $specimen['cause_of_death_flow'].'</span>';}
			$li_html .= '<a class="drop" title="drop" href="#"><div style="color:#3383BB;"><span class="drop_spec">Delete</div></span></a> ';
			$li_html .= '<a class="edit " title = "edit" href="#"><div style="color:#3383BB;"><span class="edit_spec">Edit</div></span></a></li>';
			echo $li_html;

			
		}
		$i++;
	}


?>
</ul>
</div>
</div>
<div id = "biota" class="ui-widget" >
<fieldset id="specimen_fs">
<legend>Specimens</legend>
<div>
<div class="qfrow">
<div class="qfelement">
<label for="Specie-0" class="qflabel"><span class="required">*</span>Specie</label>
<select  id="Specie-0" class="specimen_attribute" name = 'specie_flow'><?php echo $taxaoptions;?></select>
</div> 
</div>
<div class="qfrow">
<div class="qfelement">
<label for="Specie_flag" class="qflabel"><span class="required">*</span>Specie flag </label>
<select  id="Specie_flag" class="specimen_attribute" name='specie_flag'><?php echo $specie_flag;?> </select>
</div>
</div>
<div class="qfrow">
<div class="qfelement">
<label for="Sex" class="qflabel">Sex </label>
<select  id="Sex" class="specimen_attribute" name='Sex'><?php echo $sex_options_flow;?></select></div>
</div>
<div class="qfrow">
<div class="qfelement twodiv">
<label for="nbr_specimens" class="qflabel">Number </label>
<select  id="nbr_specimens" name ="nbr_specimens" class="specimen_attribute"><?php echo $number_options;?></select></div>
</div>
<fieldset id="parameter_fs">
<legend>Parameters</legend>

<div class="qfrow">
<div class="qfelement">
<label for="Length" class="qflabel">Length(m) </label> 
<input type="text" id="Length" class="specimen_attribute" name="Length" />
</div>
</div>

<div class="qfrow">
<div class="qfelement">
<label for="Weigth" class="qflabel">Weigth(kg) </label> 
<input type="text" id="Weigth" class="specimen_attribute" name="Weigth" />
</div>
</div>

<div class="qfrow">
<div class="qfelement">
<label for="Rbins_tag" class="qflabel">Rbins Tag </label>
<input type="text" id="Rbins_tag"  class="specimen_attribute" name="Rbins_flag" /></div>
<div class="qfelement">
<label for="mummtag" class="qflabel">Mumm Tag </label>
<input type="text" id="mummtag" class="specimen_attribute" name="mummtag" /></div>
<div class="qfelement">
<label for="mummtagserie" class="qflabel">Mumm Tag Serie </label>
<input type="text" id="mummtagserie" class="specimen_attribute" name="mummtagserie" /></div>
</div>


<div class="qfrow">
<div class="qfelement">
<label for="Cause_of_Death_observation" class="qflabel">Cause of Death </label> 
<select  id="Cause_of_Death_observation" class="specimen_attribute" name='cause_of_death_flow'> <?php echo $cause_of_death;?></select>
</div>
</div>
</fieldset>
<div>
<button id = "addspecimen" title = "Add Specimen"  type="button"></button>
<button id = "confirm_update" title = "Confirm Update" style="display:none;"></button>
</div>
</fieldset>
<!-- end ui widget content-->
</div> 
<?php  
/**
 *   Previously Observed  
 */
?>
<fieldset id='previously_observed'>
<legend>Previously Observed</legend>
<div id = 'search_specimens'>
<div class = 'specimens_results'>
<?php 
// Need to make use of an absolute path => always valid ( ajax & web requests ) 

include(Web.'functions/specimens_search.php');

?>
</div>
<div class = "Search_search_tool" style="display:none;"> 
		<div class = "Search">
		<span>
			<div class = "Search_Box" style = "display:none">
				<div class="delSearch_Box"><a href=""><span class="ui_icon"></span></a></div>
				<div class = "filters"><p>Filter</p><select></select></div>
				<div class = "tokens"><p>Token</p><select></select></div>
				<div class = "fields"><p>Field</p><select></select></div>
				<div class = "fields" style="display:none"><p>Field</p><input ></input></div>
			</div><!--end search_box_upd-->
			<div class = "Search_Box" >
				<div class="delSearch_Box"><a href=""><span class="ui_icon"></span></a></div>
				<div class = "filters"><p>Filter</p><select></select></div>
				<div class = "tokens"><p>Token</p><select></select></div>
				<div class = "fields"><p>Field</p><select></select></div>
				<div class = "fields" style="display:none"><p>Field</p><input></input></div>
			</div><!--end search_box_upd-->
		</span>
		</div><!--end of Search-->
	<div class = "search_tool">
			<a class="addSearch_Box" href = "" ><span class ="add" title = "Add filter"></span></a>
			<a class="Search_for" href = "" ><span class ="search" title="search for filtered specimens"></span></a>
		</div><!-- end search tool-->
</div><!-- end Search_search tool-->
</div>
<div class='specimens_observed'>
<?php
$specimen_observed = $val->getValue('observed_specimen');
if(is_array($specimen_observed))
{
foreach($specimen_observed as $observed)
{
	if(strlen($observed)!=0)
	{
		echo "<div><a value='$observed' href=''>$observed</a></div>";
	}
}
}
?>
<input name='observed_specimen[]' style='display:none;'/>
</div>
<div class='errormessage'><?php  echo $val->getError('globalerror');?></div>
</fieldset>
<?php 
echo $this->getButtons().'</form>';

// unset posted items

//unset($_POST['specimen_data']);
			


