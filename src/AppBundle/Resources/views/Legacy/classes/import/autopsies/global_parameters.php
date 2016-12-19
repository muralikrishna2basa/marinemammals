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

$basicParams = array('DECO', 'FROZ', 'AGE', 'LENG', 'WEIG', 'NUTS', 'BLUD', 'BLUM', 'BLUV', 'STOM');

$basicParamsStr = "'" . implode("','", $basicParams) . "'";

$codParams = array('CODP');

$codParamsStr = "'" . implode("','", $codParams) . "'";

$externalPathParams = array('LEBITE', 'LEBROB', 'LECUTS', 'LEENLE', 'LEFINA', 'LEHBIT', 'LEHCUT', 'LEHNET', 'LEHOPW', 'LEHPOX', 'LEHYPO', 'LENETM', 'LENETP', 'LENETS', 'LENETT', 'LEOPEN', 'LEOTH', 'LESCBI', 'LESCPI', 'LESTAB', 'OTHEXT', 'OTHFIS', 'OTHFRO', 'OTHOIL', 'OTHPRE', 'OTHREM', 'REMA');

$allParams = array_merge($basicParams, $codParams, $externalPathParams);
$sql = "select a.name,a.unit,a.code as code, b.code as domcode,a.description,case when a.code in (" . $basicParamsStr . ") then 'Measurements' else case when a.code in (" . $codParamsStr . ") then 'Summary' else 'External examination' end end as type  from parameter_methods a,parameter_domains b where b.pmd_seqno (+)= a.seqno and a.origin = 'SCN' order by a.name";

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

foreach ($res_mod_code as $parameter_code => $parameter_value) {
    $i = 0;
    foreach ($parameter_value as $parameter_value_el) {
        $match = explode('::', $parameter_value[$i]["NAME"]);
        //preg_match('/^(.*?)(::.*?)(::.*)?/', $parameter_value[$i]["NAME"], $match_a);

        if (strpos($parameter_value[$i]["NAME"], '::') == false) {
            $res_mod_code[$parameter_code][$i]["PARAMETER"] = $match[0];
            $res_mod_code[$parameter_code][$i]["CATEGORY"] = '';
            $res_mod_code[$parameter_code][$i]["SUBCATEGORY"] = '';
        } else {
            $res_mod_code[$parameter_code][$i]["CATEGORY"] = $match[0];
            $res_mod_code[$parameter_code][$i]["SUBCATEGORY"] = isset($match[2]) && $match[2] !== '' ? $match[1] : null;
            $res_mod_code[$parameter_code][$i]["PARAMETER"] = isset($match[2]) && $match[2] !== '' ? $match[2] : (isset($match[1]) && $match[1] !== '' ? $match[1] : null);
        }
    }
    uasort($res_mod_code[$parameter_code], function ($a, $b) {
        $codea = isset($a["DOMCODE"]) ? $a["DOMCODE"] : '';
        $codeb = isset($b["DOMCODE"]) ? $b["DOMCODE"] : '';
        return strcmp($codea, $codeb);
    });
    $i++;
}

move_item($res_mod_code, 'LEHYPO', 'down', 'LEFINA');
move_item($res_mod_code, 'LEOPEN', 'down', 'LEHYPO');
move_item($res_mod_code, 'LEOTH', 'down', 'LEOPEN');
move_item($res_mod_code, 'LESTAB', 'down', 'LEOPEN');
move_item($res_mod_code, 'LENETM', 'down', 'LEOTH');
move_item($res_mod_code, 'LENETP', 'down', 'LENETM');
move_item($res_mod_code, 'LENETS', 'down', 'LENETP');
move_item($res_mod_code, 'LENETS', 'down', 'LENETP');
move_item($res_mod_code, 'LENETT', 'down', 'LENETS');
move_item($res_mod_code, 'LESCBI', 'down', 'LENETT');
move_item($res_mod_code, 'LESCPI', 'down', 'LENETT');
/*usort($res_mod_code, function ($a, $b) {
    $cata=isset($a[0]["CATEGORY"])?$a[0]["CATEGORY"]:'';
    $catb=isset($b[0]["CATEGORY"])?$b[0]["CATEGORY"]:'';
    $subcata=isset($a[0]["SUBCATEGORY"])?$a[0]["SUBCATEGORY"]:'';
    $subcatb=isset($b[0]["SUBCATEGORY"])?$b[0]["SUBCATEGORY"]:'';
    return strcmp($a[0]["TYPE"] . $cata . $subcata. $a[0]["PARAMETER"], $b[0]["TYPE"] . $catb .$subcatb. $b[0]["PARAMETER"]);
});*/


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


// at page load  (nothing has been submitted yet) or when page is reloaded
//if (!$this->isSubmitted()) {
//if($this->getThread() != false){
// get Specimen Parameter(s)

