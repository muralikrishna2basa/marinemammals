<?php
/**
 *    Autopsy importation tool
 *  Specimen Screen
 *  VERSION:1.0.0
 *  AUTHOR:DE WINTER JOHAN
 *  CREATED:20/04/2010
 *  LAST MODIFIED:20/04/2010
 *  DESCRIPTION:
 *  Link the autopsy to a previously observed specimen
 */

include_once(Classes . 'import/flow_class.php');


include_once(Functions . 'Fixcoding.php');

$db = $this->db;

//  Set javascript & css files, to be loaded dynamically 
$css = "css/autopsy_import/autopsy_specimen_link.css";

$js = "js/autopsy_import/autopsy_specimen_link.js";

$val = $this->validation;
$necropsy_seqno = $this->getThread();

// get Specimen Id
if (!$necropsy_seqno) {
    $val->setError('globalerror', $this->FLOW_WARNING);
} else {
    $sql = "select scn_seqno from spec2events where ese_seqno = $necropsy_seqno";
    $res = $db->query($sql);
    if ($res->isError()) {
        $val->setError('globalerror', $res->errormessage());
    }
    $row = $res->fetch();
    $specimenlink = $row == false ? 'init' : $row['SCN_SEQNO'];


    if ($val->getStatus() == false) {
        $specimen_link = $val->getValue('specimenlink');

        if ($specimen_link == '') {
            $val->setStatus(false);
        } elseif ($specimen_link == 'init') // in case a navigate request has been issued, but no animals has been set up
        {
            $val->setError('globalerror', 'A specimen must be linked to the necropsy before proceeding');
        } elseif ($specimenlink == 'init') // no animals has previously been set-up but a animal has been linked
        {
            $sql = "insert into spec2events (scn_seqno,ese_seqno) values ('$specimen_link','$necropsy_seqno') ";
            $res = $db->query($sql);
            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage());
            } else {
                $val->setStatus(true);
            }
        } elseif ($specimen_link == $specimenlink) // in case nothing has to be done => navigate
        {
            $val->setStatus(true);
        } else // update spec2events accordingly
        {
            $sql = "select count(*) as num_specimens from specimens where seqno = :seqno";
            $bind = array(':seqno' => $specimen_link);
            $res = $db->query($sql, $bind);
            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage());
            } else {
                $row = $res->fetch();

                if ($row['NUM_SPECIMENS'] == '1') {
                    $sql = "update spec2events set scn_seqno = '$specimen_link' where ese_seqno = '$necropsy_seqno'";
                    $db->query($sql);
                    if ($db->isError()) {
                        $val->setError('globalerror', $db->errormessage());
                    } else {
                        $val->setStatus(true);
                    }
                }
            }
        }
        $this->addPost('flow');
        $this->addPost('search_tool');
        $this->addPost('specimenlink');
        if ($val->getStatus()) {
            $this->navigate();
            return;
        }
    } // In case the insert or update functionality worked =>navigate
}
?>
<form class='<?php echo $this->flowname . '_form'; ?> default_form'>
    <fieldset class="specimen_investigated">
        <legend>Specimen under investigation</legend>
        <div class='specimen_card'>
            <?php
            $var = $specimenlink; // variable declared in the include file
            include(WebFunctions . 'autopsy_specimen_link.php');
            ?>
        </div>
    </fieldset>

    <input class='specimenlink' name='specimenlink' value=<?php echo $specimenlink; ?> style='display:none;'/>
    <fieldset id="autopsy_specimen_fs">
        <legend>Link to a Previously Observed specimen</legend>
        <div id="autopsy_search_specimens">
            <div class="observations_results"><?php include(Web . 'functions/spec2events_search.php'); ?></div>
            <div class="Search_search_tool" style="display:none;">
                <div class="Search">
		<span>
			<div class="Search_Box" style="display:none">
                <div class="delSearch_Box"><a href=""><span class="ui_icon"></span></a></div>
                <div class="filters"><p>Filter</p><select></select></div>
                <div class="tokens"><p>Token</p><select></select></div>
                <div class="fields"><p>Field</p><select></select></div>
                <div class="fields" style="display:none"><p>Field</p><input></input></div>
            </div><!--end search_box_upd-->
			<div class="Search_Box">
                <div class="delSearch_Box"><a href=""><span class="ui_icon"></span></a></div>
                <div class="filters"><p>Filter</p><select></select></div>
                <div class="tokens"><p>Token</p><select></select></div>
                <div class="fields"><p>Field</p><select></select></div>
                <div class="fields" style="display:none"><p>Field</p><input></input></div>
            </div><!--end search_box_upd-->
		</span>
                </div>
                <!--end of Search-->
                <div class="search_tool">
                    <a class="Search_for" href=""><span class="search" title="search for filtered observations"></span></a>
                    <a class="addSearch_Box" href=""><span class="add" title="Add filter"></span></a>
                </div>
                <!-- end search tool-->
            </div>
            <!-- end Search_search tool-->
        </div>
    </fieldset>
    <div class='errormessage'><?php echo $val->getError('globalerror'); ?></div>
    <?php echo $this->getButtons(); ?>
</form>

