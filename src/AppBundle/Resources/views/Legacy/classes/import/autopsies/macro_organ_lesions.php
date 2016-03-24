<?php
/**
 *    Autopsy importation tool
 *  Macro Organ Lesions Screen
 *  VERSION:1.0.0
 *  AUTHOR:DE WINTER JOHAN
 *  CREATED:20/04/2010
 *  LAST MODIFIED:20/04/2010
 */

include_once(Classes . 'import/flow_class.php');

include_once(Functions . 'Fixcoding.php');


$db = $this->db;
//  Set javascript & css files, to be loaded dynamically 
$css = "/legacy/css/autopsy_import/autopsy_macro_organ_lesions.css";

$js = "/legacy/js/autopsy_import/autopsy_macro_organ_lesions.js";


$val = $this->validation;
$necropsy_seqno = $this->getThread();

// A lesion need to have at least the organ and processus identified

// get diagnosis
$tmp = $val->getValue('diagnosis');
// set no error by default 

$val->setStatus(true); // in case the form is submitted and no error occured during the submission => status is = true


// get a table of parameter domain 

$sql = "select seqno,name from parameter_methods";

$res = $db->query($sql);

$parameter_methods = array();
if ($res->isError()) {
    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
} else {
    while ($row = $res->fetch()) {
        $parameter_methods[$row['SEQNO']] = $row['NAME'];
    }
}

$diagnosis = array();
$lesions_submitted = array();
if (is_array($tmp)) {
    $i = 0;
    foreach ($tmp as $lesion) {
        if (strlen($lesion) == 0) {
            continue;
        }

        $lesion_decode = json_decode($lesion, true);

        $diagnosis[$i] = $lesion_decode;

        if (strlen($lesion_decode['organ']) == 0 || $lesion_decode['organ'] == 'PARENT') {
            $val->setError('LesionOrgan_' . $i, 'Organ not set');
        }

        if (strlen($lesion_decode['Process']) == 0) {
            $val->setError('LesionProcess_' . $i, 'Process not set');
        }

        if (strlen($lesion_decode['Process']) != 0 && strlen($lesion_decode['organ']) != 0) {
            $lesions_submitted[$lesion_decode['organ'] . $lesion_decode['Process']] = $lesion_decode;
        }

        $i++;
    }
}

// get all macroscopic lesions ( sane organs are excluded=>therefore inner join on the lesion values)


$sql = "select a.seqno as oln_seqno, b.seqno as lte_seqno, b.ogn_code organ,b.processus Process,a.description, CASE WHEN EXISTS (SELECT 1 FROM lesions2sample l2s WHERE l2s.oln_seqno=a.seqno       )     THEN 1     ELSE 0   END AS hasSample  from organ_lesions a, lesion_types b where b.seqno = a.lte_seqno and a.ncy_ese_seqno = $necropsy_seqno and b.processus != 'NA' and scale = 1";
//TODO why processus NA?
$res = $db->query($sql);
if ($res->isError()) {
    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
} else {
    $lesion_registered = $res->fetchAll();
    // change to the format of diagnosis
    if (is_array($lesion_registered)) {
        foreach ($lesion_registered as $key => $tmp) {
            $lesion_registered[$tmp['ORGAN'] . $tmp['PROCESS']] = array('oln_seqno' => $tmp['OLN_SEQNO'], 'lte_seqno' => $tmp['LTE_SEQNO'], 'organ' => $tmp['ORGAN'], 'Process' => $tmp['PROCESS'], 'Description' => $tmp['DESCRIPTION'],'hasSample'=>$tmp['HASSAMPLE']);
            unset($lesion_registered[$key]);
        }
    } else {
        $lesion_registered = array(); // default array ()
    }
}
// get all associated parameter values 
$sql = "SELECT b.ncy_ese_seqno,c.ogn_code organ,   c.processus Process,   d.name,   a.value,   b.seqno FROM lesion_values a,   organ_lesions b,   lesion_types c,   parameter_methods d WHERE a.oln_seqno = b.seqno AND c.seqno       = b.lte_seqno AND d.seqno       = a.pmd_seqno and b.ncy_ese_seqno = $necropsy_seqno and scale         = 1";

//"select c.ogn_code organ, c.processus Process,d.name,a.value,case when (select spe_seqno from != null return true else return false end as hasSample from lesion_values a,organ_lesions b, lesion_types c, parameter_methods d where a.oln_seqno = b.seqno and c.seqno = b.lte_seqno and b.ncy_ese_seqno = $necropsy_seqno and d.seqno = a.pmd_seqno and scale = 1";
$res = $db->query($sql);
if ($res->isError()) {
    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
} else {
    while ($row = $res->fetch()) {
        $lesion_registered[$row['ORGAN'] . $row['PROCESS']][$row['NAME']] = $row['VALUE'];
    }
}

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


