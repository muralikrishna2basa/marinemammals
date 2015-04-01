<?php
/**
 *   Include File
 *   Search Taxas Import Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:05/01/2010 
 */
ob_start();
require_once(Classes."arch/Form_class.php");
require_once(Classes."order/Table_class.php");
require_once(Classes."cms/Taxa_class.php");
$Layout->addHead(array('<script type="text/javascript" src="/legacy/js/import.js"></script>'));
?>

<div id = "search_taxas">
<div class = "taxas_results"><?php include(Web.'functions/taxas_search.php');?></div>
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
				<a class="Search_for" href = "" ><span class ="search" title="search for filtered taxas"></span></a>
				<a class="addSearch_Box" href = "" ><span class ="add" title = "Add filter"></span></a>
		
		</div><!-- end search tool-->
</div><!-- end Search_search tool-->
</div>

<?php

$taxas = new Taxa($db,$Layout->getAuth()->getSessionId());

$taxas->__toString();

if($taxas->isError == true) { $Layout->isError = true;$Layout->errormessage = $taxas->errormessage;}

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>