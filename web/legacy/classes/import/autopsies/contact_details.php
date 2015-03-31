<?php
/**
 *    Autopsy importation tool
 *  Contact Details Screen
 *  VERSION:1.0.0
 *  AUTHOR:DE WINTER JOHAN
 *  CREATED:20/04/2010
 *  LAST MODIFIED:20/04/2010
 */

include_once(Classes . 'import/flow_class.php');

include_once(Functions . 'Fixcoding.php');

include_once(Functions . 'QueryEaser.php');

ob_start();

// Database Access

$db = $this->db;

//  Set javascript & css files, to be loaded dynamically 
$css = "css/autopsy_import/autopsy_contact_details.css";

$js = "js/autopsy_import/autopsy_contact_details.js";

$val = $this->validation;
$necropsy_seqno = $this->getThread();
if (!$necropsy_seqno) {
    $val->setError('globalerror', $this->FLOW_WARNING);
} else {

    $personDataArray = array('LAST_NAME' => '', 'FIRST_NAME' => '', 'SEQNO' => '');

    $autopsiersQ = new QueryEaser($this->db, "select a.* from persons a,groups b, person2groups c
where a.seqno = c.psn_seqno and b.name = c.grp_name and b.name in ('AUTOPSIER')", $personDataArray, null);
    $val->setError('globalerror', $autopsiersQ->error);
    $hidden_autopsiers = $autopsiersQ->resultArray;

    $autopsy_assistantsQ = new QueryEaser($this->db, "select a.* from persons a,groups b, person2groups c
where a.seqno = c.psn_seqno and b.name = c.grp_name and b.name in ('AUTOPSY_ASSISTANT')", $personDataArray, null);
    $val->setError('globalerror', $autopsy_assistantsQ->error);
    $hidden_assistants = $autopsy_assistantsQ->resultArray;

    $collectorsQ = new QueryEaser($this->db, "select a.* from persons a,groups b, person2groups c
where a.seqno = c.psn_seqno and b.name = c.grp_name and b.name in ('COLLECTOR')", $personDataArray, null);
    $val->setError('globalerror', $collectorsQ->error);
    $hidden_collectors = $collectorsQ->resultArray;

    function getHiddenInputValue($name)
    {
        $person_val = "";
        if (!isset($_POST[$name])) {
            $person_val = "";
        } elseif (is_array($_POST[$name])) {
            $person_val = array_filter($_POST[$name]); //no callback provided, removes all false values
        } elseif (is_string($_POST['person_opt'])) {
            $person_val = array_filter(array($_POST[$name]));
        }
        if ($person_val == "") {
            $contact_opt = null;
        } else {
            $contact_opt = $person_val;//array_merge($person_val, $institute_val);
        }
        return $contact_opt;
    }

    $autopsier_opt = getHiddenInputValue('autopsier_opt');
    $assistant_opt = getHiddenInputValue('assistant_opt');
    $collector_opt = getHiddenInputValue('collector_opt');

    $contact_opt = array('NB' => $autopsier_opt, 'AB' => $assistant_opt, 'CB' => $collector_opt);
    $val->set('autopsier_opt', $autopsier_opt, 'required', 'At least one autopsier must be specified');
//$val->set('contact_opt', $contact_opt, 'required', 'At least one contact must be specified');

    if ($val->getStatus() && $necropsy_seqno) {
        // In case all rules are validated

        // Check the existence of the person,institute link
        FOREACH ($contact_opt AS $e2pType => $groupArr) {
            $sql = "select psn_seqno from event2persons where ese_seqno = :ese_seqno and E2P_TYPE= :e2p_type";
            $bind = array(':ese_seqno' => $necropsy_seqno, ':e2p_type' => $e2pType);
            $res = $db->query($sql, $bind);
            if ($res->isError()) {
                $val->setError('globalerror', $res->errormessage());
            } else {
                $row = $res->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
                $psn_seqno = isset($row['PSN_SEQNO']) ? $row['PSN_SEQNO'] : array();

                $toinsert = array_diff($groupArr, $psn_seqno);
                $todelete = array_diff($psn_seqno, $groupArr);
                if (count($todelete) != 0) {
                    $bind_todelete = array(':ese_seqno' => $necropsy_seqno);
                    $bind_e2pType = array(':e2p_type' => $e2pType);
                    for ($i = 0; $i < count($todelete); $i++) {
                        $bind_todelete[":todelete$i"] = $todelete[$i];
                    }
                    $bindsql_todelete = '(' . implode(',', array_keys($bind_todelete)) . ')';
                    $sql = "delete from event2persons where ese_seqno = :ese_seqno and E2P_TYPE= :e2p_type and psn_seqno in $bindsql_todelete";
                    $res = $db->query($sql, array_merge($bind_todelete, $bind_e2pType));
                }
                if (count($toinsert) != 0) {
                    foreach ($toinsert as $item) {
                        $binds = array(':ese_seqno' => $necropsy_seqno, ':toinsert' => $item);

                        // The event2person type is supposed to be an observer
                        $sql = "insert into event2persons(ese_seqno,psn_seqno,e2p_type) values (:ese_seqno,:toinsert,'" . $e2pType . "')";
                        $res = $db->query($sql, $binds);
                        if ($res->isError()) {
                            $val->setError('globalerror', $res->errormessage() . 'DOMBO?');
                        }
                    }
                }
            }
        }
    }

// In case the user came from elsewhere in the thread ( at load time) 

    if ($this->getThread() != false && $val->getValue('autopsier_opt') == '' && $val->getValue('assistant_opt') == '' && $val->getValue('collector_opt') == '') {
        // select a person ( pseudo institutes are therefore excluded)
        $sql = "select psn_seqno from event2persons
			where ese_seqno = :ese_seqno
			and psn_seqno not in (select c.psn_seqno from institutes c)";
        $bind = array(':ese_seqno' => $necropsy_seqno);
        $res = $db->query($sql, $bind);
        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage());
        } else {

            while ($row = $res->fetch()) {
                isset($row['PSN_SEQNO']) ? $_POST['person_opt'][] = $row['PSN_SEQNO'] : '';
            }
        }
        // select pseudo institutes
        $sql = "select psn_seqno from event2persons
			where ese_seqno = :ese_seqno
			and psn_seqno in (select c.psn_seqno from institutes c)";
        $bind = array(':ese_seqno' => $necropsy_seqno);
        $res = $db->query($sql, $bind);
        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage());
        } else {
            while ($row = $res->fetch()) {
                isset($row['PSN_SEQNO']) ? $_POST['institute_opt'][] = $row['PSN_SEQNO'] : '';
            }
        }
    }
}

