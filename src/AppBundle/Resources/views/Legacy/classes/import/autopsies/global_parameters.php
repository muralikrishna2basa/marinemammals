<?php
/**
 *    Autopsy importation tool
 *  Global Parameters Screen
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
$css = "/legacy/css/autopsy_import/autopsy_global_parameters.css";

$js = "/legacy/js/autopsy_import/autopsy_global_parameters.js";

// to be filled later ( array of posted elements)
$posted = array();

$val = $this->validation;

// 
$necropsy_seqno = $this->getThread();

// get all parameters from the database and transform the results into a suitable array ( res_mod)

$basicParams = array('DECO', 'AGE', 'LENG', 'WEIG', 'NUTS', 'BLUD', 'BLUM', 'BLUV');


$basicParamsStr = "'" . implode("','", $basicParams) . "'";

$externalPathParams = array('LEBITE', 'LEBROB', 'LECUTS', 'LEENLE', 'LEFINA', 'LEHBIT', 'LEHCUT', 'LEHNET', 'LEHOPW', 'LEHPOX', 'LEHYPO', 'LENETM', 'LENETP', 'LENETS', 'LENETT', 'LEOPEN', 'LEOTH', 'LESCBI', 'LESCPI', 'LESTAB', 'OTHEXT', 'OTHFIS', 'OTHFRO', 'OTHOIL', 'OTHPRE', 'OTHREM', 'REMA');

$allParams = array_merge($basicParams, $externalPathParams);
$sql = "select a.name,a.unit,a.code as code, b.code as domcode,a.description,case when a.code in (" . $basicParamsStr . ") then 'Measurements' else 'External examination' end as type  from parameter_methods a,parameter_domains b where b.pmd_seqno (+)= a.seqno and a.origin = 'SCN' order by a.name,b.code";

$res = $db->query($sql);

if ($res->isError()) {
    $val->setError('globalerror', $res->errormessage());
}

$results = $res->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);

$res_mod_code = array();
foreach ($results['CODE'] as $key => $resname) {
    $res_mod_code[$resname][] = array('NAME' => $results['NAME'][$key], 'DOMCODE' => $results['DOMCODE'][$key], 'DESCRIPTION' => $results['DESCRIPTION'][$key], 'UNIT' => $results['UNIT'][$key], 'TYPE' => $results['TYPE'][$key]);
}

$flipped = array_flip($allParams); //turn values into keys and vice versa
$res_mod_code = array_merge($flipped, $res_mod_code); // merge together. Keys are equally named, so that flipped values are replaced with res_mod_code values.
$res_mod_code = array_slice($res_mod_code, 0, count($allParams)); //delete the surplus that wasn't in allParamas and which is unneeded now
// end get all parameters 

// get Specimen ID 
$sql = "select scn_seqno from spec2events where ese_seqno = $necropsy_seqno";
$res = $db->query($sql);
if ($res->isError()) {
    $val->setError('globalerror', $res->errormessage());
}
$row = $res->fetch();
$specimenlink = $row == false ? 'init' : $row['SCN_SEQNO'];
// end get Specimen ID


// at page load.. nothing has been submitted yet 
if (!$this->isSubmitted()) {
// get Specimen Parameter(s)

    $sql = "select a.value, b.name, b.unit from specimen_values a, parameter_methods b
		where a.pmd_seqno = b.seqno and a.s2e_ese_seqno = :necropsy_seqno and a.s2e_scn_seqno = :scn_seqno";

    $binds = array(':necropsy_seqno' => $necropsy_seqno, ':scn_seqno' => $specimenlink);

    $res = $db->query($sql, $binds);

    if ($res->isError()) {
        $val->setError('globalerror', $res->errormessage());
    }

    while ($row = $res->fetch()) {
        $key = str_replace(' ', '_', $row['NAME'] . '_flow');
        $_POST[$key] = $row['VALUE'];
        $this->addPost($key);
    }

    // end get Specimen Parameter(s)
} else // when something has been submitted
{
    // by default the status is set to true

    $val->setStatus(true);

    foreach ($res_mod_code as $parameter_code => $parameter) {

//        $parameter_value = $_POST[str_replace(' ', '_', $parameter_code) . '_flow'];
        $parameter_value =$_POST[$parameter_code];
        if (!isset($parameter_value)) {
            continue;
        }

        // get parameter method seqno

        $sql = "select seqno from parameter_methods where code=:parameter_code";

        $bind = array(':parameter_code' => $parameter_code);

        $res = $db->query($sql, $bind);

        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage());
            continue;
        }

        $row = $res->fetch();

        $pmd_seqno = $row['SEQNO'];


        // check that the parameter has already a value, get the method under investigation
        $sql = "select count(*) as num_val,a.pmd_seqno from specimen_values a, parameter_methods b
where a.pmd_seqno = b.seqno and a.s2e_ese_seqno = :ese_seqno and a.s2e_scn_seqno = :scn_seqno
and b.code = :parameter_code group by a.pmd_seqno";

        $binds = array(':ese_seqno' => $necropsy_seqno, ':scn_seqno' => $specimenlink, ':parameter_code' => $parameter_code);

        $res = $db->query($sql, $binds);

        if (!$res->isError()) {
            $row = $res->fetch();


            if ($row['NUM_VAL'] == 1) {
                // if a parameter exist but the user empty the field
                if (strlen($parameter_value) == 0) {
                    $sql = "delete from specimen_values where pmd_seqno = :pmd_seqno and s2e_ese_seqno = :ese_seqno and s2e_scn_seqno = :scn_seqno";
                    $binds = array(':ese_seqno' => $necropsy_seqno, ':scn_seqno' => $specimenlink, ':pmd_seqno' => $pmd_seqno);

                    $res = $db->query($sql, $binds);

                    if ($res->isError()) {
                        $val->setError('globalerror', $res->errormessage());
                    }
                    continue;
                }
                // update corresponding parameter
                $sql = "update specimen_values set value = :value where pmd_seqno = :pmd_seqno and s2e_ese_seqno = :ese_seqno and
				       s2e_scn_seqno = :scn_seqno";

                $binds = array(':ese_seqno' => $necropsy_seqno, ':scn_seqno' => $specimenlink, ':pmd_seqno' => $pmd_seqno, ':value' => $parameter_value);

                $res = $db->query($sql, $binds);

                if ($res->isError()) {
                    $val->setError('globalerror', $res->errormessage());
                }
            } elseif ($row['NUM_VAL'] == 0 && strlen($parameter_value) > 0) {
                // insert corresponding parameter
                $sql = "insert into specimen_values(pmd_seqno,s2e_ese_seqno,s2e_scn_seqno,value,value_flag_ref) values (:pmd_seqno,
				:ese_seqno,:scn_seqno,:value,(select seqno from cg_ref_codes where rv_domain='VALUE_FLAG' and rv_low_value='1'))"; // it is assumed in first instance that the value is good


                $binds = array(':ese_seqno' => $necropsy_seqno, ':scn_seqno' => $specimenlink, ':pmd_seqno' => $pmd_seqno,
                    ':value' => $parameter_value);

                $res = $db->query($sql, $binds);

                if ($res->isError()) {
                    $val->setError('globalerror', $res->errormessage());
                }

            }
        } else {
            $val->setError('globalerror', $res->errormessage());
        }
    }
    if ($val->getStatus()) {
        $this->navigate();
        return;
    }
}

$var = $specimenlink; // variable declared in the include file
include(WebFunctions . 'autopsy_specimen_link.php');
?>
<form class='well <?php echo $this->flowname . '_form'; ?> default_form'>
    <fieldset id="global_parameter_fs">
        <?php
        // write all static parameters out of the specimen table
        ?>
        <legend>Global Parameter(s)</legend>
        <?php


        ?>

        <?php $type='';
        $printType=true;

        foreach ($res_mod_code as $parameter_code => $parameter) :// iterates over all parameters listed in the database
            $parameter_name = $parameter[0]['NAME'];
            if($type!==$parameter[0]['TYPE']){
                echo "<div class='qfrow'><h2>".$parameter[0]['TYPE']."</h2></div>";
            }
            $type=$parameter[0]['TYPE'];
            ?>

            <div class="qfrow">
                <div class="qfelement">
                    <label class="control-label"><?php echo $parameter_name . ": "; ?></label>
                    <?php
                    $parameter_name = $parameter_name . "_flow";
                    if (count($parameter) == 1) {
                        echo "<input type='text' class='specimen_attribute' name='$parameter_code' value='" . $val->getValue($parameter_name) . "'/>  <span class='unit'>" . $parameter[0]['UNIT'] . "</span>";
                    } else {
                        echo "<select class='specimen_attribute' name ='" . $parameter_code . "'>";
                        echo "<option></option>";
                        foreach ($parameter as $option) {
                            if ($option['DOMCODE'] == $val->getValue($parameter_name)) {
                                echo "<option selected='selected'>" . $option['DOMCODE'] . "</option>";
                                continue;
                            }

                            echo "<option>" . $option['DOMCODE'] . "</option>";
                        }
                        echo "</select>";
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class='errormessage'><?php echo $val->getError('globalerror'); ?></div>
    </fieldset>
    <?php echo $this->getButtons(); ?>
</form>

