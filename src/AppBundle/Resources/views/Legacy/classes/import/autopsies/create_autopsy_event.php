<?php
/**
 *    Autopsy importation tool
 *  Create Autopsy Event Screen
 *  VERSION:1.0.0
 *  AUTHOR:DE WINTER JOHAN
 *  CREATED:20/04/2010
 *  LAST MODIFIED:20/04/2010
 */

include_once(Classes . 'import/flow_class.php');

include_once(Functions . 'Fixcoding.php');


// Database Access

$db = $this->db;

date_default_timezone_set('Europe/Paris');

$year = idate('Y');
$months = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'october', 'november', 'december');

// VALIDATION RULES
$val = $this->validation;

$year_date=null;
$month_date=null;
$day_date=null;
$date_flag_ref=null;
$autopsy_reference=null;

if(array_key_exists('year_date',$_POST)){
    $year_date=array($_POST['year_date']);
}
if(array_key_exists('month_date',$_POST)){
    $month_date=array($_POST['month_date']);
}
if(array_key_exists('day_date',$_POST)){
    $day_date=array($_POST['day_date']);
}
if(array_key_exists('date_flag_ref',$_POST)){
    $date_flag_ref=array($_POST['date_flag_ref']);
}
if(array_key_exists('Autopsy_reference',$_POST)){
    $autopsy_reference=array($_POST['Autopsy_reference']);
}

$val->set('date_test', array($year_date[0], $month_date[0],  $day_date[0]), 'checkdate');
$val->set('date_flag_ref', $date_flag_ref, 'notChoose', 'Required');
$val->set('Autopsy_reference', $autopsy_reference, 'required', 'Required');

