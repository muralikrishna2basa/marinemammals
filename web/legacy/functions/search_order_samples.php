<?php
/**
 *  When ajax loading, => the relative path start on the ajax called directory
 */
if (!isset($db) || !isset($auth)) {
    require_once(dirname($_SERVER['DOCUMENT_ROOT']) . '/directory.inc'); /* Make use of absolute path */

    /**
     *   Search in the database and render the results
     *   method get for the ajax call,
     *   Searcher dependent, because one might add or remove columns
     */
    include_once(dirname($_SERVER['DOCUMENT_ROOT']) . '/directory.inc'); /* Make use of absolute path */

    include_once(Functions . 'getAuthDb.php');

    include_once(Classes . "search/searcher_class.php");

    session_start();
    if (isset($_SESSION['samples'])) {
        if (is_array($_SESSION['samples']) != true || count($_SESSION['samples']) == 0) {
            return false;
        }
    }


}
// GET THE DATA FROM THE AJAX CALL 

if (isset($_GET['search_json'])) {
    $search_json = $_GET['search_json'];
}
if (isset($_GET['search_sort'])) {
    $addorder = $_GET['search_sort'];
}
if (isset($_GET['search_page'])) {
    $search_page = $_GET['search_page'];
} else {
    $search_page = 1;
}


$samples = new Search_Samples($db);

if (isset($_GET['search_ppr']) && $_GET['search_ppr'] != 'undefined') {
    $samples->renderer->pager->rows_per_page = $_GET['search_ppr'];
}

if (isset($_SESSION['samples'])) {
    $samples_tmp = $_SESSION['samples'];
}
$samples_seqno = array();


foreach ($samples_tmp as $item) {
    $samples_tmp = json_decode(stripslashes($item))->Seqno;
    if ($samples_tmp != null) {
        $samples_seqno[] = $samples_tmp;
    }
}

$samples->addFilter(array('Filter_Sample_Seqno')); // so that the filter with name id is ready to be used 

$samples->FilterbyName('ID', 'in', $samples_seqno);
$samples->FilterbyName('specimen', '!=', 'infinity'); // so that the column specimen is available uh problem
$samples->FilterbyName('organ', '!=', 'infinity'); // so that the column specimen is available
$samples->renderer->addColumn('Taxa'); // render the corresponding column
$samples->renderer->addColumn('Organs'); // render the corresponding column
$samples->renderer->RemoveColumn('Sample Type');

if (isset($_GET['search_sort']) && isset($_GET['sort_type'])) {
    $samples->addOrder($_GET['search_sort'], $_GET['sort_type']);

}

//$samples->renderer->hidefooter = true;
$samples->renderer->setCurrentPage($search_page);

echo $samples;



?>