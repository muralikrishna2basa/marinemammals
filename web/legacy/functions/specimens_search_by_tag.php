<?php
/**
 *  When ajax loading, => the relative path start on the ajax called directory
 */
if(!isset($db) || !isset($auth))
{
    require_once(dirname($_SERVER['DOCUMENT_ROOT']) . '/directory.inc');

    include_once(Functions . 'getAuthDb.php');

    include_once(Classes . "search/searcher_class.php");
}
include_once(Classes.'record/db_record_class.php');
include_once(Classes . "search/searcher_class.php");
// GET THE DATA FROM THE AJAX CALL 

if(isset($_POST['specimenTagLink'])){ $specimenTagLink = $_POST['specimenTagLink'];} else {$specimenTagLink = ""; }

$samples = new Search_Specimen($db);
$samples->FilterbyName('Filter_Specimen_Collection_Tag','=',$specimenTagLink);

$id=$samples->getIdentifiers(array("NECROPSY_TAG"=>$specimenTagLink));
if($id !=false){
    echo new Specimen_record($db,$id);
}
?>