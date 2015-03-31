<?php
/**
 *   Include File   
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:06/01/2010
 */
ob_start();

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="css/Order.css" />',
						'<link rel="stylesheet" type="text/css" href="css/search.css" />',
						'<script type="text/javascript" src="js/search_plugin.js"></script>',
						'<script type="text/javascript" src="js/order_user_search.js"></script>'));

include_once(Classes."order/Order_class.php");	


$db = $Layout->getDatabase();

$id = $auth->getSessionId();

$sql = "select count(*) as num_req from person2requests where psn_seqno = :id";
$bind = array(':id'=>$id);
$res = $db->query($sql,$bind);
if($db->isError()){ $Layout->errormessage = 'problem retrieving request for your account';}
$row = $res->fetch();
if($row['NUM_REQ'] == 0)
{
	echo "This is the place where you'll be able to look at your requests";
}
else 
{
	$rchr = '<div id = "search_order">';
	ob_start();
	include(Web.'functions/order_user_search.php');
	$test = ob_get_contents();
	ob_end_clean();
	$rchr .= '<div class = "search_results">'.$test.'</div>';
	
	echo "<span>By clicking on column header of the table you can sort your samples request. <br>
	 By clicking on table line, you will obtain details of your corresponding tissue request.
</span>";
	echo $rchr;
}
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
			<a class="addSearch_Box" href = "" ><span class ="add" title = "Add filter"></span></a>
			<a class="Search_for" href = "" ><span class ="search" title="search for filtered samples"></span></a>
		</div><!-- end search tool-->
</div><!-- end Search_search tool-->
</div>


<div id = "detail_orders">
<div class ="detail_orders_results"></div>
<div class = "Search_search_tool" style="display:none;"> 
		<div class = "Search">
			<div class = "Search_Box" style = "display:none">
				<div class="delSearch_Box"><a href=""><span class="ui_icon"></span></a></div>
				<div class = "filters"><p>Filter</p><select></select></div>
				<div class = "tokens"><p>Token</p><select></select></div>
				<div class = "fields"><p>Field</p><select></select></div>
				<div class = "fields" style="display:none"><p>Field</p><input ></input></div>
			</div><!--end search_box_upd-->
		<div class ="clearleft"></div>
		</div><!--end of Search-->
	<div class = "search_tool">
			<a class="addSearch_Box" href = "" ><span class ="add" title = "Add filter"></span></a>
			<a class="Search_for" href = "" ><span class ="search" title="search for filtered Orders"></span></a>
		</div><!-- end search tool-->
</div><!-- end Search_search tool-->
</div>
<?php
$tmp = ob_get_contents();ob_end_clean();
return $tmp;
?>