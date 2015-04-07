<?php

/**
 *    Class Upload v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 *  Details:
 * ---------
 *
 *
 *
 */
class Upload
{
    /**
     * Upload destination folder
     *
     * @var string
     */
    protected $folderdir;


    /**
     * maximum filename size
     *
     * @var integer
     */
    protected $maxfilename = 30;
    /**
     * Contain the filename actually downloaded in $folderdir might differ from filename to upload
     *
     * @var unknown_type
     */
    protected $filename;
    /**
     * Max file size
     *
     * @var integer
     */
    protected $maxsize = 2000000; // 2MB

    /**
     * Array of possible extensions for each type of files
     *
     * @var unknown_type
     */
    public $extensions = array();

    /**
     * If set to false, then files with names matching the destination directory will not be uploaded
     *
     * @var unknown_type
     */
    public $overwrite = false; // temporarely set to  true ( debugging purposes)

    /**
     * Error trigger
     *
     * @var bool
     */
    public $isError = false;

    /**
     * Error message
     *
     * @var string
     */
    public $errormessage;
    /**
     * List of error messages, directly exported from php.net
     *
     * @var array
     */
    public $errormessages = array();

    public function __construct($folderdir, $overwrite = false)
    {
        // Perform a directory check
        if ($this->checkDir($folderdir) == true) {
            $this->folderdir = $folderdir;
        }
        // Set the overwrite mode
        $this->overwrite = $overwrite;
        // init extensions
        $this->InitExtensions();
        // init errormessages
        $this->InitErrorFiles();

    }

    public function setMaxSize($size)
    {
        if (is_integer($size)) {
            $this->maxsize = $size;
        }
    }

    public function setMaxFilenameSize($size)
    {
        if (is_integer($size)) {
            $this->maxfilename = $size;
        }
    }

    protected function UploadFile($file)
    {

        $filename = $this->CheckFile($file);// new filename
        $this->filename = $filename;
        if ($filename == false) {
            return false;
        }

        $filetmp = $this->getTmpFilename($file);

        if (is_uploaded_file($filetmp) == false) {
            $this->isError = true;
            $this->errormessage = $this->errormessages[14];
            return false;
        }

        $filenew = $this->folderdir . $filename;

        if (move_uploaded_file($filetmp, $filenew) == true) {
            umask(0);
            if (chmod($filenew, 0644) == false) {
                $this->isError = true;
                $this->errormessage = $this->errormessages[15];
                return false;
            }

        } else {
            $this->isError = true;
            $this->errormessage = $this->errormessages[16];
            return false;
        }


        return true;
    }


    /**
     * Check file validity
     * file is an item from the $_FILES variable containing ( error,name,size,tmp_name,type)
     * @param array $file
     * @return bool or filename
     */
    protected function CheckFile($file)
    {
        // check html errors
        if ($file['error'] != 0) {
            $this->isError = true;
            $this->errormessage = $this->errormessages[$file['error']];
            return false;
        }

        // compare file size to limit

        // might be removed later since a check is already performed by php on form submission
        if ($this->maxsize < $this->getSize($file)) {
            $this->isError = true;
            $this->errormessage = $this->errormessages[10];
            return false;
        }

        if ($this->CheckExt($file) == false) {
            $this->isError = true;
            $this->errormessage = $this->errormessages[11];
            return false;
        }

        $filename = $this->setFilename($file);
        // check filename size
        if (strlen($filename) > $this->maxfilename) {
            $this->isError = true;
            $this->errormessage = $this->errormessages[12];
            return false;
        }
        // check if file already exists
        if ($this->overwrite == false && $this->doesFileExists($filename) == true) {
            $this->isError = true;
            $this->errormessage = $this->errormessages[13];
            return false;
        }
        return $filename;
    }

    /**
     * Check extension validity
     *
     * @param array $file
     * @return bool
     */
    protected function CheckExt($file)
    {
        $extfile = $this->getExtension($file);
        foreach ($this->extensions as $extension) {
            if (in_array($extfile, $extension)) {
                return true;
            }
        }
        return false;
    }

    protected function getTmpFilename($file)
    {
        return $file['tmp_name'];
    }

    protected function getSize($file)
    {
        return filesize($file['tmp_name']);
    }

    protected function getExtension($file)
    {
        return strtolower(str_replace('.', '', strrchr($file['name'], '.')));
    }

    protected function getFilename($file)
    {
        return basename($file['name']);
    }