/*if (strlen($val->getValue('time_flow')) != 0) // In case a time is specified
{
    $val->set('time_flag', $_POST['time_flag'], 'notChoose', 'Required');
}*/
// if all conditions are satisfied 
if ($val->getStatus()) {

    $date = date('d-M-Y', strtotime($val->getValue('day_date') . ' ' . $val->getValue('month_date') . ' ' . $val->getValue('year_date')));

    $date_flag_ref = $val->getValue('date_flag_ref');

    $time_event = isset($_POST['time_flow']) ? $_POST['time_flow'] : '12:00';

    $time = date('H-i', strtotime($time_event));

    //$time_flag = '1';  // set by default to 1

    /*if (!isset($_POST['time_flow']) && $val->getValue('time_flag') == 'Choose') {
        $time_flag = 0;
    } // corresponding to no quality control*/

    $eventdescription = $val->getValue('eventdescription');

    $event_format = "DD-Mon-YYYY HH24:MI";

    $event_datetime = $date . ' ' . $time;

    $ref_aut = $val->getValue('Autopsy_reference');;

    $ref_labo = $val->getValue('ref_labo');

    $program = $val->getValue('Program');

    //$bind_event = array(':event_datetime' => $event_datetime, ':date_flag_ref' => $date_flag_ref, ':description' => $eventdescription, ':time_flag' => $time_flag);

    $bind_event = array(':event_datetime' => $event_datetime, ':date_flag_ref' => $date_flag_ref, ':description' => $eventdescription);

    $bind_necropsy = array(':ref_aut' => $ref_aut, ':ref_labo' => $ref_labo, ':program' => $program);

    if ($this->getThread() == false) // In case an autopsy isn't already started => insert
    {
        //$sql = "insert into event_states(EVENT_DATETIME,EVENT_DATETIME_FLAG_REF,TIME_FLAG,DESCRIPTION) VALUES (to_date(:event_datetime,'$event_format'),:date_flag_ref,:time_flag,:description)";
        $sql = "insert into event_states(EVENT_DATETIME,EVENT_DATETIME_FLAG_REF,DESCRIPTION) VALUES (to_date(:event_datetime,'$event_format'),:date_flag_ref,:description)";


        $res = $db->query($sql, $bind_event);

        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage());
        }

        // THREAD REGISTRATION

        /*$sql = "select cc_next_value-1 as new_event from cg_code_controls where CC_DOMAIN='ESE_SEQ'";
        $res = $db->query($sql);
        $row = $res->fetch();
        $new_event = $row['NEW_EVENT'];*/


        $new_event_seqno=$db->query("select event_states_seq.currval from dual")->fetch();
        $this->thread = $new_event_seqno['CURRVAL'];

        // INSERT CORRESPONDING OBSERVATION

        $sql = "insert into necropsies(ESE_SEQNO,REF_AUT,REF_LABO,PROGRAM) values (event_states_seq.currval,:ref_aut,:ref_labo,:program)";

        $res = $db->query($sql, $bind_necropsy);
        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage());
        }

    } else // => update
    {
        $event_toupdate = $this->getThread();
        // UPDATE EVENT

        //$sql = "update event_states set EVENT_DATETIME=to_date(:event_datetime,'$event_format'), EVENT_DATETIME_FLAG_REF=:date_flag_ref,TIME_FLAG=:time_flag,DESCRIPTION=:description where seqno = '$event_toupdate'";
        $sql = "update event_states set EVENT_DATETIME=to_date(:event_datetime,'$event_format'), EVENT_DATETIME_FLAG_REF=:date_flag_ref,DESCRIPTION=:description where seqno = '$event_toupdate'";
        $res = $db->query($sql, $bind_event);

        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage());
        }

        // UPDATE OBSERVATION
        $sql = "update necropsies set  REF_AUT=:ref_aut,REF_LABO=:ref_labo,PROGRAM=:program where ese_seqno = '$event_toupdate'";

        $res = $db->query($sql, $bind_necropsy);
        if ($res->isError()) {
            $val->setError('globalerror', $res->errormessage());
        }

    }
    // after the update or the insert, then check if nothing went wrong
    // in case of a success, then navigate
    if ($val->getStatus()) {
        $this->navigate();
        return;
    }

}
if ($this->getThread() != false && !isset($_POST['year_date'])) {
    $eventthread = $this->getThread();
    //$sql = "select to_char(EVENT_DATETIME, 'DD-MM-YYYY') as EVENT_DATETIME,to_char(EVENT_DATETIME, 'HH24:MI') as EVENT_TIME,date_flag_ref,time_flag,description from event_states where seqno = '$eventthread'";
    $sql = "select to_char(EVENT_DATETIME, 'DD-MM-YYYY') as EVENT_DATE,to_char(EVENT_DATETIME, 'HH24:MI') as EVENT_TIME,EVENT_DATETIME_flag_ref,description from event_states where seqno = '$eventthread'";

    $row = array();
    $res = $db->query($sql);
    if ($res->isError()) {
        $val->setError('globalerror', $res->errormessage());
    } else {
        $row = $res->fetch();
    }

    $event_datetime = explode('-', $row['EVENT_DATE']);

    $_POST['day_date'] = $event_datetime[0];
    $_POST['month_date'] = $months[$event_datetime[1] - 1];
    $_POST['year_date'] = $event_datetime[2];
    $_POST['time_flow'] = $row['EVENT_TIME'];
    $_POST['date_flag_ref'] = $row['EVENT_DATETIME_FLAG_REF'];
    $_POST['eventdescription'] = $row['DESCRIPTION'];

    $sql = "select ref_labo,ref_aut,program from necropsies where ese_seqno='$eventthread'";
    $res = $db->query($sql);
    if ($res->isError()) {
        $val->setError('globalerror', $res->errormessage());
    } else {
        $row = $res->fetch();
        $_POST['ref_labo'] = $row['REF_LABO'];
        $_POST['Program'] = $row['PROGRAM'];
        $_POST['Autopsy_reference'] = $row['REF_AUT'];

    }

}
// Fill the select
$months = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'october', 'november', 'december');
$year_select = "";

for ($i = $year; $i > $year - 100; $i--) {
    if ($i == $val->getValue("year_date")) {
        $year_select .= '<option selected="selected" value="' . $i . '">' . $i . '</option>';
    } else {
        $year_select .= '<option value="' . $i . '">' . $i . '</option>';
    }
}
$month_select = "";
for ($i = 0; $i < 11; $i++) {
    if ($months[$i] == $val->getValue("month_date")) {
        $month_select .= '<option selected="selected" value="' . $months[$i] . '">' . $months[$i] . '</option>';
    } else {
        $month_select .= '<option value="' . $months[$i] . '">' . $months[$i] . '</option>';
    }
}
$day_select = "";
for ($i = 1; $i <= 31; $i++) {
    if ($i == $val->getValue("day_date")) {
        $day_select .= '<option selected="selected" value="' . $i . '">' . $i . '</option>';
    } else {
        $day_select .= '<option value="' . $i . '">' . $i . '</option>';
    }
}


$sql = "select rv_meaning,rv_low_value,seqno from cg_ref_codes where rv_domain = 'VALUE_FLAG'";

$r = $db->query($sql);