if ($val->getStatus()) {
    $this->navigate();
    return;
}

echo "<div class ='autopsy_hidden_autopsiers' style = 'display:none;'>" . json_encode($hidden_autopsiers) . "</div>";
echo "<div class ='autopsy_hidden_assistants' style = 'display:none;'>" . json_encode($hidden_assistants) . "</div>";
echo "<div class ='autopsy_hidden_collectors' style = 'display:none;'>" . json_encode($hidden_collectors) . "</div>";
?>
    <form class='<?php echo $this->flowname . '_form'; ?> default_form'>
        <input name='autopsier_opt' style='display:none;'/>
        <input name='assistant_opt' style='display:none;'/>
        <input name='collector_opt' style='display:none;'/>

        <div id="autopsy_contact_flow" class="ui-widget">
            <fieldset id="autopsy_contact_fs">
                <legend>Contact Details</legend>

                <div class="qfrow">
                    <div class="qfelement">
                        <label for="autopsy_autopsier_flow" class="qflabel">Autopsier</label>
                        <input type="text" id="autopsy_autopsier_flow" class="contact_attribute" name="autopsier_flow"/>
                        <button class="autopsy_addtab ui-state-default autopsier_btn" type="button"><span
                                class="ui-icon ui-icon-plus"></span></button>
                    </div>
                </div>
                <div class="qfrow">
                    <div class="qfelement">
                        <label for="autopsy_assistant_flow" class="qflabel">Assistant</label>
                        <input type="text" id="autopsy_assistant_flow" class="contact_attribute" name="assistant_flow"/>
                        <button class="autopsy_addtab ui-state-default assistant_btn" type="button"><span
                                class="ui-icon ui-icon-plus"></span></button>
                    </div>
                </div>
                <div class="qfrow">
                    <div class="qfelement">
                        <label for="autopsy_collector_flow" class="qflabel">Collector</label>
                        <input type="text" id="autopsy_collector_flow" class="contact_attribute" name="collector_flow"/>
                        <button class="autopsy_addtab ui-state-default collector_btn" type="button"><span
                                class="ui-icon ui-icon-plus"></span></button>
                    </div>
                </div>
                <div class="qfrow">
                    <div class="qfelement">
                        <label for="autopsy_multiselect_contact" class="qflabel"><span class="required">*</span>Selected
                            Contacts</label>
                        <select size="8" id='autopsy_multiselect_contact' multiple="">
                            <optgroup id="autopsy_autopsier_opt" label="Autopsiers">
                                <?php
                                $person_opt = $val->getValue('autopsier_opt'); // get a list of id's
                                //$institutes_opt = $val->getValue('institute_opt'); // get a list of id's
                                $inputs_autopsiers = "";
                                if (is_array($person_opt)) {
                                    $bind_persons = array();
                                    for ($i = 0; $i < count($person_opt); $i++) {
                                        $bind_persons[":person$i"] = $person_opt[$i];
                                    }
                                    $bindsql_persons = '(' . implode(',', array_keys($bind_persons)) . ')';
                                    $sql = "select * from persons where seqno in $bindsql_persons";
                                    $personDataArray = array('LAST_NAME' => '', 'SEQNO' => '');
                                    $autopsiersQ = new QueryEaser($this->db, $sql, $personDataArray, $bind_persons);

                                    if ($autopsiersQ->error) {
                                        $val->setError('globalerror', $autopsiersQ->error . 'dombo?');
                                    } else {
                                        $inputs_autopsiers = "";
                                        foreach ($autopsiersQ->resultArray as $person) {
                                            $seqno = $person['SEQNO'];
                                            $name = $person['LAST_NAME'];
                                            echo "<option pk='$seqno'>$name</option>";
                                            $inputs_autopsiers .= "<input name='autopsier_opt[]' style='display:none;' value='$seqno'>";
                                        }
                                        /*while ($row = $res->fetch()) {
                                            $seqno = $row['SEQNO'];
                                            $name = $row['LAST_NAME'];
                                            echo "<option pk='$seqno'>$name</option>";
                                            $inputs_autopsiers .= "<input name='autopsier_opt[]' style='display:none;' value='$seqno'>";
                                        }*/
                                    }
                                }
                                ?>
                            </optgroup>
                            <optgroup id="autopsy_assistant_opt" label="Assistants">
                                <?php
                                $person_opt = $val->getValue('assistant_opt'); // get a list of id's
                                //$institutes_opt = $val->getValue('institute_opt'); // get a list of id's
                                $inputs_assistants = "";
                                if (is_array($person_opt)) {
                                    $bind_persons = array();
                                    for ($i = 0; $i < count($person_opt); $i++) {
                                        $bind_persons[":person$i"] = $person_opt[$i];
                                    }
                                    $bindsql_persons = '(' . implode(',', array_keys($bind_persons)) . ')';
                                    $sql = "select * from persons where seqno in $bindsql_persons";
                                    $personDataArray = array('LAST_NAME' => '', 'SEQNO' => '');
                                    $assistantsQ = new QueryEaser($this->db, $sql, $personDataArray, $bind_persons);

                                    if ($assistantsQ->error) {
                                        $val->setError('globalerror', $assistantsQ->error . 'dombo??');
                                    } else {
                                        foreach ($assistantsQ->resultArray as $person) {
                                            $seqno = $person['SEQNO'];
                                            $name = $person['LAST_NAME'];
                                            echo "<option pk='$seqno'>$name</option>";
                                            $inputs_assistants .= "<input name='autopsier_opt[]' style='display:none;' value='$seqno'>";
                                        }
                                    }
                                }
                                ?>
                            </optgroup>
                            <optgroup id="autopsy_collector_opt" label="Collectors">
                                <?php
                                $person_opt = $val->getValue('collector_opt'); // get a list of id's
                                //$institutes_opt = $val->getValue('institute_opt'); // get a list of id's
                                $inputs_collectors = "";
                                if (is_array($person_opt)) {
                                    $bind_persons = array();
                                    for ($i = 0; $i < count($person_opt); $i++) {
                                        $bind_persons[":person$i"] = $person_opt[$i];
                                    }
                                    $bindsql_persons = '(' . implode(',', array_keys($bind_persons)) . ')';
                                    $sql = "select * from persons where seqno in $bindsql_persons";
                                    $personDataArray = array('LAST_NAME' => '', 'SEQNO' => '');
                                    $collectorsQ = new QueryEaser($this->db, $sql, $personDataArray, $bind_persons);

                                    if ($collectorsQ->error) {
                                        $val->setError('globalerror', $collectorsQ->error . ' ' . $collectorsQ->sql);
                                    } else {
                                        foreach ($collectorsQ->resultArray as $person) {
                                            $seqno = $person['SEQNO'];
                                            $name = $person['LAST_NAME'];
                                            echo "<option pk='$seqno'>$name</option>";
                                            $inputs_collectors .= "<input name='autopsier_opt[]' style='display:none;' value='$seqno'>";
                                        }
                                    }
                                }
                                ?>
                            </optgroup>
                        </select>
                        <?php echo $val->getError("autopsier_opt");
                        echo $val->getError("assistant_opt");
                        echo $val->getError("collector_opt");
                        echo $inputs_autopsiers;
                        echo $inputs_assistants;
                        echo $inputs_collectors;
                        ?>
                    </div>
                </div>
            </fieldset>
            <div class='errormessage'><?php echo $val->getError('globalerror'); ?></div>
            <?php echo $this->getButtons(); ?>
    </form>

<?php include(Functions . 'endimport.php'); ?>