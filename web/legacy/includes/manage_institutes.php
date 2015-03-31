<?php
/**
 *   Include File
 *   Manage Institutes Admin Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();



$Layout->addHead(array('<script type="text/javascript" src="js/manage_institutes.js"></script>'));

$person = new Person($db,$Layout->getAuth()->getSessionId());
?>

<div id = "search_institutes">
<div class = "institutes_results"><?php include(Web.'functions/institutes_search.php');?></div>
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
						<a class="Search_for" href = "" ><span class ="search" title="search for filtered institutes"></span></a>
						<a class="addSearch_Box" href = "" ><span class ="add" title = "Add filter"></span></a>

		</div><!-- end search tool-->
</div><!-- end Search_search tool-->
</div>


<?php


$institute = new Institute($db,$Layout->getAuth()->getSessionId());

$institute->__toString();

$form = $institute->getForm();

if($institute->isError == true) 
{ 
 //	$Layout->isError = true;$Layout->errormessage = $institute->errormessage;
	echo "<span class='errormessage'>$institute->errormessage</span>";

}
elseif(isset($_POST['submit']) && $form->validate())
{
	echo "<span class='successmessage'>The informations have been successfully updated</span>";
}


//echo $institute uhhh doesn't work;

$tmp = ob_get_contents();ob_end_clean();
return $tmp;

?>