    /**
     * If the folder directory is not created, then do an attempt by creating it
     *
     * @return unknown
     */
    protected function checkDir($folderdir)
    {
        if (!is_dir($folderdir)) {
            umask(0);
            return mkdir($folderdir, 0777);

        }
        return true;
    }

    /**
     * Check whether the file exists in the destination directory
     *
     * @param array $file
     * @return bool
     */
    protected function doesFileExists($filename)
    {
        return file_exists($this->folderdir . $filename);
    }

    /**
     *
     *
     * @param array $file
     * @return string
     */
    protected function setFilename($file)
    {
        $fileName = $this->getFilename($file);
        // replace special characters by its alphabetic correspondance
        $fileName = strtr($fileName, '����������������������������������������������������', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        // replace spaces && other by - avoid problems with linux systems
        return preg_replace('/([^.a-z0-9]+)/i', '-', $fileName);
    }

    /**
     * Render the upload form, using a specific css file
     *
     */
    public function __toString()
    {

    }

    protected function InitExtensions()
    {
        $this->extensions = array('picture' => array('jpg', 'png', 'jpeg', 'gif'),
            'document' => array('doc', 'odx', 'txt', 'xls', 'pdf'),
            'movie' => array('avi,wmv'),
            'archive' => array('zip', 'rar', 'tar.gz'));
    }

    protected function InitErrorFiles()
    {
        $this->errormessages = array(0 => 'There is no error, file uploaded with success.',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            3 => 'The uploaded file was only partially uploaded.',
            4 => 'No file was uploaded.',
            6 => 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.',
            7 => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
            8 => 'File upload stopped by extension. Introduced in PHP 5.2.0.',
            9 => 'No files to upload',
            10 => 'File too big',
            11 => 'Extension file not supported',
            12 => 'File name is too big',
            13 => 'File already exists, overwritting not allowed',
            14 => 'File not downloaded via HTTP_POST',
            15 => 'Unable to set the new file permission',
            16 => ' File not uploaded');

    }
}

class Uploads extends Upload
{


    /**
     * Files to be uploaded
     *
     * @var array
     */
    public $files;

    protected $action;
    /**
     *  key =>filename value => array (status of upload true or false, errormessage);
     *
     * @var array
     */
    protected $UploadedFiles = array();

    public $formclass = 'upload_form';

    public $formname = 'upload_form';

    private $photographers;
    private $db;

