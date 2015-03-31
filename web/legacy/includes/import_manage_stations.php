<?php

/**
 *   Observation Manage Stations
 *   Include File
 *  
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER : De Winter Johan
 *   LAST MODIFIED DATE:08/03/2010 
 */
ob_start();

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="css/import_manage_stations.css" />',
						'<script type="text/javascript" src="js/import_manage_stations.js"></script>',
						));
						
$db = $Layout->getDatabase();
?>
<fieldset id ="places_stations">
<legend>Stations</legend>
<fieldset id="obplaces">
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
			
			$html_places_stations .='<option value="'.$rsseqno.'">'.$rsname."</option>";
		
}
echo $html_places_stations;
?>
</select>
<select class="level1" name = "level1"></select>
<select class="level2" name = "level2"></select>
<select class="level3" name = "level3"></select>
</fieldset>
<fieldset id="station_detail">
<legend>Station</legend>
<div class="station_choice">
<select  name = "station"><option value="init">Choose</option></select>
</div>
<div class="station_items">
<div>
<label for="station_latitude" class ="label_station">Latitude</label>
<input id="station_latitude" name="station_latitude"/>
</div>
<div>
<label for= "station_longitude" class ="label_station">Longitude</label>
<input id="station_longitude" name="station_longitude"/>
</div>
<div>
<label for="station_code" class ="label_station">Code</label>
<input id ="station_code" name="station_code"/>
</div>
<div>
<label for= "station_description" class ="label_station">Description</label>
<input id ="station_description" name="station_description"/>
</div>
</div>
<div class = "hasstation">
<img width="20" height="20" align="center" style = "display:none;" class ="ok" src="img/green.png">
<img width="20" height="20" align="center" class ="nonok" src="img/red.png">
</div>
<div style="clear:both;"></div>
</fieldset>
<fieldset id="station_tool">
<legend>Tools</legend>
<select  title="select that item to either change or add an area type to the station above" class="area_type" name = "station_ot">
<?php
$sql = "select rv_low_value from cg_ref_codes where rv_domain = 'STN_AREA_TYPE'";
$res = $db->query($sql);
$results = $res->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
echo '<option value="init">Choose</option><option>'.implode("</option><option>",$results["RV_LOW_VALUE"])."</option>";
?>
</select>
<button class="add station_manage"    value="add"    type="submit" style="visibility:hidden;">Add</button>
<button class="update station_manage" value="update" type="submit" style="visibility:hidden;">Update</button>
<button class="delete station_manage" value="delete" type="submit" style="visibility:hidden;">Delete</button>
<div class="errormessage"></div>
</fieldset>
</fieldset>

<?php

// Output the buffer

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>