if ($this->isSubmitted() && $val->getStatus()) // something has been submitted and no error is observed
{
    // get all associated lesions , compare and get a list of items to delete and items to insert

    $lesion_to_insert = array_diff_key($lesions_submitted, $lesion_registered); // lesions submitted that are not registered

    // insert a new organ lesion

    foreach ($lesion_to_insert as $lesion) {
        $process = $lesion['Process'];
        $organ = $lesion['organ'];
        $description = $lesion['Description'];
        unset($lesion['Process'], $lesion['organ'], $lesion['Description']);

        // first check if the lesion is already defined.
        $sql = 'select count(*) as cnt_lesion,seqno from lesion_types where ogn_code = :ogn_code and processus = :process group by seqno';
        $binds = array(':process' => $process, ':ogn_code' => $organ);
        $res = $db->query($sql, $binds);

        if (!$res->isError()) {
            $row = $res->fetch();
            if ($row == false || $row['CNT_LESION'] == 0) // the corresponding lesion_type has not been inserted already
            {
                $sql = 'insert into lesion_types ( processus,ogn_code) values (:process,:ogn_code) ';
                $binds = array(':process' => $process, ':ogn_code' => $organ);
                $res = $db->query($sql, $binds);

                if (!$res->isError()) {
                    $sql = "select seqno from lesion_types where processus = '$process' and ogn_code = '$organ'";
                    $res = $db->query($sql);
                    if ($res->isError()) {
                        $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                    } else {
                        $row = $res->fetch();

                        $lte_seqno = is_array($row) ? $row['SEQNO'] : '';
                    }
                } else {
                    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                }
            } elseif ($row['CNT_LESION'] > 1) {
                $val->setError('globalerror', 'check database, primary key organ lesion multiple');
            } else {
                $lte_seqno = $row['SEQNO'];
            }

        } else {
            $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
        }

        if ($val->getStatus()) // the status remain true, i.e either the lesion_type existed already or it has been entered successfully
        {
            if (!isset($lesion['UPD'])) { //if this is actually an update because the lesion type changed, don't do anythings
                $sql = "insert into organ_lesions (lte_seqno,ncy_ese_seqno,description,scale) values ($lte_seqno,$necropsy_seqno,:description,1)";

                $description = strlen($description) == 0 ? ' ' : $description;

                $binds = array(':description' => $description);

                $res = $db->query($sql, $binds);

                if (!$res->isError()) {
                    //$new_oln_seqno=$db->query("select organ_lesions_seq.currval from dual")->fetch();
                    $rowSeq = $db->query("select organ_lesions_seq.currval from dual")->fetch();
                    $new_oln_seqno = $rowSeq['CURRVAL'];
                    // insert all values corresponding to the lesion
                    foreach ($lesion as $parameter => $value) {
                        if (strlen($value) == 0) {
                            continue;
                        }
                        if (!in_array($parameter, $parameter_methods)) {
                            continue;
                        } // the parameter is a valid parameter

                        $pmd_seqno = current(array_keys($parameter_methods, $parameter));

                        $sql = "insert into lesion_values ( oln_seqno,pmd_seqno,value,value_flag_ref)
							values ($new_oln_seqno,$pmd_seqno,:value,(select seqno from cg_ref_codes where rv_domain='VALUE_FLAG' and rv_low_value='1'))";
                        $bind = array(':value' => $value);
                        $res = $db->query($sql, $bind);
                        if ($res->isError()) {
                            $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                            break;
                        }
                    }
                } else {
                    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                }

                // if the lesion to insert update an existing one that got samples, then transfer all the samples to this lesion
            } else {
                list($oldogn, $oldprocess) = explode('/', $lesion['UPD']);
                $newogn=$lesion['organ'];
                $newprocess=$lesion['Process'];
                $lesionKey = str_replace('/', '', $lesion['UPD']);

                $oln_seqno = $lesion_registered[$lesionKey]['oln_seqno'];
                $lte_seqno = $lesion_registered[$lesionKey]['lte_seqno'];

                // Perform an update only if lesion exist in registered lesions

                if (isset($lesion_registered[$oldogn . $oldprocess])) {
                    // get old lesion type seqno

                    //$old_lte = isset($lesion_types[$oldogn . '/' . $oldprocess]) ? $lesion_types[$oldogn . '/' . $oldprocess] : "";

                    //$old_lte_seqno = $old_lte['seqno'];

                    //if (strlen($old_lte_seqno) > 0) {
                    // get samples from it

                    $res = $db->query("select * from lesion_types where ogn_code=$newogn and processus=$newprocess");
                    $ltSeqno=null;
                    if (!$res->isError()) {
                        $lteSeqno=$res->fetch()[0]['seqno'];
                        $sql = "update organ_lesions set lte_seqno = :lte_seqno where seqno=" . $oln_seqno;

                        $bind = array(':lte_seqno' => $lteSeqno);
                        $res = $db->query($sql, $bind);
                        if ($res->isError()) {
                            $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                            break;
                        }
                    }
                    // $sql = "select * from lesions2sample where oln_seqno = $oln_seqno and oln_lte_seqno = $old_lte_seqno and oln_ncy_ese_seqno = $necropsy_seqno";
                    /*$sql = "select * from lesions2sample where oln_seqno = $oln_seqno";

                    $res = $db->query($sql);

                    if (!$res->isError()) {
                        while ($row = $res->fetch()) {
                            $sample_seqno = $row['SPE_SEQNO'];

                            $sql = "insert into lesions2sample(spe_seqno,oln_seqno) values ($sample_seqno,$oln_seqno)";

                            $resl = $db->query($sql);
                            if ($resl->isError()) {
                                $val->setError('globalerror', $resl->errormessage());
                                break;
                            }


                        }
                        // delete old links to samples
                        if ($val->getStatus()) {
                            $sql = "delete from lesions2sample where oln_ncy_ese_seqno = $necropsy_seqno and oln_lte_seqno = $old_lte_seqno and
							oln_lte_ogn_code = '$oldogn'";
                            $resl = $db->query($sql);
                            if ($resl->isError()) {
                                $val->setError('globalerror', $resl->errormessage());
                            }

                        }
                    } else {
                        $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                    }
                    //} // strlen > 0*/
                } // lesionregistered
            }// if update
        }

    }

    $lesion_to_delete = array_diff_key($lesion_registered, $lesions_submitted); // lesions registered that are not submitted

    foreach ($lesion_to_delete as $lesion) // items to delete come directly from database
    {
        // first delete all parameters
        $process = $lesion['Process'];

        $organ = $lesion['organ'];

        $description = $lesion['Description'];

        $oln_seqno = $lesion['oln_seqno'];
        $lte_seqno = $lesion['lte_seqno'];

        unset($lesion['Process'], $lesion['organ'], $lesion['Description']);

        $sql = "select seqno from lesion_types where processus = '$process' and ogn_code = '$organ'";
        $res = $db->query($sql);
        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
        } else {
            $row = $res->fetch();
            if (!is_array($row)) {
                $val->setError('globalerror', 'item to delete doesn\'t have a valid seqno ');
                break;
            }

            $lte_seqno = $row['SEQNO'];
        }
        if (!$val->getStatus()) {
            break;
        }

        // delete links to eventual samples attached to the lesion

        $sql = "delete from lesions2sample where oln_seqno = $oln_seqno";

        $res = $db->query($sql);

        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
            break;
        }

        // delete organ lesion values
        foreach ($lesion as $parameter => $value) {
            if (!in_array($parameter, $parameter_methods)) {
                continue;
            } // the parameter is a valid parameter

            $pmd_seqno = current(array_keys($parameter_methods, $parameter));

            $sql = "delete from lesion_values where oln_seqno = $oln_seqno and pmd_seqno = $pmd_seqno";

            $res = $db->query($sql);
            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                break;
            }
        }

        if (!$val->getStatus()) {
            break;
        }

        // delete organ lesion
        $sql = "delete from organ_lesions where seqno = $oln_seqno";
        $res = $db->query($sql);
        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
            break;
        }
    }

    $lesion_to_update = array_intersect_key($lesions_submitted, $lesion_registered);

    foreach ($lesion_to_update as $key => $lesion) // items to update
    {

        $process = $lesion['Process'];

        $organ = $lesion['organ'];

        $description = $lesion['Description'];

        $oln_seqno = $lesion_registered[$key]['oln_seqno'];
        $lte_seqno = $lesion_registered[$key]['lte_seqno'];

        unset($lesion['Process'], $lesion['organ'], $lesion['Description']);

        $oldlesion = $lesion_registered[$key];

        if ($description != $oldlesion['Description']) {
            $sql = "update organ_lesions set description = :description where seqno=" . $oln_seqno;

            $description = strlen($description) == 0 ? ' ' : $description;
            $bind = array(':description' => $description);
            $res = $db->query($sql, $bind);
            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                break;
            }
        }

        // cud on lesions value for this particular lesion ( create, update, delete)
        unset($oldlesion['Description'], $oldlesion['Process'], $oldlesion['organ']);

        $sql = "select seqno from lesion_types where processus = '$process' and ogn_code = '$organ'";
        $res = $db->query($sql);
        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
        } else {
            $row = $res->fetch();
            if (!is_array($row)) {
                $val->setError('globalerror', 'item to delete doesn\'t have a valid seqno ');
                break;
            }

            $lte_seqno = $row['SEQNO'];
        }
        if (!$val->getStatus()) {
            break;
        }

        $lv_to_delete = array_diff_key($oldlesion, $lesion);

        foreach ($lv_to_delete as $parameter => $todelete) {
            if (!in_array($parameter, $parameter_methods)) {
                continue;
            } // the parameter is a valid parameter

            $pmd_seqno = current(array_keys($parameter_methods, $parameter));

            $sql = "delete from lesion_values where oln_seqno = $oln_seqno and pmd_seqno = $pmd_seqno";
            $res = $db->query($sql);
            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                break;
            }
        }

        $lv_to_insert = array_diff_key($lesion, $oldlesion); // lesions submitted that are not registered


        foreach ($lv_to_insert as $parameter => $value) {
            if (strlen($value) == 0) {
                continue;
            }

            if (!in_array($parameter, $parameter_methods)) {
                continue;
            } // the parameter is a valid parameter

            $pmd_seqno = current(array_keys($parameter_methods, $parameter));

            $sql = "insert into lesion_values ( oln_seqno,pmd_seqno,value,value_flag_ref)
							values ($oln_seqno,$pmd_seqno,:value,(select seqno from cg_ref_codes where rv_domain='VALUE_FLAG' and rv_low_value='1'))";
            $bind = array(':value' => $value);
            $res = $db->query($sql, $bind);
            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                break;
            }
        }

        $lv_to_update = array_intersect_key($lesion, $oldlesion);

        foreach ($lv_to_update as $parameter => $value) {
            $oldvalue = $oldlesion[$parameter];

            if ($oldvalue == $value) {
                continue;
            }

            if (!in_array($parameter, $parameter_methods)) {
                continue;
            } // the parameter is a valid parameter

            $pmd_seqno = current(array_keys($parameter_methods, $parameter));

            if (strlen($value) == 0) {
                $sql = "delete from lesion_values where oln_seqno = $oln_seqno and pmd_seqno = $pmd_seqno";
                $res = $db->query($sql);
                if ($res->isError()) {
                    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                    break;
                }
            } else {
                $sql = "update lesion_values set value = :value where oln_seqno = $oln_seqno and pmd_seqno = $pmd_seqno";
                $bind = array(':value' => $value);
                $res = $db->query($sql, $bind);
                if ($res->isError()) {
                    $val->setError('globalerror', $res->errormessage() . '; ' . $sql);
                    break;
                }
            }

        }
    }
    if ($val->getStatus()) {
        $this->navigate();
        return;
    }

}

