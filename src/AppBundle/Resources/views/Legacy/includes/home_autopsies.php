<?php
/**
 *   Include File
 *   Release Observations Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/home_partners.css" />',
						'<link rel="stylesheet" type="text/css" href="/legacy/css/autopsy_import/autopsy_samples.css" />',
						'<script type="text/javascript" src="/legacy/js/autopsy_import/autopsy_samples.js"></script>',
						'<script type="text/javascript" src="/legacy/js/home_partners.js"></script>',
						));
						
$necropsy_seqno = '3799';

 $db = $Layout->getDatabase();

$file_load = !file_exists('loadorganslesions.php')?'functions/loadorganslesions.php':'loadorganslesions.php';


//----------------------------------------------------------------------------------
// get Specimen ID 
$sql = "select scn_seqno from spec2events where ese_seqno = $necropsy_seqno";
$res = $db->query($sql);
if($res->isError()){$val->setError('globalerror',$res->errormessage());}
$row = $res->fetch();
$specimenlink = $row == false?'init':$row['SCN_SEQNO']; 

$var = $specimenlink; // variable declared in the include file
include(WebFunctions.'autopsy_specimen_link.php');
// get Conservation mode
$conservation_mode = array();
$sql = "select rv_low_value,rv_meaning from cg_ref_codes where rv_domain='CONSERVATION_MODE'";
$res = $db->query($sql);
if($res->isError()){ echo $res->errormessage();}
while($row = $res->fetch())
{
	$conservation_mode[$row['RV_LOW_VALUE']] = $row['RV_MEANING'];
}
// get Analyze_dest 
$analyze_dest = array();

$default_conservation_mode = array();

$sql ="select rv_low_value,rv_meaning,rv_high_value from cg_ref_codes where rv_domain='ANALYZE_DEST'";	

$res = $db->query($sql);

if($res->isError()){ echo $res->errormessage();}

while($row = $res->fetch())
{
	$analyze_dest[$row['RV_LOW_VALUE']] = $row['RV_MEANING'];
	$default_conservation_mode[$row['RV_LOW_VALUE']] = $row['RV_HIGH_VALUE'];
}
?>
<form class='default_form' action='#'>
<fieldset id="diagnosis_fs">
<legend>Samples</legend>
<table class='tab_output samples' width="100%" border="1">
<thead>
<tr class='conservation_mode'>
<th>Conservation Mode</th>
<?php foreach($analyze_dest as $key =>$value):?>
<th>
<select class='conservation_mode <?php echo $key;?>'>
<?php foreach($conservation_mode as $cons_key => $cons_val)
{
	$selected = $default_conservation_mode[$key] == $cons_key?"selected='selected'":'';
	
	echo "<option $selected value='$cons_key'>$cons_key</option>";
}
?>
</select>
</th>
<?php endforeach;?>
<th rowspan="2"></th>
</tr>
<tr class='analyze_dest'>
<th>Organ</th>
<?php foreach($analyze_dest as $key =>$value):?>
<th><?php echo $key;?></th>
<?php endforeach;?>
</tr>
</thead>
<tfoot>
 <tr>
 <td colspan="<?php echo count($analyze_dest)+2;?>"><button type="button" class="addsample">Add Sample</button></td>
 </tr>
 </tfoot>
<tbody>
<tr style="display:none;" class='initbodyrow'>
<td class='organ_select'><?php $lesion_var = 'ROOT';include($file_load);unset($lesion_var);?></td>
<?php for($i=0;$i<count($analyze_dest);$i++):?><td><input type='checkbox'/></td><?php endfor;?>
 <td><button class="delsample" type="button"><img alt="Del" src="/legacy/img/cross.png"/></button></td>
</tr>
<?php 
// get organs
$sql = "select code,name from organs where ogn_code= :ROOT";
$bind = array(':ROOT'=>'ROOT');
$res = $db->query($sql,$bind);
if($res->isError()){$val->setError('globalerror',$res->errormessage());}
while($row = $res->fetch()):
?>
<tr>
<td class='organ_select'><?php $lesion_var = $row['CODE']; include($file_load); unset($lesion_var);?></td>
<?php for($i=0;$i<count($analyze_dest);$i++):?><td><input type='checkbox'/></td><?php endfor;?>
<td><button class="delsample" type="button"><img alt="Del" src="/legacy/img/cross.png"/></button></td>
</tr>
<?php endwhile;?>
</tbody>
</table>
</fieldset>
</form>

<?php
$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>