<?php 


require_once('../../directory.inc');

include_once(Functions.'getAuthDb.php');
	
include_once(Classes."search/searcher_class.php");

$grouplevel = $auth->getSessionGrouplevel();

if(isset($_GET['search_json'])){ $search_json = $_GET['search_json'];} 
if(isset($_GET['search_sort'])){ $addorder = $_GET['search_sort'];}
if(isset($_GET['search_page'])){ $search_page = $_GET['search_page'];} else {$search_page = 1;}

$searchitems = json_decode(stripcslashes($search_json));


$samples = new Search_Samples($db,$grouplevel);

if(isset($_GET['search_ppr']) && $_GET['search_ppr']!='undefined' )
{
$samples->renderer->pager->rows_per_page = $_GET['search_ppr'];
} 

// The filter is first added so that the filterbyname won't give an error
$samples->addFilter(array('Filter_Sample_Request_Loans_Seqno'));

$countfilters = 0;
if($searchitems instanceof stdClass)
{
foreach($searchitems as $searchitem)
{
	if($searchitem != 'dum')
	{
	$operator = htmlentities($searchitem->operator, ENT_QUOTES, 'UTF-8');
	$samples->FilterbyName($searchitem->filter,$operator,fixDecoding($searchitem->field));	
	
	$countfilters +=1;
	}
}
}
if($countfilters == 0) { return false; } // so that it doesnt search for samples not linked with the order

$samples->FilterbyName('specimen','#'); // so that the column specimen is available uh problem
$samples->FilterbyName('organ','#'); // so that the column specimen is available
$samples->renderer->addColumn('Taxa'); // render the corresponding column
$samples->renderer->addColumn('Organs'); // render the corresponding column

//$samples->FilterbyName('Loan Seqno','=',$loan->Seqno);
$samples->FilterbyName('autopsy_reference','#'); // so that the column autopsy is available
$samples->renderer->addColumn('Ref_aut'); // render the corresponding column

$samples->renderer->hidesearch = true;

if(isset($_GET['search_sort']) && isset($_GET['sort_type'])) 
{ 
	$samples->addOrder($_GET['search_sort'],$_GET['sort_type']);
	$search_page = 1;
}


function availability_tr($cell)
{
	if($cell == 'yes'){ return '<img width="20" height="20" align="center" alt="yes" src="/img/green.png"/>'; }
	elseif($cell == 'no'){return '<img width="20" height="20" align="center" alt="no" src="/img/red.png"/>';}
	else { return $cell;}
}

$samples->renderer->addCellFunction('Availability','availability_tr');

$samples->renderer->build($search_page);

echo "<div class ='samples_order'>";
echo $samples->renderer->table;
echo "</div>";

// LOCATIONS DISPLAY FOR EVERY SAMPLES FROM THE ORDER  

echo "<div class ='locations'>";
foreach($samples->renderer->res as $result)
{
$seqno = $result['Seqno'];
	
// allow the user to paginate any data's from database
$sql = "select container_type,name from (select connect_by_root b.seqno as id_init,container_type,name
					from container_localizations b
					where name !='ROOT'
					connect by nocycle b.seqno = prior b.cln_seqno
					start with b.seqno in  ( select cln_seqno from samples where seqno = '$seqno'))";
$r = $db->query($sql);
$row = $r->fetch();
$test_location = new BLP_Search($db,false,array_keys($row),'tab_output',array('SEQNO'));
$test_location->query->columns = array_combine(array_keys($row),array_keys($row)); 
$test_location->query->sqlquery = $sql;
$test_location->renderer->hidefooter = true;
$test_location->renderer->build();
echo "<div pk='{\"Seqno\":$seqno}' style='display:none'>";
echo $test_location->renderer->table;
echo '</div>';
}
echo "</div>";



if(isset($_GET['confirm'])) 
{ 

$confirm = json_decode($_GET['confirm']);

$order = New Order($db,$confirm->seqno);	

//$order->ConfirmOrder(); not set debugging purpose

}

if(isset($_GET['deny'])) 
{
$deny = json_decode($_GET['deny']);
$order = New Order($db,$deny->seqno);		

$order->DenyOrder();

}


?>