if (!$this->isSubmitted()) // set the already registered lesions
{
    $diagnosis = $lesion_registered;
}
//-----------------------------------------------------------------------------------------
// get parameter domains

$res = $db->query("select b.name, a.code from parameter_domains a, parameter_methods b where a.pmd_seqno = b.seqno and b.seqno in (3,4,5,6,7)");

$html_domains = array();
$domain_save = array();
$tmp = "";
while ($row = $res->fetch()) {
    if (array_key_exists($row['NAME'], $html_domains)) {
        $html_domains[$row['NAME']] .= "<option>" . $row['CODE'] . "</option>";
        $domain_save[$row['NAME']][] = $row['CODE'];
        continue;
    }

    if (strlen($tmp) > 0) {
        $html_domains[$tmp] .= "</select>";
    }

    $html_domains[$row['NAME']] = "<select class='" . $row['NAME'] . "'><option></option><option>" . $row['CODE'] . "</option>";
    $domain_save[$row['NAME']][] = $row['CODE'];
    $tmp = $row['NAME'];
}

// get process 

$res = $db->query("select rv_meaning,rv_low_value from cg_ref_codes where rv_domain = 'PROCESSUS'");
$html_process = '<select class="Process"><option></option>';
$process_array = array();
while ($row = $res->fetch()) {
    $html_process .= "<option value='" . $row['RV_LOW_VALUE'] . "'>" . $row['RV_MEANING'] . "</option>";
    $process_array[$row['RV_LOW_VALUE']] = $row['RV_MEANING'];
}

