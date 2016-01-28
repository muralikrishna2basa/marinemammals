<?php
/**
 *    Class Biolibd_Layout v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 */
require_once(Classes . 'arch/TwoColFixedFluid_Layout_class.php');
require_once(Classes . 'db/Oracle_class.php');
require_once(Classes . 'arch/SigninRenderer_class.php');
require_once(Classes . 'arch/Menu_class.php');
//require_once(Classes . 'auth/Auth_class.php');
include_once(Functions.'getAuthDb.php');
require_once(Classes . 'arch/Accordion_class.php');

class Biolibd_Layout extends Twocolfixedfluid
{

    protected $db;

    protected $log;

    public $isError;

    public $errormessage;

    public $displaycontentlist = array(); // useful to set the id of the navigation list ( displaying content)

    public $navigationlists = array();

    protected $accordionlists = array();

    protected $idinitnavigation = false;
    /**
     * $navigationlists key => value of hiddennavigationlist
     *
     * @var array
     */
    protected $hiddennavigationlist = array();


    public function __construct($title, $offline = false, $redirect_url = 'index.php')
    {
        Page::__construct($title);
        $this->addHead(array(
            '<link rel="stylesheet" type="text/css" href="/legacy/css/jquery.contextMenu.css"/>',
            '<link rel="stylesheet" type="text/css" href="/legacy/css/default_form.css" />',
            '<link rel="stylesheet" type="text/css" href="/legacy/css/redmond.datepick.css" />',
            '<link rel="stylesheet" type="text/css" href="/legacy/css/Jquery/ui.all.css" />'));

        $this->addHead(array('<script type="application/javascript" src="/legacy/js/jquery-1.4.2.min.js"></script>',
            '<script type="application/javascript" src="/legacy/js/jquery.json-2.2.js"></script>',
            '<script type="application/javascript" src="/legacy/js/Layout.js"></script>',
            '<script type="application/javascript" src="/legacy/js/navigation.js"></script>',
            '<script type="application/javascript" src="/legacy/js/jquery.contextMenu.js"></script>',
            '<script type="application/javascript" src="/legacy/js/jquery.datepick.js"></script>',
            '<script type="application/javascript" src="/legacy/js/jquery-ui-1.7.2.custom.js"></script>',
            '<script type="application/javascript" src="/legacy/js/ui.core.js"></script>',
            '<script type="application/javascript" src="/legacy/js/ui.accordion.js"></script>',
            '<script type="application/javascript" src="/legacy/js/jquery.loadmask.adapted.js"></script>',
            '<link rel="stylesheet" type="text/css" href="/legacy/css/jquery.loadmask.css" />'));

        // Database connection

        /*$cred = parse_ini_file(Ini . "db_credentials.ini", true);
        //$user = 'biolib_owner';
        $user = 'biolib_test';
        $usr_cred = $cred[$user];

        $db = new ORACLE ($usr_cred['login'], $usr_cred['pass'], $usr_cred['alias'], $offline);*/

        //global $dbase;
        //require_once(Functions.'getAuthDb.php');
        require(Functions.'getAuthDb.php');
        print_r($db);
        $this->db = $db;

        if ($db->iserror == true) {
            $this->errormessage = $db->errormessage;
            return false;
        }
        if ($db->iserror == false) {

            $log = $this->log;

            if (isset($log) & is_array($log)) {
                if (key($log) == true || key($log) == 1) {
                    $this->isError = true;
                    //$this->signin->errormessage = current($log);
                }
            }
        } else {
            $this->isError = true;
            $this->errormessage = 'database error -- please try later';
            return false;
        }
    }

    public function setInitNavigationId($id)
    {
        if (is_string($id)) {
            $this->idinitnavigation = $id;
        }
    }

    public function getInitNavigationId()
    {
        return $this->idinitnavigation;
    }

    public function __toString()
    {
        $footer = $this->getFooterError();
        $this->addFooter($footer);
        return Page::__toString();

    }

    protected function getFooterError()
    {
        if ($this->isError == true) {
            $errormessage = $this->errormessage;
            $errorclass = "displayed";
        } else {
            $errormessage = "";
            $errorclass = "init";
        }

        $footer = "<div class ='error $errorclass'><p>$errormessage</p>\n</div>";

        return $footer;
    }

    public function getDatabase()
    {
        return $this->db;
    }


}

?>