<?php
/**
 *    Function perform_search.php v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *                  12/01/2010
 *
 *  Details:
 * ---------
 * Search in the database and render the results
 * method get for the ajax call,
 * Searcher dependent, because one might add or remove columns
 *
 * When ajax loading, => the relative path start on the ajax called directory
 *
 * A method to retrieve Seqno_Samples from json encoded array
 * $a = array('{"Seqno":112}','{"Seqno":113}','{"Seqno":114}');
 * $b = array();
 * foreach($a as $item){ $b[]= json_decode($item)->Seqno;}
 *
 */
if (!isset($db) || !isset($auth)) {
    require_once(dirname($_SERVER['DOCUMENT_ROOT']) . '/directory.inc');

    include_once(Functions . 'getAuthDb.php');

    include_once(Classes . "search/searcher_class.php");
}
/* CREATE A SAMPLE OBJECT */
include_once(Classes . "search/searcher_class.php");
//$samples = new Search_Samples($db,$auth->getSessionGrouplevel());
$samples = new Search_Samples($db);

/* GET THE DATA FROM THE AJAX CALL */

if (isset($_GET['search_json'])) {
    $search_json = $_GET['search_json'];
} else {
    $search_json = false;
}


if (isset($_GET['search_page'])) {
    $search_page = $_GET['search_page'];
} else {
    $search_page = 1;
}


if (isset($_GET['search_ppr']) && $_GET['search_ppr'] != 'undefined') {
    $samples->renderer->pager->rows_per_page = $_GET['search_ppr'];
} else {
    $samples->renderer->pager->rows_per_page = 10;
}

if ($search_json != false) {
    $searchitems = json_decode(stripcslashes($search_json));

    if ($searchitems instanceof stdClass) {
        foreach ($searchitems as $searchitem) {
            if ($searchitem != 'dum') {
                $operator = htmlentities($searchitem->operator, ENT_QUOTES, 'UTF-8');
                $samples->FilterbyName($searchitem->filter, $operator, fixDecoding($searchitem->field));
            }
        }
    }
}
/* CUSTOMIZE THE SEARCH */

$samples->FilterbyName('Date Found', '#'); // so that the column Found Date is available
$samples->FilterbyName('Taxa', '#'); // so that the column specimen is available
$samples->FilterbyName('Organ', '#'); // so that the column specimen is available
//$samples->FilterbyName('Country','#'); // so that the column specimen is available

$samples->renderer->addColumn('Date Found'); // render the corresponding column

$samples->renderer->addColumn('Taxa'); // render the corresponding column

$samples->renderer->addColumn('Organ'); // render the corresponding column

//$samples->renderer->addColumn('Country'); // render the corresponding column

$samples->renderer->RemoveColumn('Sample Type');

//if($auth->getSessionGroupname()!='GUEST')
//{
$samples->renderer->addColumn(array('<input type="checkbox" checked ="checked" class="sample_select"/>' => '<input type="checkbox" class="sample_select"/>'));
//}
/*else
{*/
$samples->renderer->RemoveColumn('Availability');
//}


$samples->renderer->RemoveColumn('Seqno');

if (isset($_GET['check']) && is_string($_GET['check']) && strlen($_GET['check']) > 0) {
    $check = explode(',', stripslashes($_GET['check']));
} else {
    $check = array();
}

if (isset($_GET['uncheck']) && is_string($_GET['uncheck']) && strlen($_GET['uncheck']) > 0) {
    $uncheck = explode(',', stripslashes($_GET['uncheck']));
} else {
    $uncheck = array();
}


//echo get_magic_quotes_gpc ();
//echo 'register_globals = ' . ini_get('register_globals') . "\n";

//session_start();
if (isset($_SESSION['samples']) == true && is_array($_SESSION['samples']) == true) {
    $samples_tmp = $_SESSION['samples'];

    foreach ($check as $item) {
        if (!in_array($item, $samples_tmp)) {
            $samples_tmp[] = $item;
        }
    }

    $samples_tmp = array_diff($samples_tmp, $uncheck);

    $_SESSION['samples'] = $samples_tmp;
} else {
    if (count($check) > 0) {
        $_SESSION['samples'] = $check;
    }
}

//$samples->renderer->check = $_SESSION['samples']; //todo check


/**
 * this function is aimed at using the renderer class, and add conditions to be rendered
 * closely related with the column definition
 *
 */
function checkpk($samples)
{
    $check = $samples->check;
    if (is_array($check) && in_array($samples->fullpk, $check) == true) {
        return 'key';
    } else {
        return 'value';
    }
}

$samples->renderer->addFunctionColumn('<input type="checkbox" class="sample_select"/>', "checkpk");


function availability_tr($cell)
{
    if ($cell == 'yes') {
        return '<img width="20" height="20" align="center" src="/img/green.png"/>';
    } elseif ($cell == 'no') {
        return '<img width="20" height="20" align="center" src="/img/red.png"/>';
    } else {
        return $cell;
    }
}

$samples->renderer->addCellFunction('Availability', 'availability_tr');

if (isset($_GET['search_sort']) && isset($_GET['sort_type'])) {
    $samples->addOrder($_GET['search_sort'], $_GET['sort_type']);

}


//if ($auth->getSessionGrouplevel() == 0) {
// do nothing
/*} else*/
if (isset($_SESSION['samples']) && count($_SESSION['samples']) > 0) {
    $countsamples = count($_SESSION['samples']);
    $samples->renderer->addFooter("<span class='samplesselected'><b><p style=margin-top:7px>$countsamples samples selected</p></b></span>");
} else {
    $samples->renderer->addFooter("<span class='samplesnotselected'><b><p style=margin-top:7px> no samples selected</p></b></span>");
}

$samples->renderer->setCurrentPage($search_page);

//$samples->renderer->columns = array('Seqno','Availability');

$samples->renderer->sortColumns(array('Seqno', 'Taxa', 'Organ', 'Conservation Mode', 'Intended Use', 'Date Found', 'Country', 'Availability'));

echo $samples;

// store the resulting query 
$bindings = $samples->query->bindings;
unset($bindings[':end_row']);
unset($bindings[':start_row']);

$_SESSION['perform_query'] = array($samples->query->sqlquery, $bindings);

?>