    public function __construct($folderdir, $action = false, $overwrite = false, $addPhotographers = true,$db)
    {
        $this->db=$db;
        if ($action == false) {
            $this->action = $_SERVER['PHP_SELF'];
        } else {
            $this->action = $action;
        }

        Upload::__construct($folderdir, $overwrite);

        if($addPhotographers) {
            $personDataArray = array('LAST_NAME' => '', 'FIRST_NAME' => '', 'SEQNO' => '');

            $photographersQ = new QueryEaser($this->db, "select distinct a.seqno, a.last_name, a.first_name from persons a,groups b, person2groups c
where a.seqno = c.psn_seqno and b.name = c.grp_name and b.name in ('COLLECTOR','EXAMINER','OBSERVER','AUTOPSIER','INFORMER')", $personDataArray, null);
            $this->photographers = $photographersQ->resultArray;
        }

        // init files to upload
        if ($this->InitFiles() == false) {
            return false;
        };
    }

    public function setClass($in)
    {
        if (is_string($in) && strlen($in) > 0) {
            $this->formclass = $in;
        }
    }

    public function hasUploaded()
    {
        return count($this->UploadedFiles) > 0 ? true : false;
    }

    public function getNonUploadedFiles()
    {
        if (count($this->UploadedFiles) == 0) {
            return false;
        }
        $tmp = array();
        foreach ($this->UploadedFiles as $name => $status) {
            if (is_bool($status[0]) == true) {
                if ($status[0] == false) {
                    $tmp[] = $name;
                }
            }
        }
        if (count($tmp) > 0) {
            return $tmp;
        } else {
            return false;
        }

    }

    public function getUploadedFiles()
    {
        if (count($this->UploadedFiles) == 0) {
            return false;
        }
        $tmp = array();
        foreach ($this->UploadedFiles as $name => $status) {
            if (is_bool($status[0]) && $status[0] == true) {
                $tmp[] = $name;
            }
        }
        if (count($tmp) > 0) {
            return $tmp;
        } else {
            return false;
        }
    }

    /**
     * Wrap the $_FILES variable to the files attribute
     * In case of ajax based file retrieval => use the post attribute to retrieve them
     * @return bool
     */
    protected function InitFiles()
    {
        if (isset($_FILES) && count($_FILES) > 0) {
            $this->files = $_FILES;
            return true;
        } else {
            $this->isError = true;
            $this->errormessage = $this->errormessages[9];
            return false;
        }
    }


    public function UploadFiles()
    {
        $this->InitFiles();
        if (isset($_POST['active_tab']) && $_POST['active_tab'] != $this->formclass) {
            return false;
        }

        if ($this->isError == true) {
            return false;
        } // in case no files to upload -- just exit the function

        if (!is_array($this->files)) {
            return false;
        }

        foreach ($this->files as $file) {
            if (is_array(current($file)) == true) {
                $files_cvrt = $this->CvrtMultipleUploads($file);


                foreach ($files_cvrt as $file_cvrt) {
                    if ($this->UploadFile($file_cvrt) == false) {
                        $this->UploadedFiles[$this->getFilename($file_cvrt)] = array(false, $this->errormessage);
                    } else {
                        $this->UploadedFiles[$this->filename] = array(true, $this->errormessages[0]);
                    }
                }
            } else {
                if ($this->UploadFile($file) == false) {
                    $this->UploadedFiles[$this->getFilename($file)] = array(false, $this->errormessage);
                } else {
                    $this->UploadedFiles[$this->filename] = array(true, $this->errormessages[0]);
                }
            }

        }

    }

    protected function CvrtMultipleUploads($files)
    {
        $limit = count(current($files));
        $tmp = array();
        for ($i = 0; $i < $limit; $i++) {

            foreach ($files as $key => $item) {
                $tmp[$i][$key] = $item[$i];
            }
        }
        return $tmp;
    }

    /**
     * Render the upload form, using a specific css file
     *
     *//**/
    public function __toString()
    {
        $html_photographers = '';

        foreach ($this->photographers as $p) {
            $html_photographers .= "<option value='" . $p['SEQNO'] . "'>" . $p['FIRST_NAME'] . ' ' . $p['LAST_NAME'] . "</option>";
        }

        $tostring = "<div class='$this->formname'>";
        $tostring .= "<div class='initinput' style='display:none;'><div class='photoselectionbox'>";
        $tostring .= "<label class='control-label' for='upload[]'>Select a file:</label><input type='file' name='upload[]' size='30'/><label class='control-label' for='photographers'>Photographer:</label><select name='photographers'>$html_photographers</select>" .
            "<button type='button' class='del' style='float:right;'><img src='/legacy/img/cross.png' alt='Del'/></button></div></div>";
        $tostring .= "<form class='$this->formclass $this->formname' name='$this->formname' enctype='multipart/form-data' method ='post' action = '$this->action'>";
        $tostring .= "<input style='display:none;' name='active_tab' value='$this->formclass'/>";
        $tostring .= "<input type='hidden' name='MAX_FILE_SIZE' value='$this->maxsize'/>";
        $tostring .= "
<div id='inputs'>
    <div class='photoselectionbox'>
        <label class='control-label' for='upload[]'>Select a file:</label><input type='file' name='upload[]' size='30'/>
        <label class='control-label' for='photographers'>Photographer:</label>
        <select name='photographers'>$html_photographers</select>
        <button type='button' class='del' style='float:right;'><img src='/legacy/img/cross.png' alt='Del' /></button>
    </div>
</div>";
        if (count($this->UploadedFiles) > 0) {
            foreach ($this->UploadedFiles as $key => $uploaded) {
                if (is_bool($uploaded[0]) == true) {
                    $tostring .= "<div class='photoselectionbox'>" . $key . ($uploaded[0] ? "<span class ='success'>" . $this->errormessages[0] . "</span>" :
                            "<span class='error'>" . $uploaded[1] . "</span>") . "</div>";
                }

            }
        }
        //$tostring .= "</div>";
        $tostring .= "<div class='footer'>";
        $tostring .= "<button type='button' class='add'><img src='/legacy/img/add.png' alt='Add' /></button>";
        $tostring .= "<button class='submit' type='submit' name='submit' value='submit'><img src='/legacy/img/accept.png' alt='Accept'/></button>";
        $tostring .= "</div>";
        $tostring .= "<div class='clearboth'></div>";
        $tostring .= "</form>";
        $tostring .= "</div>";
        return $tostring;
    }
}

?>

