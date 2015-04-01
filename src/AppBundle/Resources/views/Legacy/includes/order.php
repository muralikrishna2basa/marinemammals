<?php
/**
 *   Include File
 *   Order Admin Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/Order.css" />',
						'<script type="text/javascript" src="/legacy/js/order.js"></script>'));

include_once(Classes."order/Order_class.php");						
						
?>

<div id = "search_order">
<div class = "search_results"><?php include(Web.'functions/order_search.php');?></div>
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
				<a class="Search_for" href = "" ><span class ="search" title="search for filtered samples"></span></a>
				<a class="addSearch_Box" href = "" ><span class ="add" title = "Add filter"></span></a>
		
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
			<a class="Search_for" href = "" ><span class ="search" title="search for filtered Orders"></span></a>
			<a class="addSearch_Box" href = "" ><span class ="add" title = "Add filter"></span></a>
			
		</div><!-- end search tool-->
</div><!-- end Search_search tool-->
</div>

<?php

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>