<?php
/**
 *    Autopsy importation tool
 *  Samples Screen
 *  VERSION:1.0.0
 *  AUTHOR:DE WINTER JOHAN
 *  CREATED:20/04/2010
 *  LAST MODIFIED:20/04/2010
 */

include_once(Classes . 'import/flow_class.php');

include_once(Functions . 'Fixcoding.php');


// Database Access

$db = $this->db;

//  Set javascript & css files, to be loaded dynamically 
$css = "css/autopsy_import/autopsy_samples.css";

$js = "js/autopsy_import/autopsy_samples.js";


$val = $this->validation;

$val->setStatus(true);

$necropsy_seqno = $this->getThread();


// get lesion types

$sql = "select seqno,ogn_code,processus from lesion_types";
$res = $db->query($sql);
$lesion_types = array();
if ($res->isError()) {
    echo $res->errormessage() . '; ' . $sql;
} else {
    while ($row = $res->fetch()) {
        $lesion_types[$row['OGN_CODE'] . '/' . $row['PROCESSUS']] = array('seqno' => $row['SEQNO'],
            'ogn_code' => $row['OGN_CODE'],
            'processus' => $row['PROCESSUS']);
    }
}


// get organ lesions for this necropsy

$sql = "select  b.processus, b.ogn_code,a.seqno as oln_seqno from organ_lesions a, lesion_types b where a.lte_seqno = b.seqno and ncy_ese_seqno = '$necropsy_seqno'";
$res = $db->query($sql);
$organ_lesion = array();
if ($res->isError()) {
    echo $res->errormessage() . '; ' . $sql;
} else {
    while ($row = $res->fetch()) {
        if (isset($row['OGN_CODE']) && isset($row['PROCESSUS'])) {
            $organ_lesion[$row['OLN_SEQNO']] = $row['OGN_CODE'] . "/" . $row['PROCESSUS'];
        }
    }
}

// get registered lesion samples previously to any change

$sql = "SELECT c.ogn_code,
  c.processus,
  b.ncy_ese_seqno,
  d.conservation_mode,
  d.analyze_dest,
  d.spe_type,
  d.seqno
FROM lesions2sample a,
  organ_lesions b,
  lesion_types c,
  samples d
where a.oln_seqno = b.seqno
AND c.seqno              = b.lte_seqno
AND d.seqno              = a.spe_seqno
AND b.ncy_ese_seqno      = :seqno";
$bind = array(':seqno' => $necropsy_seqno);

$res = $db->query($sql, $bind);

$registered_samples = array();

if ($res->isError()) {
    echo $res->errormessage() . '; ' . $sql;
} else {
    while ($row = $res->fetch()) {
        if (isset($row['OGN_CODE']) && isset($row['PROCESSUS'])) {
            $registered_samples[$row['SEQNO']] = $row;
        }
    }
}


