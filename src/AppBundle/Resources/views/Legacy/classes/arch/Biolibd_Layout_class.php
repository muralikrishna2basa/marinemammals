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
require_once(Classes . 'arch/Accordion_class.php');

class Biolibd_Layout extends Twocolfixedfluid
{
    protected $menus;

    protected $signin;

    protected $db;

    protected $auth;

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


    public function __construct($offline = false, $redirect_url = 'index.php')
    {
        // Constructing Layout

       //Twocolfixedfluid::__construct("Marine Mammals");
        Page::__construct("Marine Mammals");
        $this->addHead(array(
           // '<link rel="stylesheet" type="text/css" href="/legacy/css/Layout/Biolibd_Layout.css" />',
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


        //$this->signin = new Signin_Renderer_v1();

        // Database connection

        $cred = parse_ini_file(Ini . "db_credentials.ini", true);
        $user = 'biolib_owner';
        $usr_cred = $cred[$user];

        $db = new ORACLE ($usr_cred['login'], $usr_cred['pass'], $usr_cred['alias'], $offline);

        $this->db = $db;

        if ($db->iserror == true) {
            $this->errormessage = $db->errormessage;
            return false;
        }

        //$this->menus = new Menu($db);

        //$this->menus->setHidden("Account Maintenance", true);

        // Securing Layout

        //$this->Secure_Layout($redirect_url);

        // Alter Layout -- authentication dependant

        //$auth = $this->auth;

        if ($db->iserror == false) {

            $log = $this->log;

            if (isset($log) & is_array($log)) {
                if (key($log) == true || key($log) == 1) {
                    $this->isError = true;
                    //$this->signin->errormessage = current($log);
                }
            }/* elseif ($auth->getSessionName() != false) {
                //$this->signin->logged($auth->getSessionName());
            }*/
            //$this->menus->setGroup($auth->getSessionGroupname());
        } else {
            $this->isError = true;
            $this->errormessage = 'database error -- please try later';
            return false;
        }

        if (isset($_GET['action']) && $_GET['action'] == 'loggedout') {
            //$this->signin->signedout = 'Successfully signed out';
        }

        /*$this->setAction($_SERVER['PHP_SELF']);

        $this->setSignout($_SERVER['PHP_SELF'] . "?action=logout"); // to be used in the body

        $this->setAccountMaintenance("Account_Maintenance.php");*/


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
/*
    protected function Secure_Layout($redirect_url)
    {
        $db = $this->db;


        if (is_object($db) == true && $db->iserror == false) {

            //$auth = new Auth($db, $redirect_url, 'ohoho'); // Second argument = redirect url

            //$this->auth = $auth;

            //$this->log = $auth->login(); // store login in session and secure session

            if (isset($_GET['action']) && $_GET['action'] == 'logout') {
               // $auth->logout();
            }

        } else {
            $url = str_replace('/', '', $_SERVER['PHP_SELF']);

            if ($url != $redirect_url) {
                header('Location: ' . $redirect_url);
            }

        }

    }*/

    public function __toString()
    {
        // start : display only content session clicked -> at document load => no javascript needed
        /*if (count($this->displaycontentlist) > 0) {
            $navigation_lists = array();
            foreach ($this->displaycontentlist as $classname) {
                $navigation_lists += $this->navigationlists[$classname];
            }

        } else {
            $navigation_lists = current($this->navigationlists);
        }*/

/*
        if (isset($_SESSION['navigation']) && array_key_exists($_SERVER['PHP_SELF'], $_SESSION['navigation'])) {
            $php_self = $_SERVER['PHP_SELF'];
            $id = $_SESSION['navigation'][$php_self];
            unset($navigation_lists[$id]);     // restrict to items that aren't in session, so that the corresponding content will be set to hidden


            if ($navigation_lists != false) {
                $contents = $this->contents;
                foreach ($navigation_lists as $key => $value) {
                    $key = str_replace('#', '', $key);
                    $contents = preg_replace('/$key/i', $key . '" style = "display:none;"', $contents, 1); // replace only the first occurence
                    //	$contents = str_replace($key.'"',$key.'" style = "display:none;"',$contents); // replace all occurences
                }
                $this->contents = $contents;
            }
            // end
        } else {
            $this->setInitNavigation();
        }*/
        /*$banner = $this->getBanner();

        $this->FillNavigationList();

        $this->FillAccordionNavigation();

        $menus = $this->getMenu();*/

        //$this->addHead(array($this->signin->csslink));
/*
        $this->addHeader($banner);
        $this->addHeader($menus);
*/
        $footer = $this->getFooterError();

        $this->addFooter($footer);

        //return Twocolfixedfluid::__toString();
        return Page::__toString();

    }

    protected function setInitNavigation()
    {


        if (is_array($this->navigationlists)) {
            $id = $this->idinitnavigation;

            if (count($this->displaycontentlist) > 0) {
                $navigation_lists = array();
                foreach ($this->displaycontentlist as $classname) {
                    $navigation_lists += $this->navigationlists[$classname];
                }

            } else {
                $navigation_lists = current($this->navigationlists);
            }

            if (!is_array($navigation_lists)) {
                return true;
            } // in case a webpage doesnt contain any sided navigation

            if ($id == false) // by default
            {
                $id = key($navigation_lists);
            } elseif (is_array($navigation_lists) && !array_key_exists($id, $navigation_lists)) {
                $id = key($navigation_lists);
            }


            $php_self = $_SERVER['PHP_SELF'];

            $_SESSION['navigation'][$php_self] = $id;
            // the id is one of the navigation list element
        }

    }

    /**
     * Update the displayed navigation item
     *
     * @param string $classname
     * @param string $item
     * @param string $newvalue
     * @return unknown
     */
    public function updateNavigationItem($classname, $item, $newvalue = "")
    {
        // prior tests
        if (!is_string($classname) || !is_string($item) || !is_string($newvalue)) {
            return false;
        }

        // in case no corresponding navigation group
        if (!array_key_exists($classname, $this->navigationlists)) {
            return false;
        }

        // in case no corresponding item group
        if (!array_key_exists($item, $this->navigationlists[$classname])) {
            return false;
        }

        $this->navigationlists[$classname][$item] = $newvalue;


    }

    public function getNavigation()
    {
        if (isset($_SESSION) && isset($_SESSION['navigation'])) {
            $navigation = $_SESSION['navigation'];
            if (isset($navigation[$_SERVER['PHP_SELF']])) {
                return $navigation[$_SERVER['PHP_SELF']];
            }
        }
    }

    public function NavigateTo($classname, $nav)
    {

        // prior tests
        if (!is_string($classname) || !is_string($nav)) {
            return false;
        }

        // in case no corresponding navigation group
        if (!array_key_exists($classname, $this->navigationlists)) {
            return false;
        }

        // in case no corresponding item group
        if (!array_key_exists($nav, $this->navigationlists[$classname])) {
            return false;
        }

        $php_self = $_SERVER['PHP_SELF'];

        $_SESSION['navigation'][$php_self] = $nav;

    }

    /**
     * Unhide previously hidden navigation item
     *
     * @param unknown_type $classname
     * @param unknown_type $items
     */
    public function unhideNavigation($items)
    {


        if (is_string($items)) {
            $items = array($items);
        }

        $this->hiddennavigationlist = array_diff($this->hiddennavigationlist, $items);

        return true;
    }

    /**
     * Add hidden navigation to the list of existing ones, input is either a string or an array, return void
     *
     * @param string or array $items
     */
    public function addHiddenNavigation($classname, $items)
    {
        $navigationlist = $this->navigationlists[$classname];

        if (is_string($items) == true) {
            if (array_key_exists($items, $navigationlist) == true && in_array($items, $navigationlist) == false) {
                $this->hiddennavigationlist[] = $items;
            }
        }
        if (is_array($items) == true) {
            foreach ($items as $item) {
                if (array_key_exists($item, $navigationlist) == true && in_array($item, $this->hiddennavigationlist) == false) {
                    $this->hiddennavigationlist[] = $item;
                }

            }
        }
    }

    /**
     * Add an accordion named by name where its structure is defined in $items
     *
     * @param string $name
     * @param array $items
     * @return bool
     */
    public function addAccordionList($accordion_object)
    {
        if ($accordion_object instanceof Accordion) {
            $this->accordionlists[] = $accordion_object;
        }
    }


    /**
     * Add a list of navigation elements wrapped in a div of class defined by $classname
     * and listed by un unordered list (ul) together with their list elements (li)
     *
     * $displaycontentlist display or not the title specified by $title
     *
     * @param string $classname
     * @param string $list
     * @param bool $displaycontentlist
     * @param string $title
     */
    public function addNavigationList($classname, $list, $displaycontentlist = false, $title = false)
    {
        if ($displaycontentlist == true) {
            if ($title != false) {
                $this->displaycontentlist[$title] = $classname;
            } else {
                $this->displaycontentlist[] = $classname;
            }
        }
        if (array_key_exists($classname, $this->navigationlists) == false) {
            $this->navigationlists[$classname] = $list;
        } else {
            $this->navigationlists[$classname] += $list;
        }
    }


    public function Accordion_callback($li_item)
    {

        if (isset($_SESSION['navigation']) && array_key_exists($_SERVER['PHP_SELF'], $_SESSION['navigation'])) {
            $navigation = $_SESSION['navigation'];
            $navigation = $navigation[$_SERVER['PHP_SELF']];

        } else {
            $navigation = false;
        }

        if ($li_item instanceof Li_Element) {
            if (in_array($li_item->href, $this->hiddennavigationlist) == true) {
                // $li_item->addClass_a('isclicked');
                $li_item->addStyle_li('display:none');
            }

            if ($navigation == $li_item->href) {
                $li_item->addClass_li('isclicked');
            }


        }
        return true;
    }

    protected function FillAccordionNavigation()
    {
        $nav_tmp = "";

        foreach ($this->accordionlists as $accordion_object) {
            $accordion_object->addCallbackElements('Accordion_callback', $this);

            $nav_tmp .= $accordion_object->__toString() . '\n';
        }

        $cntclicked = substr_count($nav_tmp, 'isclicked');

        if ($cntclicked == 0) {
            $nav_tmp = preg_replace('/<li/i', '<li class="isclicked" ', $nav_tmp, 1);
        }

        $this->addNavigation(stripcslashes($nav_tmp));

    }

    protected function FillNavigationList()
    {

        $navigationlists = $this->navigationlists;

        foreach ($navigationlists as $classname => $list) {

            $tmp = "<div class = '$classname'>\n";

            if (in_array($classname, $this->displaycontentlist)) {
                $title = array_search($classname, $this->displaycontentlist);
                if (is_string($title)) {
                    $tmp .= "<h3>$title</h3>\n";
                }
            }
            $tmp .= "<ul>\n";

            if (isset($_SESSION['navigation']) && array_key_exists($_SERVER['PHP_SELF'], $_SESSION['navigation'])) {
                $navigation = $_SESSION['navigation'];
                $navigation = $navigation[$_SERVER['PHP_SELF']];

            } else {
                $navigation = false;
            }

            foreach ($list as $href => $name) {

                if (in_array($href, $this->hiddennavigationlist) == true) {
                    $hidden = "style='display:none;'";
                } else {
                    $hidden = '';
                }
                if ($navigation == $href) {
                    $tmp .= "<li class='isclicked'><a  href = '$href'>$name</a></li>\n";
                } else {
                    $tmp .= "<li  $hidden><a href = '$href'>$name</a></li>\n";
                }
            }

            if ($navigation != false && array_key_exists($navigation, $list) == false) {
                $tmp .= "<li class='isclicked' style='display:none;'><a href='$navigation'></a></li>\n";
            }

            $tmp .= "</ul>\n</div>\n";
            $this->addNavigation(stripcslashes($tmp));
        }
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

    protected function getMenu()
    {
        if (is_object($this->menus) == true)

            return stripcslashes("<div class ='main_menus'>\n" . $this->menus->render() . "\n
								<div class='clearboth'></div>\n</div>");
        else {
            return false;
        }

    }

    /**
     * Return the banner
     *
     */
    protected function getBanner()
    {/*
        $signin_render = $this->signin->render();

        $banner = <<<EOD
<div id="banner">
	<div id ="banner_transparency_left">
		<div id ="banner_transparency_right">
			<div id="banner_elements"></div>
			<div id="banner_partner">
				<a class="ulg"  href="http://www.ulg.ac.be" target="_blank"></a>
				<a class="mumm" href="http://www.mumm.ac.be" target="_blank"></a>
			</div>
			$signin_render
			<div id = "title">
			<div id="title_inner">
				<p class ="title"><span>Marine Mammal</span></p>
				<p class="subtitle"><span>Observation, Stranding &amp; Sample Library</span></p>
			</div>	
			</div>
		</div>
	</div>
</div>
EOD;*/
        //return $banner;
        return '';
    }

    public function setSignout($signout)
    {
        //$this->signin->setSignout($signout);
    }

    public function setAccountMaintenance($accountMaintenance)
    {
        //$this->signin->setAccountMaintenance($accountMaintenance);
    }

    public function setAction($action)
    {
        //$this->signin->setAction($action);
    }

    public function logged($name = "")
    {
        //$this->signin->logged($name);
    }

    public function getDatabase()
    {
        return $this->db;
    }

    public function getAuth()
    {
        return $this->auth;
    }

    public function getMenus()
    {
        return $this->menus;
    }

}

?>