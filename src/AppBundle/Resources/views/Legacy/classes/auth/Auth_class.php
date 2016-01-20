<?php
/**
 *    Class Auth v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 */


require_once(Classes . 'auth/Session_class.php');

class Auth
{
    protected $db;

    protected $cfg;

    protected $session;

    protected $redirect;

    protected $hashkey;

    public $isError;

    public $errormessage;

    public function __construct(ORACLE $db, $redirect, $hashkey)
    {
        $this->db = $db;
        $this->cfg = parse_ini_file(Ini . "access_control.ini", true);
        $this->redirect = $redirect;
        $this->hashkey = $hashkey;
        $this->session = new Session();
        if (!$this->session->get('connectedattempts')) {
            $this->session->set('connectedattempts', 1);
        }
    }

    public function login($redirect = false)
    {

        if ($redirect != false) {
            $this->redirect = $redirect;
        }

        if ($this->session->get('connectedattempts') > 20) {
            $lifetime = ini_get("session.gc_maxlifetime");
            return array(true => "Maximum connection attempts reached wait for $lifetime minutes");
        }

        // form
        $var_login = $this->cfg['login_vars']['login'];
        $var_pass = $this->cfg['login_vars']['password'];

        // tables

        $groups_table = $this->cfg['groups_table']['table'];
        $groups_level = $this->cfg['groups_table']['level'];
        $groups_name = $this->cfg['groups_table']['name'];

        $user2group_table = $this->cfg['user2groups']['table'];
        $user2group_user = $this->cfg['user2groups']['person'];
        $user2group_group = $this->cfg['user2groups']['group'];

        $user_table = $this->cfg['users_table']['table'];
        $user_login = $this->cfg['users_table']['login'];
        $user_pass = $this->cfg['users_table']['password'];

        /*
        If already logged in
        */

        if ($this->session->get('login_hash')) {
            /* redirect in case not allowed to access the page and already logged in */
            $this->confirmAuth();
            /* check level of authentication */
            $this->checkAuth();

            $login = $this->getSessionName(); /* Not neccesssary to bind variables since the user is already authenticated*/

            $sql = "select nvl(max(a.$groups_level),0) $groups_level from ($groups_table) a, ($user_table) b,($user2group_table) c
			where b.seqno = c.psn_seqno 
			and c.grp_name = a.name
			and b.$user_login = '$login'";

            $r = $this->db->query($sql)->fetch();

            $this->session->set($this->cfg['groups_table']['level'], $r[strtoupper($groups_level)]);

            return array(true => 'already connected');
        }
        /**
         *
         * if user not logged-in and try to access a page by pointing it via the url
         */
        if (!isset($_POST[$var_login]) || !isset($_POST[$var_pass])) {

            /*
            Check authorization for accessing the page
            */
            $this->checkAuth();

            return array(true => 'all aboard!');
            //return array(false => 'connected as guest');
        }

        /**
         *  if user send a request for the identification
         */
        if (strlen($_POST[$var_login]) == 0 || strlen($_POST[$var_pass]) == 0) {
            /* if only a part of the form is filled, the user try to sign-in but the signin box is not complete */

            $this->checkAuth(); // i am already on the page, but do i deserve to be where i am if i am not logged-in

            $connectedattempts = $this->session->get('connectedattempts');
            $this->session->set('connectedattempts', $connectedattempts + 1);
            return array(true => 'all aboard!');
            //return array(true => 'missing login details');
        }


        $password = md5($_POST[$var_pass]);

        $binds = array(":login" => $_POST[$var_login], ":pass" => $password);

        $sql = "select count(*) as num_users from $user_table
	        where $user_login =:login and $user_pass =:pass ";

        $r = $this->db->query($sql, $binds)->fetch();

        if ($r['NUM_USERS'] != 1) {
            $connectedattempts = $this->session->get('connectedattempts');
            $this->session->set('connectedattempts', $connectedattempts + 1);
            return array(true => 'wrong login details');
        } else {
            $this->storeAuth($_POST[$var_login], $password);
        }
        $login = $this->getSessionName(); /* Not neccesssary to bind variables since the user is already authenticated*/

        // group level and group_name of the highest level are recorded in the table
        $sql = "select $groups_name,$groups_level from $groups_table
			where $groups_level = ( 
	 		select nvl(max(a.$groups_level),0) from ($groups_table) a, ($user_table) b,($user2group_table) c 
			where b.seqno = c.psn_seqno 
			and c.grp_name = a.name
			and b.$user_login = '$login')";

        $r = $this->db->query($sql)->fetch();

        $this->session->set($this->cfg['groups_table']['level'], $r[strtoupper($groups_level)]);

        $this->session->set($this->cfg['groups_table']['name'], $r[strtoupper($groups_name)]);

        $this->checkAuth(); // the user is authenticated, latest check to see if has the right to be there

    }