// CUD on samples 
if ($this->isSubmitted() && $val->getStatus()) // something has been submitted and no error is observed
{
    $organlesionssamples = $_POST['organlesionsample'];
    $organlesionssamples = is_array($organlesionssamples) ? $organlesionssamples : array();
    foreach ($organlesionssamples as $organlesionsample) {
        $lesionsample = json_decode($organlesionsample, true);
        $lesion = $lesionsample["lesion"];
        $lesion_type = $lesion_types[$lesion[0] . "/" . $lesion[1]];
        // in case the sample is to be created
        $oln_seqno=array_search($lesion[0] . "/" . $lesion[1], $organ_lesion);
        if($oln_seqno===false){$oln_seqno=null;}
        if (!isset($lesionsample['Seqno'])) {
            $oln_seqno = null;

            // the only organ lesions that would need to be created are related to 'NA'

            // if the organ lesion doesn't exist then create it
            if (!in_array($lesion[0] . "/" . $lesion[1], $organ_lesion) && $lesion[1] == 'NA') {
                // get lesion type seqno // the lesion is already previously defined

                $sql = "insert into organ_lesions(lte_seqno,ncy_ese_seqno,scale) values(:lte_seqno,:ncy_seqno,'1') ";
                $binds = array(':lte_seqno' => $lesion_type['seqno'], ':ncy_seqno' => $necropsy_seqno);
                $res = $db->query($sql, $binds);
                if ($res->isError()) {
                    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                }
                else{
                    $oln_seqno = $db->query("select organ_lesions_seq.currval from dual")->fetch()['CURRVAL'];
                }
            }
            // insert sample into database
            $sql = "insert into samples(availability,conservation_mode,analyze_dest,spe_type) values (1,:cvt_mode,:an_dest,:spe_type)";
            $binds = array(':cvt_mode' => $lesionsample['conservation_mode'],
                ':an_dest' => $lesionsample['analyze_dest'],
                ':spe_type' => $lesionsample['sample_type']);

            $res = $db->query($sql, $binds);


            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
            } elseif($oln_seqno !== null) {
                // get just created sample seqno
                $sample_seqno = $db->query("select samples_seq.currval from dual")->fetch()['CURRVAL'];

                /*$sql = "select cc_next_value - 1 as sample_seqno from cg_code_controls where cc_domain = 'SPE_SEQ'";
                $res = $db->query($sql);
                $row = $res->fetch();

                $sample_seqno = $row['SAMPLE_SEQNO'];*/


                // link sample to organlesion

                $sql = "insert into lesions2sample(spe_seqno,oln_seqno) values (:spe_seqno,:oln:seqno)";
                $binds = array(':spe_seqno' => $sample_seqno, ':oln_seqno' => $oln_seqno);

                $res = $db->query($sql, $binds);
                if ($res->isError()) {
                    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                }
            }
        }

        // in case of a delete
        if (isset($lesionsample['Seqno']) && isset($lesionsample['DEL']) && $lesionsample['DEL'] == 'TRUE') {
            $sql = "delete from lesions2sample where spe_seqno = :spe_seqno and oln_seqno = :oln_seqno";
            $binds = array(':spe_seqno' => $lesionsample['Seqno'], ':oln_seqno' => $oln_seqno);
            $res = $db->query($sql, $binds);
            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
            }

            $sql = "update samples set availability = '0' where seqno = :seqno";
            $binds = array(':seqno' => $lesionsample['Seqno']);
            $res = $db->query($sql, $binds);
            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
            }
        }

        // in case of an update
        if (isset($lesionsample['Seqno']) && isset($lesionsample['UPD']) && $lesionsample['UPD'] == 'TRUE' && (!isset($lesionsample['DEL']) || $lesionsample['DEL'] == 'FALSE')) {
            // update only if previously registered
            if (array_key_exists($lesionsample['Seqno'], $registered_samples)) {
                // Update Sample
                $old_sample = $registered_samples[$lesionsample['Seqno']];

                $toupdate = array();
                $old_sample['ANALYZE_DEST'] != $lesionsample['analyze_dest'] ? $toupdate['analyze_dest'] = $lesionsample['analyze_dest'] : "";
                $old_sample['CONSERVATION_MODE'] != $lesionsample['conservation_mode'] ? $toupdate['conservation_mode'] = $lesionsample['conservation_mode'] : "";
                $old_sample['SPE_TYPE'] != $lesionsample['sample_type'] ? $toupdate['spe_type'] = $lesionsample['sample_type'] : "";

                if (count($toupdate) > 0) {
                    $toupdate_array = array();
                    $toupdate_string = "";
                    $binds = array();
                    foreach ($toupdate as $key => $valupd) {
                        $toupdate_array[] = " $key = :$key";
                        $binds[":$key"] = $valupd;
                    }
                    $toupdate_string = implode(',', $toupdate_array);
                    $sql = "update samples set $toupdate_string where seqno = :seqno";
                    $binds[':seqno'] = $lesionsample['Seqno'];

                    // $res = $db->query($sql,$binds);
                    // if($res->isError()){ echo $res->errormessage() . '; ' . $sql;}
                }

            }
            // check if an organ update is neccessary
            if ($lesion[0] != $old_sample['OGN_CODE'] || $lesion[1] != $old_sample['PROCESSUS']) {
                // delete link between sample and organ lesion
                $sql = "delete from lesions2sample where spe_seqno = :spe_seqno and oln_ncy_ese_seqno = :necropsy_seqno";
                $binds = array(':spe_seqno' => $lesionsample['Seqno'], ':necropsy_seqno' => $necropsy_seqno);
                // $res = $db->query($sql,$binds);
                // if($res->isError()){ echo $res->errormessage() . '; ' . $sql;}

                // update organ_lesions accordingly
                $old_lesion_type = $lesion_types[$old_sample['OGN_CODE'] . "/" . $old_sample["PROCESSUS"]];
                $sql = "update organ_lesions set lte_seqno = :new_lte_seqno, lte_ogn_code = :new_ogn_code
					where lte_seqno = :old_lte_seqno and lte_ogn_code = :old_ogn_code";
                $binds = array(':new_lte_seqno' => $lesion_type['seqno'],
                    ':new_ogn_code' => $lesion[0],
                    ':old_lte_seqno' => $old_lesion_type['seqno'],
                    ':old_ogn_code' => $old_sample['OGN_CODE']);
                //$res = $db->query($sql,$binds);
                if ($res->isError()) {
                    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                } else {
                    // if the update went well, then create the link between the sample and the corresponding lesion
                    $sql = "insert into lesions2sample(spe_seqno,oln_lte_seqno,oln_ncy_ese_seqno,oln_lte_ogn_code) values (:spe_seqno,:lte_seqno,:ese_seqno,:ogn_code)";
                    $binds = array(':spe_seqno' => $lesionsample['Seqno'], ':lte_seqno' => $lesion_type['seqno'], ':ese_seqno' => $necropsy_seqno, ':ogn_code' => $lesion[0]);

//			$res = $db->query($sql,$binds);
//			if($res->isError()){ echo $res->errormessage() . '; ' . $sql;}

                }
            }
        }
    }
    if ($val->getStatus()) {
        $this->navigate();
        return;
    }
}