// load organs 
$file_load = !file_exists('loadorgans.php') ? 'functions/loadorgans.php' : 'loadorgans.php';

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
<form class='well <?php echo $this->flowname . '_form'; ?> default_form' action="#">
    <fieldset id="diagnosis_fs">
        <legend>Macroscopic Lesions</legend>
        <table class='tab_output diagnosis' width="100%" border="1">
            <thead>
            <tr>
                <th rowspan="2">Organ</th>
                <th rowspan="2">Process</th>
                <th colspan="5">Description</th>
                <th rowspan="2">Morphologic Diagnosis</th>
                <th rowspan="2"></th>
            </tr>
            <tr>
                <?php foreach ($html_domains as $keydomain => $select_domaine): ?>
                    <th><?php echo $keydomain; ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="9">
                    <button class='addlesion' type='button'>Add Lesion</button>
                </td>
            </tr>
            </tfoot>
            <tbody>
            <tr class='init' style='display:none;'>
                <td class='organ_select'><?php include($file_load); ?></td>
                <td><?php echo $html_process; ?></td>
                <?php foreach ($html_domains as $select) {
                    echo "<td>$select</td>";
                } ?>
                <td><input class='Description'/></td>
                <td>
                    <button class="dellesion" type="button"><img alt="Del" src="/legacy/img/cross.png"/></button>
                </td>
                <td style='display:none;'><input class='diagnosis' name='diagnosis[]'/></td>
            </tr>
            <?php
            foreach ($diagnosis as $keydiag => $lesion):?>
                <tr class='registered'>
                    <td style='display:none;' class="has-sample"><?php echo $lesion['hasSample']?></td>
                    <td class='organ_select'><?php $lesion_var = $lesion['organ'];
                        include($file_load);
                        unset($lesion_var);
                        echo "<div class='errormessage'>" . $val->getError('LesionOrgan_' . $keydiag) . '</div>';?></td>
                    <td>
                        <?php // get process
                        $html_proc = '<select class="Process"><option></option>';
                        foreach ($process_array as $key => $process_element) {

                            if ($key == $lesion['Process']) {
                                $html_proc .= "<option value='$key' selected='selected'>" . $process_element . "</option>";
                                continue;
                            }
                            $html_proc .= "<option value='$key'>" . $process_element . "</option>";
                        }
                        echo $html_proc . '</select>';
                        echo "<div class='errormessage'>" . $val->getError('LesionProcess_' . $keydiag) . '</div>';
                        ?>
                    </td>
                    <?php // get domain
                    foreach ($domain_save as $parameter => $values) {
                        if (!isset($lesion[$parameter]) || strlen($lesion[$parameter]) == 0) {
                            echo "<td>" . $html_domains[$parameter] . "</td>";
                            continue;
                        }
                        $select_dom = "<select class='" . $parameter . "'><option></option>";
                        foreach ($values as $value) {
                            if ($value == $lesion[$parameter]) {
                                $select_dom .= "<option selected='selected'>" . $value . "</option>";
                                continue;
                            }
                            $select_dom .= "<option>" . $value . "</option>";
                        }
                        echo "<td>" . $select_dom . '</select></td>';
                    }
                    ?>
                    <td><input class='Description'
                               value='<?php echo isset($lesion['Description']) ? $lesion['Description'] : '';?>'/></td>
                    <td>
                        <button class="dellesion" type="button"><img alt="Del" src="/legacy/img/cross.png"/></button>
                    </td>
                    <td style='display:none;'><input class='diagnosis' name='diagnosis[]'
                                                     value='<?php echo json_encode($lesion);?>'/></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class='organ_select'><?php include($file_load); ?></td>
                <td><?php echo $html_process; ?></td>
                <?php foreach ($html_domains as $select) {
                    echo "<td>$select</td>";
                } ?>
                <td><input class='Description'/></td>
                <td>
                    <button class="dellesion" type="button"><img alt="Del" src="/legacy/img/cross.png"/></button>
                </td>
                <td style='display:none;'><input class='diagnosis' name='diagnosis[]'/></td>
            </tr>
            </tbody>
        </table>
        <input style='display:none;' name='flow' value='<?php echo $this->flowname; ?>'/>

        <div class='errormessage'><?php echo $val->getError('globalerror'); ?></div>
    </fieldset>
    <?php echo $this->getButtons(); ?>
</form>