//$time_flag = "";
$date_flag_ref = "";
$precision_flag = "";
if (!$r->isError()) {
    while ($row = $r->fetch()) {
        if ($row['SEQNO'] == $val->getValue('precision_flag')) {
            $precision_flag .= '<option selected="selected" value="' . $row['SEQNO'] . '">' . $row['RV_MEANING'] . '</option>';
        } else {
            $precision_flag .= '<option  value="' . $row['SEQNO'] . '">' . $row['RV_MEANING'] . '</option>';
        }
        /*if ($row['SEQNO'] == $val->getValue('time_flag')) {
            $time_flag .= '<option selected="selected" value="' . $row['SEQNO'] . '">' . $row['RV_MEANING'] . '</option>';
        } else {
            $time_flag .= '<option  value="' . $row['SEQNO'] . '">' . $row['RV_MEANING'] . '</option>';
        }*/
        if ($row['SEQNO'] == $val->getValue('date_flag_ref')) {
            $date_flag_ref .= '<option selected="selected" value="' . $row['SEQNO'] . '">' . $row['RV_MEANING'] . '</option>';
        } else {
            $date_flag_ref .= '<option  value="' . $row['SEQNO'] . '">' . $row['RV_MEANING'] . '</option>';
        }
    }
}
?>
<form class='<?php echo $this->flowname . '_form'; ?> default_form event_state'>
    <fieldset>
        <legend>Autopsy Details</legend>
        <div class="qfrow">
            <div class="qfelement">
                <label class="qflabel" for="Autopsy_reference-0"><span class="required">*</span>Autopsy
                    reference:</label>
                <input type="text" style="width: 100px;" name="Autopsy_reference" id="Autopsy_reference-0"
                       value="<?php echo $val->getValue('Autopsy_reference'); ?>"/><?php echo $val->getError("Autopsy_reference") ?>
            </div>
        </div>
        <div class="qfrow">
            <div class="qfelement">
                <label class="qflabel" for="Autopsy_labo-0">Labo reference:</label>
                <input type="text" style="width: 100px;" name="ref_labo" id="Autopsy_labo-0"
                       value="<?php echo $val->getValue('ref_labo'); ?>"/>
            </div>
        </div>
        <div class="qfrow">
            <div class="qfelement">
                <label class="qflabel" for="Program-0">Program:</label>
                <input type="text" style="width: 100px;" name="Program" id="Program-0"
                       value="<?php echo $val->getValue('Program'); ?>"/>
            </div>
        </div>
    </fieldset>
    <fieldset id="autopsy_date_fs">
        <legend>Event State</legend>
        <div class="qfrow">
            <div class="qfelement twodiv">
                <label class="qflabel"><span class="required">*</span>Date:</label>
                <select class="year_date" name="year_date">
                    <option value="">Year</option><?php echo $year_select; ?></select>
                <select class="month_date" name="month_date">
                    <option value="">Month</option><?php echo $month_select; ?></select>
                <select class="day_date" name="day_date">
                    <option value="">Day</option><?php echo $day_select; ?></select>
                <button id="today" type="button">Today</button>
                <?php echo $val->getError("date_test") ?>
            </div>
            <div class="qfelement twodiv">
                <label for="autopsy_Date_flag-0" class="qflabel"><span class="required">*</span>Date flag:</label>
                <select id="autopsy_Date_flag-0" name="date_flag_ref">
                    <option value='Choose'>Choose</option>
                    <?php echo $date_flag_ref; ?>
                </select>
                <?php echo $val->getError("date_flag_ref") ?>
            </div>
        </div>
        <div class="qfrow">
            <div class="qfelement twodiv">
                <label for="autopsy_time_flow" class="qflabel">Time:</label>
                <input id="autopsy_time_flow" name="time_flow" value="<?php echo $val->getValue('time_flow'); ?>"/>
            </div>
            <div class="qfelement twodiv" style='visibility:hidden;'>
                <label for="autopsy_Time_flag-0" class="qflabel">Time flag:</label>
                <?php
                echo "<select  id='autopsy_Time_flag-0' name='time_flag'><option value='1'>good value</option></select>";
                //echo "<select  id='autopsy_Time_flag-0' name='time_flag'><option value='Choose'>Choose</option>  $time_flag</select>";
                ?>
                <?php echo $val->getError("time_flag") ?>
            </div>
        </div>
        <div class="qfrow">
            <div class="qfelement">
                <label for="autopsy_event_description-0" class="qflabel">Description:</label>
<textarea id="autopsy_event_description-0" name="eventdescription" rows="2" cols="20">
<?php echo $val->getValue('eventdescription'); ?>
</textarea>
            </div>
        </div>
    </fieldset>
    <div class='errormessage'><?php echo $val->getError('globalerror'); ?></div>
    </fieldset>
    <?php echo $this->getButtons(); ?>
</form>