// get already registered lesion samples

$sql = "SELECT c.ogn_code,
  c.processus,
  b.ncy_ese_seqno,
  d.conservation_mode,
  d.analyze_dest,
  d.spe_type,
  d.seqno
FROM lesions2sample a,
  organ_lesions b,
  lesion_types c,
  samples d
where a.oln_seqno = b.seqno
AND c.seqno              = b.lte_seqno
AND d.seqno              = a.spe_seqno
AND b.ncy_ese_seqno      = :seqno";
$bind = array(':seqno' => $necropsy_seqno);

$res = $db->query($sql, $bind);

$registered_samples = array();

if ($res->isError()) {
    echo $res->errormessage() . '; ' . $sql;
} else {
    while ($row = $res->fetch()) {
        if (isset($row['OGN_CODE']) && isset($row['PROCESSUS'])) {
            $registered_samples[$row['OGN_CODE'] . "/" . $row['PROCESSUS']][$row['SEQNO']] = $row;
        }
    }
}


// get Sample type 
$sql = "select rv_low_value,rv_meaning from cg_ref_codes where rv_domain = 'SAMPLE_TYPE'";
$res = $db->query($sql);
if ($res->isError()) {
    echo $res->errormessage() . '; ' . $sql;
}
$sample_type = "<select class='SampleType minwidth'><option></option>";
while ($row = $res->fetch()) {
    $selected = $row['RV_LOW_VALUE'] == 'ORG' ? "selected='selected'" : "";
    $sample_type .= "<option $selected value ='" . $row['RV_LOW_VALUE'] . "'>" . $row['RV_MEANING'] . "</option>";
}
$sample_type .= "</select>";
// get Conservation mode
$conservation_mode = array();
$sql = "select rv_low_value,rv_meaning from cg_ref_codes where rv_domain='CONSERVATION_MODE'";
$res = $db->query($sql);
if ($res->isError()) {
    echo $res->errormessage() . '; ' . $sql;
}
$conservation_mode_body = "<select class='CsvModeBody minwidth'><option></option>";
while ($row = $res->fetch()) {
    $conservation_mode_body .= "<option>" . $row['RV_LOW_VALUE'] . "</option>";
    $conservation_mode[$row['RV_LOW_VALUE']] = $row['RV_MEANING'];
}
$conservation_mode_body .= "</select>";
// get Analyze_dest 
$avandest = array();
$analyze_dest = array();
$default_conservation_mode = array();
$sql = "select rv_low_value,rv_meaning,rv_high_value from cg_ref_codes where rv_domain='ANALYZE_DEST'";
$res = $db->query($sql);
if ($res->isError()) {
    echo $res->errormessage() . '; ' . $sql;
}
while ($row = $res->fetch()) {
    $analyze_dest[$row['RV_LOW_VALUE']] = $row['RV_MEANING'];
    $avandest[$row['RV_LOW_VALUE']] = 0;
    $default_conservation_mode[$row['RV_LOW_VALUE']] = $row['RV_HIGH_VALUE'];
}