    public function secure()
    {

        $var_login = $this->cfg['login_vars']['login'];
        $var_pass = $this->cfg['login_vars']['password'];
        $user_table = $this->cfg['users_table']['table'];
        $user_login = $this->cfg['users_table']['login'];
        $user_pass = $this->cfg['users_table']['password'];

        if ($this->session->get('login_hash')) {
            $this->confirmAuth();
            return;
        }

        if (!isset($_POST[$var_login]) || !isset($_POST[$var_pass])) {
            $this->redirect();
        }

        $password = md5($_POST[$var_pass]);

        $binds = array(":login" => $_POST[$var_login], ":pass" => $password);

        $sql = "select count(*) as num_users from $user_table
	        where $user_login =:login and $user_pass =:pass ";

        $r = $this->db->query($sql, $binds)->fetch();

        if ($r['NUM_USERS'] != 1) {
            $this->redirect();
        } else {
            $this->storeAuth($_POST[$var_login], $password);
        }

    }

    public function getPassword()
    {
        $this->confirmAuth(); // the user is logged, no session credits change

        $seqno = $this->getSessionId();

        $sql = "select password from persons where seqno = '$seqno'";
        $r = $this->db->query($sql);
        if ($r->isError()) {
            $this->isError = true;
            $this->errormessage = $r->errormessage;
            return false;
        }
        $row = $r->fetch();
        return $row['PASSWORD'];


    }

    public function setPassword($password)
    {
        $this->confirmAuth(); // the user is logged, no session credits change

        $seqno = $this->getSessionId();

        $password = md5($password);

        $sql = "update persons set password = '$password' where seqno = '$seqno'";

        $r = $this->db->query($sql);
        if ($r->isError()) {
            $this->isError = true;
            $this->errormessage = $r->errormessage;
            return false;
        } else {
            return true;
        }
    }

    public function getSessionGroupname()
    {
        if (is_bool($this->session->get($this->cfg['groups_table']['name']))) {
            $group = 'GUEST'; // minimum level
        } else {
            $group = $this->session->get($this->cfg['groups_table']['name']);
        }
        return $group;
    }

    public function getSessionGrouplevel()
    {
        if (is_bool($this->session->get($this->cfg['groups_table']['level']))) {
            $group = 0; // minimum level
        } else {
            $group = $this->session->get($this->cfg['groups_table']['level']);
        }
        return $group;
    }

    public function getSessionName()
    {
        return $this->session->get($this->cfg['login_vars']['login']);
    }

    public function getSessionId()
    {
        return $this->session->get($this->cfg['users_table']['seqno']);
    }

    public function storeAuth($login, $password)
    {

        $this->session->set($this->cfg['login_vars']['login'], $login);
        $this->session->set($this->cfg['login_vars']['password'], $password);

        $sql = "select seqno from persons where login_name = :login and password = :password ";
        $binds = array(':login' => $login, ':password' => $password);
        $r = $this->db->query($sql, $binds)->fetch();
        if ($this->db->isError()) {
            return false;
        }
        $seqno = $r['SEQNO'];
        $this->session->set($this->cfg['users_table']['seqno'], $seqno);

        $hashkey = md5($this->hashkey . $login . $password);

        $this->session->set($this->cfg['login_vars']['hash'], $hashkey);

    }

    /**
     * Confirm authentication after login,
     * If a user change the login or password fields from the session mechanism
     * then the resulting hash will fail to match the stored one and the user will be logged out
     *
     */
    private function confirmAuth()
    {
        $login = $this->session->get($this->cfg['login_vars']['login']);
        $password = $this->session->get($this->cfg['login_vars']['password']);
        $hashkey = $this->session->get($this->cfg['login_vars']['hash']);

        $hash_to = md5($this->hashkey . $login . $password);

        if (md5($this->hashkey . $login . $password) != $hashkey) {
            $this->logout(true);
        }

    }

    /**
     * Check authentication
     * if not authorized, then redirected elsewhere
     * @return unknown
     */
    public function checkAuth()
    {
        $page = $_SERVER['PHP_SELF'];
        $access_level = $this->getSessionGrouplevel();

        $sql = "select count(a.script) as isallowed from (menus) a,(group2menus) b,(groups) c
		        where a.seqno = b.mnu_seqno and b.grp_name = c.name 
		        and c.access_level = $access_level and a.script = '$page'";

        $r = $this->db->query($sql)->fetch();

       /* if ($r['ISALLOWED'] == 0) {
            $this->redirect();
        } else {
            return true;
        }*/
        return true; //all aboard

    }

    public function logout($from = false)
    {
        $this->session->del($this->cfg['login_vars']['login']);
        $this->session->del($this->cfg['login_vars']['password']);
        $this->session->del($this->cfg['login_vars']['hash']);
        $this->session->destroy(); // reinitialize all sessions variables... it is not necessary to delete the variable sessions
        $this->redirect('logout');
    }

    private function redirect($from = true)
    {
        if (is_bool($from) && $from == true) {
            if (isset($_SERVER['REQUEST_URI']) == true) {
                $from = $_SERVER['REQUEST_URI'];
            } elseif (isset($_SERVER['PHP_SELF']) == true) {
                $from = $_SERVER['PHP_SELF'];
            } else {
                $from = 'dummy.php';
            }
            header('Location: ' . $this->redirect . '?from=' . $from);
        } elseif ($from == 'logout') {
            header('Location: ' . $this->redirect . '?action=loggedout');
        } else {
            header('Location: ' . $this->redirect);

        }
        exit(); // terminate processing
    }


}

?>