$sql = "select a.value, b.name, b.unit, b.code, c.rv_low_value as flag from specimen_values a, parameter_methods b, cg_ref_codes c
		where a.pmd_seqno = b.seqno and a.s2e_ese_seqno = :necropsy_seqno and a.s2e_scn_seqno = :scn_seqno and c.seqno=a.value_flag_ref";

$binds = array(':necropsy_seqno' => $necropsy_seqno, ':scn_seqno' => $specimenlink);

$res = $db->query($sql, $binds);

if ($res->isError()) {
    $val->setError('globalerror', $res->errormessage());
}

while ($row = $res->fetch()) {
    $key = str_replace(' ', '_', $row['NAME'] . '_flow');
    $_POST[$key] = $row['VALUE'];
    $this->addPost($key);

    $flag_key = str_replace(' ', '_', $row['CODE'] . '_flag');
    $_POST[$flag_key] = $row['FLAG'];
    $this->addPost($flag_key);
}

// end get Specimen Parameter(s)
//} else // when something has been submitted
if ($this->isSubmitted()) {
    // by default the status is set to true

    $val->setStatus(true);

    foreach ($res_mod_code as $parameter_code => $parameter) {

//        $parameter_value = $_POST[str_replace(' ', '_', $parameter_code) . '_flow'];
        $parameter_value = $_POST[$parameter_code];
        $parameter_value_flag = $_POST[$parameter_code . '_flag'];
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
                // update corresponding parameter value
                $sql = "update specimen_values set value = :value where pmd_seqno = :pmd_seqno and s2e_ese_seqno = :ese_seqno and
				       s2e_scn_seqno = :scn_seqno";

                $binds = array(':ese_seqno' => $necropsy_seqno, ':scn_seqno' => $specimenlink, ':pmd_seqno' => $pmd_seqno, ':value' => $parameter_value);

                $res = $db->query($sql, $binds);

                if ($res->isError()) {
                    $val->setError('globalerror', $res->errormessage());
                }
                // update corresponding parameter value flag
                $sql = "update specimen_values set VALUE_FLAG_REF = (select seqno from cg_ref_codes where rv_domain='VALUE_FLAG' and rv_low_value=:value_flag) where pmd_seqno = :pmd_seqno and s2e_ese_seqno = :ese_seqno and
				       s2e_scn_seqno = :scn_seqno";

                $binds = array(':ese_seqno' => $necropsy_seqno, ':scn_seqno' => $specimenlink, ':pmd_seqno' => $pmd_seqno, ':value_flag' => $parameter_value_flag);

                $res = $db->query($sql, $binds);

                if ($res->isError()) {
                    $val->setError('globalerror', $res->errormessage());
                }
            } elseif (strlen($parameter_value) > 0) {
                if (!isset($parameter_value_flag) || $parameter_value_flag === '') {
                    $parameter_value_flag = 1;// it is assumed in first instance that the value is good
                }
                // insert corresponding parameter
                $sql = "insert into specimen_values(pmd_seqno,s2e_ese_seqno,s2e_scn_seqno,value,value_flag_ref) values (:pmd_seqno,
				:ese_seqno,:scn_seqno,:value,(select seqno from cg_ref_codes where rv_domain='VALUE_FLAG' and rv_low_value=:value_flag))";


                $binds = array(':ese_seqno' => $necropsy_seqno, ':scn_seqno' => $specimenlink, ':pmd_seqno' => $pmd_seqno,
                    ':value' => $parameter_value, ':value_flag' => $parameter_value_flag);

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

function move_item(&$ref_arr, $key1, $move, $key2 = null)
{
    $arr = $ref_arr;
    if ($key2 == null) $key2 = $key1;
    if (!isset($arr[$key1]) || !isset($arr[$key2])) return false;

    $i = 0;
    foreach ($arr as &$val) $val = array('sort' => (++$i * 10), 'val' => $val);

    if (is_numeric($move)) {
        if ($move == 0 && $key1 == $key2) return true;
        elseif ($move == 0) {
            $tmp = $arr[$key1]['sort'];
            $arr[$key1]['sort'] = $arr[$key2]['sort'];
            $arr[$key2]['sort'] = $tmp;
        } else $arr[$key1]['sort'] = $arr[$key2]['sort'] + ($move * 10 + ($key1 == $key2 ? ($move < 0 ? -5 : 5) : 0));
    } else {
        switch ($move) {
            case 'up':
                $arr[$key1]['sort'] = $arr[$key2]['sort'] - ($key1 == $key2 ? 15 : 5);
                break;
            case 'down':
                $arr[$key1]['sort'] = $arr[$key2]['sort'] + ($key1 == $key2 ? 15 : 5);
                break;
            case 'top':
                $arr[$key1]['sort'] = 5;
                break;
            case 'bottom':
                $arr[$key1]['sort'] = $i * 10 + 5;
                break;
            default:
                return false;
        }
    }
    uasort($arr, function ($a, $b) {
        return $a['sort'] > $b['sort'];
    });
    foreach ($arr as &$val) $val = $val['val'];
    $ref_arr = $arr;
    return true;
}

$var = $specimenlink; // variable declared in the include file
include(WebFunctions . 'autopsy_specimen_link.php');
?>
<form name="<?php echo $this->flowname; ?>" class='well <?php echo $this->flowname . '_form'; ?> default_form'>
    <fieldset id="global_parameter_fs">
        <?php
        // write all static parameters out of the specimen table
        ?>
        <legend>General information</legend>
        <?php


        ?>

        <?php $type = '';

        $printType = true;
        $category = '';
        $subcategory = '';
        $matches = array();
        foreach ($res_mod_code as $parameter_code => $parameter) :// iterates over all parameters listed in the database
            $parameter_name = $parameter[0]['NAME'];
            if ($type !== $parameter[0]['TYPE']) {
                echo "<h2>" . $parameter[0]['TYPE'] . "</h2>";
            }
            $type = $parameter[0]['TYPE'];
            ?>

            <?php
            if ($type === 'External examination') {

                if ($category !== $parameter[0]['CATEGORY']) {
                    $category = $parameter[0]['CATEGORY'];
                    echo "<h4>" . $category . "</h4>";
                }
                if ($subcategory !== $parameter[0]['SUBCATEGORY']) {
                    $subcategory = $parameter[0]['SUBCATEGORY'];
                    echo "<h5>" . $subcategory . "</h5>";
                }
                if ($parameter[0]['PARAMETER'] !== '') {
                    $parameter_name = $parameter[0]['PARAMETER'];
                }
            }
            ?>
            <div class="form-group" style="display: inline-block;">
                <label class="control-label" style="width: 120px;margin-right: 10px;
text-align: right;display: inline-block;"><?php echo $parameter_name . ": "; ?></label>
                <?php
                $parameter_name = $parameter_name . "_flow";
                if (count($parameter) == 1) {
                    if ($parameter[0]['UNIT'] != 'NA') {
                        echo "<input type='text' class='specimen_attribute' name='$parameter_code' value='" . $val->getValue($parameter_name) . "'/>  <span class='unit'>" . $parameter[0]['UNIT'] . "</span>";
                    } else {
                        echo "<textarea name='$parameter_code' class='specimen_attribute' maxlength='150' value='" . $val->getValue($parameter_name) . "' rows='10' cols='50'>" . $val->getValue($parameter_name) . "</textarea><span class='text-danger''>150 characters</span>";
                    }

                } else {
                    echo "<select class='specimen_attribute' name ='" . $parameter_code . "'>";
                    echo "<option></option>";
                    foreach ($parameter as $option) {
                        $value = $val->getValue($parameter_name);

                        if ($option['DOMCODE'] == $value) {
                            echo "<option value='" . $option['DOMCODE'] . "' selected>" . $option['DOMCODE'] . "</option>";
                            continue;
                        }

                        echo "<option value='" . $option['DOMCODE'] . "'>" . $option['DOMCODE'] . "</option>";
                    }
                    echo "</select>";
                }
                $value_flag = $val->getValue($parameter_code . '_flag');
                if ($parameter_code === 'CODP') {

                    echo "<select class='specimen_attribute' name ='" . $parameter_code . "_flag'>";
                    echo "<option value=''>Select...</option>";
                    echo "<option value='0' " . (('0' === $value_flag) ? 'selected' : '') . ">No quality control</option>";
                    echo "<option value='1' " . (('1' === $value_flag) ? 'selected' : '') . ">good value</option>";
                    echo "<option value='2' " . (('2' === $value_flag) ? 'selected' : '') . ">Probably good</option>";
                    echo "<option value='3' " . (('3' === $value_flag) ? 'selected' : '') . ">Probably bad value</option>";
                    echo "<option value='4' " . (('4' === $value_flag) ? 'selected' : '') . ">Bad value</option>";
                    echo "<option value='5' " . (('5' === $value_flag) ? 'selected' : ''). ">Changed value</option>";
                    echo "<option value='6' " . (('6' === $value_flag) ? 'selected' : '') . ">value below detection</option>";
                    echo "<option value='7' " . (('7' === $value_flag) ? 'selected' : '') . ">Value in excess</option>";
                    echo "<option value='8' " . (('8' === $value_flag) ? 'selected' : '') . ">Interpolated value</option>";
                    echo " <option value='9' " . (('9' === $value_flag) ? 'selected' : '') . ">Missing value</option>";
                    echo " <option value='A' " . (('A' === $value_flag) ? 'selected' : '') . ">Value phenomenon uncertain</option>";

                    echo "</select>";
                }
                ?>
            </div>
        <?php endforeach; ?>
        <div class='errormessage'><?php echo $val->getError('globalerror'); ?></div>
    </fieldset>
    <?php echo $this->getButtons(); ?>

</form>

