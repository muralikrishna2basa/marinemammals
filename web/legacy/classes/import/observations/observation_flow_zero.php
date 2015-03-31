<?php
/**
 * 	Observation importation tool v1.0.0
 *  Create or Update existing observation screen
 *  
 * 
 * 
 */

include_once(Classes.'import/flow_class.php');


$css = "css/observation_flow_zero.css";

$js = "js/observation_flow_zero.js";

/**
 *   Specimens
 * 
 */
$val = $this->validation;


$db = $this->db;

if($val->getStatus() == false)
{ 
	if($val->getValue('thread')!='' && $val->getValue('thread')!='init')
	{
		// check that the corresponding item is an observation 
		$sql = "select count(*) as num_observations from observations where ese_seqno = :ese_seqno";
		$bind = array(':ese_seqno'=>$val->getValue('thread'));
		$res = $db->query($sql,$bind);
		if($res->isError()){$val->setError('globalerror',$res->errormessage());}
		else 
		{
			$row = $res->fetch();
			
			if($row['NUM_OBSERVATIONS'] == '1')
			{
				$this->thread = $val->getValue('thread');
				
			}
		}
		$val->setStatus(true);
	}
	elseif($val->getValue('thread')=='init')
	{
		$val->setStatus(true);
		$this->InitThread();
	}
	
	if($val->getStatus()){$this->navigate(); return;}
} // In case the insert or update functionality worked =>navigate 
?>
<form class='<?php echo $this->flowname.'_form default_form';?>'>
<input style='display:none;' class='thread' name='thread' value='init'/>
<fieldset id='create_observation'>
<legend>Create a new event</legend>
<?php echo $this->getInitButton();?>
</fieldset>
<fieldset id='search_for_observation'>
<legend>Select an event to update</legend>
<div id = 'search_observations'>
<div class = 'observations_results'>
<?php 
// Need to make use of an absolute path => always valid ( ajax & web requests ) 

include(Web.'functions/observations_search.php');
?>
</div>
<div class = "Search_search_tool" style="display:none;"> 
		<div class = "Search">
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
		</div><!--end of Search-->
	<div class = "search_tool">
			<a class="addSearch_Box" href = "" ><span class ="add" title = "Add filter"></span></a>
			<a class="Search_for" href = "" ><span class ="search" title="search for filtered Observations"></span></a>
		</div><!-- end search tool-->
</div><!-- end Search_search tool-->
</div>
</fieldset>
<?php echo $this->getButtons();?>
</form>