// avandest is an array containing internal counter to sort the register samples accordingly 
$registered_samples_new = array();
$ognandest = array();
foreach ($registered_samples as $ognproc => $samples) {
    foreach ($samples as $seqno => $properties) {
        if (!array_key_exists($ognproc, $ognandest)) {
            $ognandest[$ognproc] = $avandest;
        }

        $analyzedest = $properties['ANALYZE_DEST'];
        if (array_key_exists($ognproc . "/" . $ognandest[$ognproc][$analyzedest], $registered_samples_new) &&
            in_array($ognproc . "/" . $analyzedest, $registered_samples_new[$ognproc . "/" . $ognandest[$ognproc][$analyzedest]])
        ) {
            $ognandest[$ognproc][$analyzedest] += 1;
        }

        $registered_samples_new[$ognproc . "/" . $ognandest[$ognproc][$analyzedest]][$analyzedest] = $properties;

        $ognandest[$ognproc][$analyzedest] += 1;
    }
}

// load organs 
$file_load = !file_exists('loadorganslesions.php') ? 'functions/loadorganslesions.php' : 'loadorganslesions.php';


//----------------------------------------------------------------------------------
// get Specimen ID 
$sql = "select scn_seqno from spec2events where ese_seqno = $necropsy_seqno";
$res = $db->query($sql);
if ($res->isError()) {
    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
}
$row = $res->fetch();
$specimenlink = $row == false ? 'init' : $row['SCN_SEQNO'];

$var = $specimenlink; // variable declared in the include file
include(WebFunctions . 'autopsy_specimen_link.php');

