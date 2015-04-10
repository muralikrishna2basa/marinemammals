<?php
/**
 *   Include File
 *   Search Samples Biobank Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */


/*
Temporary hack, 
Disable the cross-page navigation with Biobank. This is set because otherwise it provides 
a weird bug in the display( element hidden) of the button confirming the order
It seems independent from the client scripting i.e $Layout->cleanHeader('.js'); doesn't affect the fact that the button isn't displayed,
and also if javascript is disabled in the browser.
Also, if both classname and name of input are different from order_samples than it display correctly. 
If the content is set out of the layout then it displays correctly. 
*/
//unset($_SESSION['navigation']['/Biobank.php']);
/*
Unhacked. Reason, the content was server side hided at init point.
The hidding process include the id of the content div or this id was exactely the same as the button name or button class
It previously replaced all occurences with an adding term style="display:none"....
This has been corrected to only replace the first occurence. 
*/

//$Layout->cleanHead();
require_once(Classes.'export/Export_interface.php');

if(isset($_GET['clean_samples']) == true && $_GET['clean_samples'] == 'clean')
{
	unset($_SESSION['samples']);
}

if(isset($_POST['gobackend']) == true && is_string($_POST['gobackend']) == true && $_POST['gobackend'] == 'gobackend')
{
	unset($_SESSION['samples']);
}

$order_samples = <<<EOD
<div id = "order_div">
<form>
<button value="order" class="order_samples" name="order_samples" type="submit">Confirm Order</button>
<button value="clean" class="clean_samples" name="clean_samples" type="submit">Clean Selection</button>
<button value="add" class="add_samples" name="add_samples" type="submit">Update Basket</button>
</form>
</div>
EOD;

ob_start();
?>
<div id = "search_samples">
<div class = "samples_results"><?php include(WebFunctions.'/perform_search.php');?></div>
<?php
echo $order_samples;
/*if($Layout->getAuth()->getSessionGroupname()!='GUEST')
{
	
	echo $order_samples;
		
}*/
?>
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


/*if($Layout->getAuth()->getSessionGroupname()!='GUEST')
{
	
	include(Web.'functions/export_samples.php');
		
}*/

include(WebFunctions.'/export_samples.php');



$tmp = ob_get_contents();

ob_end_clean();
return $tmp;
?>
