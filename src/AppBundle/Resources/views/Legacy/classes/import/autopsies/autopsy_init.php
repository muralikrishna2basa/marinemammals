<?php
/**
 *    Autopsy importation tool
 *  Specimen Screen
 *  VERSION:1.0.0
 *  AUTHOR:DE WINTER JOHAN
 *  CREATED:20/04/2010
 *  LAST MODIFIED:20/04/2010
 *
 *  DESCRIPTION:
 *  Two choice, either create a new autopsy or find a created autopsy and
 *  use that autopsy in the flow.
 *
 */

include_once(Classes . 'import/flow_class.php');

include_once(Functions . 'Fixcoding.php');


// Database Access

$db = $this->db;

//  Set javascript & css files, to be loaded dynamically 
$css = "/legacy/css/autopsy_import/autopsy_autopsy_init.css";

$js = "/legacy/js/autopsy_import/autopsy_autopsy_init.js";


$val = $this->validation;


if ($val->getStatus() == false) {
    $seqno=$val->getValue('thread');
    if ($seqno != '' && $seqno != 'init') {
        // check that the corresponding item is a necropsy

        $sql = "select count(*) as num_necropsies from necropsies where ese_seqno = :ese_seqno";
        $bind = array(':ese_seqno' => $seqno);
        $res = $db->query($sql, $bind);
        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage());
        } else {
            $row = $res->fetch();

            if ($row['NUM_NECROPSIES'] == '1') {
                $this->thread = $seqno;
            }
        }
        $val->setStatus(true);
    } elseif ($seqno == 'init') {
        $val->setStatus(true);
        $this->InitThread();
    }

    if ($val->getStatus()) {
        $this->navigate();
        return;
    }
} // In case the insert or update functionality worked =>navigate 

?>
<form class='<?php echo $this->flowname . '_form'; ?> default_form'>
    <input style='display:none;' class='thread' name='thread' value='init'/>
    <span>Welcome to the Autopsy importation tool, please choose between creating a new Autopsy or updating an existing one</span>
    <fieldset id='create_autopsy'>
        <legend>Create a new Autopsy</legend>
        <?php echo $this->getInitButton(); ?>
    </fieldset>
    <fieldset id='search_for_autopsies'>
        <legend>Search for Autopsies</legend>
        <div id='search_autopsies'>
            <div class='autopsy_results'>
                <?php
                // Need to make use of an absolute path => always valid ( ajax & web requests )

                include(Web . 'functions/necropsies_search.php');

                ?>
            </div>
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
                    <a class="addSearch_Box" href=""><span class="add" title="Add filter"></span></a>
                    <a class="Search_for" href=""><span class="search" title="search for filtered Autopsies"></span></a>
                </div>
                <!-- end search tool-->
            </div>
            <!-- end Search_search tool-->
        </div>
    </fieldset>
    <?php echo $this->getButtons(); ?>
</form>