?>
<form class='<?php echo $this->flowname . '_form'; ?> default_form' action='#'>
    <fieldset id="diagnosis_fs">
        <legend>Samples</legend>
        <table class='tab_output samples' width="100%" border="1">
            <thead>
            <tr class='conservation_mode'>
                <th>Conservation Mode</th>
                <?php foreach ($analyze_dest as $key => $vall): ?>
                    <th>
                        <select class='conservation_mode <?php echo $key; ?>'>
                            <?php foreach ($conservation_mode as $cons_key => $cons_val) {
                                $selected = $default_conservation_mode[$key] == $cons_key ? "selected='selected'" : '';

                                echo "<option $selected value='$cons_key'>$cons_key</option>";
                            }
                            ?>
                        </select>
                    </th>
                <?php endforeach; ?>
                <th rowspan="2"></th>
            </tr>
            <tr class='analyze_dest'>
                <th>Organ</th>
                <?php foreach ($analyze_dest as $key => $vall): ?>
                    <th><?php echo $key; ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="<?php echo count($analyze_dest) + 2; ?>">
                    <button type="button" class="addsample">Add Sample</button>
                    <button type="button" class="toggledefault hide">Hide Defaults</button>
                    <button type="button" class="toggledefault show" style="display:none;">Show Defaults</button>
                </td>
            </tr>
            </tfoot>
            <tbody>
            <?php // Hidden row, to be used at the client side?>
            <tr style="display:none;" class='initbodyrow'>
                <td class='organ_select'><?php $lesion_var = 'ROOT';
                    include($file_load);
                    unset($lesion_var); ?></td>
                <?php for ($i = 0; $i < count($analyze_dest); $i++): ?>
                    <td>
                    <div>
                        <span style='visibility:hidden;' class='RegConsMode'></span>
                        <span class='UpdConsMode' style='visibility:hidden;'></span>
                        <span class='UpdOrgan' style='visibility:hidden;'></span>
                        <input type='checkbox'/><br/>
                        <?php echo $conservation_mode_body;
                        echo $sample_type; ?>
                    </div>
                    </td><?php endfor; ?>
                <td>
                    <button class="delsample" type="button"><img alt="Del" src="/img/cross.png"/></button>
                </td>
            </tr>
            <?php // DISPLAY ALL SAMPLE LESIONS
            $tdclass = 'RegSample';
            $defaults = array();
            foreach ($registered_samples_new as $ognprocnum => $ansamples) :
                list($lesion_var, $processus_var, $num) = explode('/', $ognprocnum);
                $defaults[] = $lesion_var . "/" . $processus_var;
                ?>
                <tr>
                    <td class='organ_select'>
                        <?php
                        include($file_load);
                        ?>
                    </td>
                    <?php
                    $lesionsamplejson = '';
                    foreach ($analyze_dest as $an_dest => $value):

                        if (array_key_exists($an_dest, $ansamples)) {
                            $registered_sample = $ansamples[$an_dest];

                            $lesionsample = array('lesion' => array($registered_sample['OGN_CODE'], $registered_sample['PROCESSUS']),
                                'conservation_mode' => $registered_sample['CONSERVATION_MODE'],
                                'analyze_dest' => $registered_sample['ANALYZE_DEST'],
                                'sample_type' => $registered_sample['SPE_TYPE'],
                                'Seqno' => $registered_sample['SEQNO']
                            );
                            $lesionsamplejson = json_encode($lesionsample);
                        } else {
                            $lesionsamplejson = '';
                        }

                        $tdclass = strlen($lesionsamplejson) == 0 ? "RegSampleDefault" : 'RegSample';

                        ?>
                        <td class='<?php echo $tdclass;?>'>
                            <div>
                                <?php
                                $organcodelesion = "";
                                $consmodeorgan = "";
                                if (strlen($lesionsamplejson) != 0) {
                                    echo "<span  class='RegConsMode'>" . $registered_sample['CONSERVATION_MODE'] . "</span>";
                                    $organcodelesion = $registered_sample['OGN_CODE'] . "/NA";
                                    $consmodeorgan = $registered_sample['CONSERVATION_MODE'];
                                } else {
                                    echo "<span class='RegConsMode' style='visibility:hidden;'></span>";
                                }
                                ?>
                                <span class='UpdConsMode' style='visibility:hidden;'><?php echo $consmodeorgan;?></span>
                                <span class='UpdOrgan' style='visibility:hidden;'><?php echo $organcodelesion; ?></span>
                                <?php
                                if (strlen($lesionsamplejson) != 0) {
                                    echo "<input type='checkbox' checked = 'checked'/>";
                                    echo "<input class='organlesionsample' style='display:none;' name = 'organlesionsample[]' value = '$lesionsamplejson'/>";
                                    echo "<input class='regorganlesionsample' style='display:none;' value = '$lesionsamplejson'/>";
                                } else {
                                    echo "<input type='checkbox'/>";
                                }

                                if (strlen($lesionsamplejson) != 0) {
                                    echo $conservation_mode_body;
                                    echo $sample_type;
                                }
                                ?>
                            </div>
                        </td>
                    <?php endforeach;?>
                    <td>
                        <button class="delsample" type="button"><img alt="Del" src="/img/cross.png"/></button>
                    </td>
                </tr>
            <?php
            endforeach; //
            ?>

            <?php


            // DISPLAY ALL ORGANS ROW


            // get organs

            $samplesset = array(); // array of already shown samples in the interface

            $organsroot = array();

            $sql = "select code,name from organs where ogn_code= :ROOT order by name";
            $bind = array(':ROOT' => 'ROOT');
            $res = $db->query($sql, $bind);
            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
            }
            while ($row = $res->fetch()):

                if (in_array($row['CODE'] . "/NA", $defaults)) {
                    continue;
                }
                ?>
                <tr class='default_sample'>
                    <td class='organ_select'><?php $lesion_var = $row['CODE'];
                        include($file_load);
                        unset($lesion_var);?></td>
                    <?php
                    foreach ($analyze_dest as $key => $value):
                        ?>
                        <td class='RegSampleDefault'>
                            <div>
                                <span class='RegConsMode' style='visibility:hidden;'></span>
                                <span class='UpdConsMode' style='visibility:hidden;'></span>
                                <span class='UpdOrgan' style='visibility:hidden;'></span>
                                <input type='checkbox'/>
                            </div>
                        </td><?php endforeach;?>
                    <td>
                        <button class="delsample" type="button"><img alt="Del" src="/img/cross.png"/></button>
                    </td>
                </tr>
            <?php endwhile;
            ?>
            </tbody>
        </table>
        <div class='errormessage'><?php echo $val->getError('globalerror'); ?></div>
    </fieldset>
    <?php echo $this->getButtons(); ?>
</form>




