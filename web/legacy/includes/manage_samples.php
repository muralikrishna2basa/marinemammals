<?php
/**
 *   Include File
 *   Manage Samples Admin Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan 
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();
?>


<?php

$Layout->addHead(array('<script type="text/javascript" src="js/manage_samples.js"></script>',
					    '<link rel="stylesheet" type="text/css" href="css/manage_samples.css" />'));

$db = $Layout->getDatabase();

$person = new Person($db,$Layout->getAuth()->getSessionId());



/**
 * CMS SAMPLE
 */
$sample = new Sample($db,$Layout->getAuth()->getSessionId());
echo "<div class='manage_samples_form'>";
$sample->__toString();

echo "</div>";
if($sample->isError == true) { $Layout->isError = true;$Layout->errormessage = $sample->errormessage;}

/**
 *  TREE REPRESENTATION
 */

include_once(Classes.'cms/Tree_class.php');

$sql = "select container_type, name,seqno, level from container_localizations 
connect by cln_seqno = prior seqno
start with seqno = 1
order siblings by name";

$results = $db->query($sql);

$test = $results->fetchAll();
$test[] = array(); // dummy row
$tree = new Tree_Container_Localizations();

$formatted = array_map( array( $tree,"treeMethod" ), $test );

?>

<div class="inittree nodrop">
		<div class ="tree_toolbar">
			<button class="expand"   type="button" style="display:none;">Expand All</button>
			<button class="collapse" type="button" >Collapse All</button>
		</div>
		<?php echo implode( "\n", $formatted );?>
</div>


<div id = "search_samples"><div class = "samples_results"><?php include(Web.'functions/samples_search.php');?></div>
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
					<a class="Search_for" href = "" ><span class ="search" title="search for filtered samples"></span></a>
					<a class="addSearch_Box" href = "" ><span class ="add" title = "Add filter"></span></a>
	
		</div><!-- end search tool-->
</div><!-- end Search_search tool-->
</div>

<?php

$tmp = ob_get_contents();ob_end_clean();

return $tmp;

?>