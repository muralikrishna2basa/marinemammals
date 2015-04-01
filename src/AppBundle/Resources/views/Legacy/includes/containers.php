<?php
/**
 *   Include File
 *   Containes Admin Menu
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();
?>

<?php
/**
 * 	Manage the library containers 
 * 
 * 
 * 
 * 
 */

$Layout->addHead(array('<link href="/legacy/css/container_localizations_tree.css" rel="stylesheet" type="text/css" />',
//							'<script type="text/javascript" src="/legacy/js/jquery.event.drag-1.5.js"></script>',
//							'<script type="text/javascript" src="/legacy/js/jquery.event.drop-1.2.js"></script>',
							'<script type="text/javascript" src="/legacy/js/container_localizations_tree.js"></script>'));

//<script type="text/javascript" src="/legacy/js/container_localizations_tree.js"></script>

include_once(Classes.'cms/Tree_class.php');

$db = $Layout->getDatabase();

if(isset($_POST['Add']))
{
	
	$seqno =$_POST['rootAdd'];
	
	$typeAdd = $_POST['type'];
	$typevalue = $_POST['valueadd'];
	
	$sql = "insert into container_localizations (container_type,name,cln_seqno) values (:typeAdd,:typevalue,:seqno)";
	$binds = array(':typeAdd'=>$typeAdd,':typevalue'=>$typevalue,':seqno'=>$seqno);
	$r = $db->query($sql,$binds);
	
	if($db->isError()){ $Layout->isError = true;$Layout->errormessage = $db->errormessage;}
	
}
if(isset($_POST['Updatevalue']))
{
	$updatedvalue =     $_POST["updatedvalue"];
	
	$seqno =	$_POST['rootupdatevalue'];
	
	
	$sql = "update container_localizations set name= :updatedvalue where seqno = :seqno";
	
	$binds = array(':updatedvalue'=>$updatedvalue,':seqno'=>$seqno);
	$r = $db->query($sql);
	if($db->isError()){ $Layout->isError = true;$Layout->errormessage = $db->errormessage;}
}
if(isset($_POST['Updateroot']))
{
	
	$cln_seqno = $_POST['rootupdateroot'];
	
	$seqno = $_POST['updateelement'];
	
	$sql = "update container_localizations set cln_seqno = :cln_seqno where seqno = :seqno";
	
	$binds = array(':cln_seqno'=>$cln_seqno,':seqno'=>$seqno);
	
	$r = $db->query($sql,$binds);
	if($db->isError()){ $Layout->isError = true;$Layout->errormessage = $db->errormessage;}
}
if(isset($_POST['Delete']))
{
	$seqno = $_POST['deleteelement'];
	
	
	
	if(is_string($seqno)==true)
	{
		// protection against a malformated $seqno value
		$sql = "select * from container_localizations where seqno = :seqno ";
		$bind = array(':seqno'=>$seqno);
		$r = $db->query($sql,$bind);
		
		if($r->isError()){$Layout->isError = true;$Layout->errormessage = $db->errormessage;}
		$results = $r->fetchAll();	
		
		if(count($results) == 1)
		{
		$sql = "delete from container_localizations where seqno = :seqno";
	
		$r = $db->query($sql,$bind);
		
		if($r->isError()){$Layout->isError = true;$Layout->errormessage = $db->errormessage;}
		}
	
	}
	

}


$sql = "select container_type, name,seqno, level from container_localizations 
connect by cln_seqno = prior seqno
start with seqno = 1
order siblings by name";



$results = $db->query($sql);

$test = $results->fetchAll();
$test[] = array(); // dummy row
$tree = new Tree_Container_Localizations();

$formatted = array_map( array( $tree,"treeMethod" ), $test );


$sql = "select distinct container_type from container_localizations where container_type !='ROOT'";

$r = $db->query($sql);

if($r->isError()){ $Layout->isError = true;$Layout->errormessage = $db->errormessage;}
$row = $r->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
$option = "<option>".implode("</option>\n<option>",$row['CONTAINER_TYPE'])."</option>";
	


?>

	<div id = "tree_container">
	<div class="inittree nodrop">
		<div class ="tree_toolbar">
			<button class="expand"   type="button" style="display:none;">Expand All</button>
			<button class="collapse" type="button" >Collapse All</button>
		</div>
		<?php echo implode( "\n", $formatted );?>
	</div>
	<div class="cmsform">
	<form class='cms' method="POST" action=<?php $_SERVER['PHP_SELF'];?>>
		<div class="row header"></div>
		<div class ="row">
			<div class="element">
				<label>Add Element</label>
			</div>
			<div class = "element">
				<select title="select" name="type"><?php echo $option ?></select>
			</div>
			<div class = "element">
				<input class="value" title="Set new value" name = "valueadd" type="text"></input> 
		    </div>
		    <div class = "element">
				<input title=" drop the root element" class="drop" name='rootAdd' style='width:50px;'></input>
			</div>
		
			<div class = "element">
				<button class="submit" name ="Add"><img alt='accept' src='/legacy/img/accept.png'></img></button>
			</div>
		</div>
		<div class ="row">
			<div class="element">
				<label>Update Value</label>
			</div>
			<div class ="element">
				<input name='rootupdatevalue' title="drop the element to update" class="drop" style='width:50px;'></input>
			</div>
			<div class ="element">
				<input class="value" title="Set new value" name ="updatedvalue" type="text"></input> 
			</div>
			<div class="element">
			</div>
			<div class ="element">
				<button class="submit" name ="Updatevalue"><img alt='accept' src='/legacy/img/accept.png'></img></button>
			</div>
		</div>
		<div class ="row">
					<div class="element">
				<label>Update Link</label>
			</div>
			<div class = "element">
				<input name='updateelement' title="drop the element for update" class="drop" style='width:50px;'></input>
			</div>
			<div class = "element">
				<input name='rootupdateroot' title="drop the new root element " class="drop"  style='width:50px;'></input>
			</div>
			<div class="element">
			</div>
			<div class = "element">
				<button class="submit" name ="Updateroot"><img alt='accept' src='/legacy/img/accept.png'></img></button>
			</div>
		</div>
		<div class ="row">
			<div class="element">
				<label>Delete</label>
			</div>
			<div class = "element">
				<input name='deleteelement' title="drop the element to delete" class="drop"   style='width:50px;'></input>
			</div>
			<div class="element">
			</div>
			<div class="element">
			</div>
			<div class = "element">
				<button class="submit" name ="Delete"><img  alt='accept' src='/legacy/img/accept.png'></img></button>
			</div>	
		</div>
		<div class="row">
				<div class ="errormessage"></div>
		</div>
		</form>
		</div>
		</div>

<?php

// Return buffer

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>