<?php
/**
 *    Autopsy importation tool
 *  Medias Screen
 *  VERSION:1.0.0
 *  AUTHOR:DE WINTER JOHAN
 *  CREATED:20/04/2010
 *  LAST MODIFIED:20/04/2010
 */


date_default_timezone_set('Europe/Paris');
$ese_seqno = $this->getThread();
$year = date('Ymd');
$img_dir = "/uploads/ncy-$ese_seqno/";

require_once(Classes . 'import/flow_class.php');
require_once(Functions . 'Fixcoding.php');
include_once(Classes . 'upload/upload_class.php');
include_once(Classes . 'upload/Resize_class.php');

//  Set javascript & css files, to be loaded dynamically 
$css = "/legacy/css/autopsy_import/autopsy_medias.css";

$js = "/legacy/js/autopsy_import/autopsy_medias.js";


$val = $this->validation;
$upload = new Uploads($_SERVER['DOCUMENT_ROOT'] . '/' . $img_dir, 'add-edit');
$upload->setClass($this->flowname);
// upload files
$upload->UploadFiles($img_dir);


$upload_rs = new Resize($_SERVER['DOCUMENT_ROOT'] . '/' . $img_dir, $_SERVER['DOCUMENT_ROOT'] . '/' . $img_dir . 'thumb/');

$upload_rs->setImageSize(50, 50);

$auth = $this->auth;
$db = $this->db;
$val = $this->validation;
//$val->setStatus(false);
if (isset($_POST['button'])) {
    $val->set('button', $_POST['button'], 'notChoose', 'Required');
}
if (isset($_POST['autfileimgs'])) {
    $fileimgs = $_POST['autfileimgs'];
} else {
    $fileimgs = array();
}
// resize uploaded files
if ($upload->hasUploaded()) {
    $upload_rs->resizeImg($upload->getUploadedFiles());

    $resizedfiles = $upload_rs->getResizedFiles();

    // insert resized files links to database s
    foreach ($resizedfiles as $file) {
        $path_parts = pathinfo($file);
        $filename = $path_parts['filename'];
        $description = "uploaded via the autopsy importation tool";
        $psn_seqno = $auth->getSessionId();

        $mda_type = $path_parts['extension'];
        $location = $img_dir . 'thumb/' . $file;

        $sql = "insert into medias(psn_seqno,description,mda_type,location,ese_seqno,display) values(:psn_seqno,:description,:mda_type,:location,:ese_seqno,0)";
        $binds = array(':psn_seqno' => $psn_seqno, ':description' => $description, ':mda_type' => $mda_type, ':location' => $location, ':ese_seqno' => $ese_seqno);
        $db->query($sql, $binds);
        if ($db->isError()) {
            echo "<div class='errormessage'>$db->errormessage</div>";
            $val->setStatus(false);
        }
    }


}
echo $upload;
// display the images

$sql = "select * from medias where ese_seqno = :ese_seqno";
$bind = array(':ese_seqno' => $ese_seqno);

$res = $db->query($sql, $bind);
if ($db->isError()) {
    echo "<div class='errormessage'>$db->errormessage</div>";
    $val->setStatus(false);
}

?>
    <form class='well <?php echo $this->flowname . '_form'; ?>' method="POST" action='add-edit'>
        <fieldset>
            <legend>Images</legend>
            <?php
            while ($row = $res->fetch()) {
                $imgsrc = $row['LOCATION'];
                $path_parts = pathinfo($imgsrc);
                $basename = $path_parts['basename'];
                $filename = $path_parts['filename'];
                $display_row = $row['DISPLAY'];


                if (count($fileimgs) > 0 && !in_array($imgsrc, $fileimgs)) {
                    // delete from database
                    $sql = "delete from medias where ese_seqno = :ese_seqno and location = :location";
                    $binds = array(':ese_seqno' => $ese_seqno, ':location' => $imgsrc);
                    $db->query($sql, $binds);
                    if ($db->isError()) {
                        echo "<div class='errormessage'>delete unsuccessful</div>";
                        $val->setStatus(false);
                    }
                    // delete thumbnail
                    $old = getcwd(); // Save the current directory
                    chdir($_SERVER['DOCUMENT_ROOT'] . "/" . $path_parts['dirname']);
                    unlink($basename);
                    chdir(".."); // go to the image folder and delete also the image
                    unlink($basename);
                    //
                    chdir($old); // Restore the old working directory
                } else {
                    if (isset($_POST[$filename])) {
                        $val->setStatus(true);

                        $display_row = $_POST[$filename];
                        $sql = "update medias set display = :display where ese_seqno = :ese_seqno and location = :location";
                        $binds = array(':display' => $display_row, ':ese_seqno' => $ese_seqno, ':location' => $imgsrc);
                        $db->query($sql, $binds);
                        if ($db->isError()) {
                            echo "<div class='errormessage'>update unsuccessful</div>";
                            $val->setStatus(false);
                        }
                    }
                    $display = $display_row == 1 ? 'checked="yes"' : '';
                    echo "<div class='block'><div class='button_tools'>
		<button class='del' type='button'><img alt='Del' src='/legacy/img/cross.png'></button>
		<input type='checkbox' class='img_select' name='img_select' $display/>
		<input style='display:none;' value='$display_row' class='checksave' name = '$filename'/>
		</div><div class='image'><input style='display:none;' name = 'autfileimgs[]'value='$imgsrc'/><img alt='$filename' src='$imgsrc'></div></div>";
                }
            }
            ?>
            <input style='display:none;' name='autfileimgs[]' value=''/>
        </fieldset>
        <?php echo "<div>" . $this->getButtons() . "</div>"; ?>
    </form>
<?php
if ($val->getStatus()) {
    ob_end_clean();
    $this->navigate();
    return;
}


