<?php

/**
 *    Class ORACLE  v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 *
 *  Details:
 * ---------
 * ORACLE Database Connection Class
 * @access public
 */
class ORACLE
{

    /**
     * Oracle username
     * @access private
     * @var string
     */
    var $dbUser;

    /**
     * Oracle user's password
     * @access private
     * @var string
     */
    var $dbPass;

    /**
     * Name of database to use
     * @access private
     * @var string
     */
    var $dbAlias;

    /**
     * Oracle Resource link identifier stored here
     * @access private
     * @var string
     */
    var $dbConn;

    /**
     * Stores error messages for connection errors
     * @access private
     * @var string
     */

    /**
     * Stores error messages for database errors
     * @access private
     * @var string
     */

    var $iserror;

    var $errormessage;

    var $offline = false;

    function close()
    {
        oci_close($this->dbConn);
    } /* left for backward compability */


    /**
     * Oracle constructor
     * @param string dbUser (Oracle User Name)
     * @param string dbPass (Oracle User Password)
     * @param string dbAlias (Database alias specified in tns_names)
     * @access public
     */
    function __construct($dbUser, $dbPass, $dbAlias, $offline = false)
    {
        $this->offline = $offline;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbAlias = $dbAlias;
        $this->connectToDb();
    }


    function setOffline()
    {
        $this->offline = true;
    }

    function setOnline()
    {
        $this->offline = false;
    }

    /**
     * Establishes connection to  Oracle and selects a database
     * @return void
     * @access private
     */
    function connectToDb()
    {
        if ($this->offline == true) {
            $this->iserror = true;
            $this->errormessage = 'offline mode';
            return false;
        }
        // Make connection to ORACLE server & connect to Database
        if (!$this->dbConn = oci_connect($this->dbUser, $this->dbPass, $this->dbAlias, 'AL32UTF8')
        ) {
//            trigger_error('Could not connect to server');

            $this->iserror = true;
            $e = oci_error();
            $this->errormessage = htmlentities($e['message']);

        }

    }

    function errormessage()
    {
        return $this->errormessage;
    }

    /**
     * Checks for Oracle errors
     * @return boolean
     * @access public
     */
    function isError()
    {
        if ($this->iserror) {

            return true;

        } else {
            return false;
        }
    }

    /**
     * Returns an instance of OracleResult to fetch rows with
     * @param $sql string the database query to run
     * @return OracleResult
     * @access public
     */
    function  query($sql, $binds = false)
    {

        if ($this->offline == true) {
            $this->iserror = true;
            $this->errormessage = 'offline mode';
            return false;
        }

        /* init possible errors, so that the next query doesn't care about a possible previously handled error */
        $this->iserror = false;
        $this->errormessage = "";

        if (!$queryResource = oci_parse($this->dbConn, $sql)) {
            $this->iserror = true;
            $e = oci_error($this->dbConn);
            $this->errormessage = 'oci_parse: ' . htmlentities($e['message']);

        }
        if ($binds) {

            foreach ($binds as $binded => $binded_value) {
                if (!oci_bind_by_name($queryResource, $binded, $binds[$binded])) {
                    $this->iserror = true;
                    $e = oci_error($this->dbConn);
                    $this->errormessage = 'oci_bind_by_name: ' . htmlentities($e['message']);
                }

            }

        }

        if ($temp = oci_execute($queryResource)) ;
        else {
            $this->iserror = true;
            $e = oci_error($queryResource);
            $this->errormessage = htmlentities($e['message']);
            //             trigger_error ('Query failed: '.$temp);
            //              $this->errorexecute = true;
        }
        return new OracleResult($this, $queryResource);
    }
    /**
     * Returns an instance of OracleResult to fetch rows with
     * @param $sql string the database query to run
     * @return OracleResult
     * @access public
     */

}

/**
 * OracleResult Data Fetching Class
 * @access public
 */
class OracleResult
{
    /**
     * Instance of Oracle providing database connection
     * @access private
     * @var Oracle
     */
    var $oracle;

    /**
     * Query resource
     * @access private
     * @var resource
     */
    var $query;

    /**
     * OracleResult constructor
     * @param object oracle  (instance of ORACLE class)
     * @param resource query (Oracle query resource)
     * @access public
     */
    function OracleResult(& $oracle, $query)
    {
        $this->oracle =& $oracle;
        $this->query = $query;
    }

    /**
     * Fetches a row from the result
     * @return array
     * @access public
     */
    function fetch()
    {

        if ($row = oci_fetch_array($this->query, OCI_ASSOC+OCI_RETURN_NULLS)) { //TODO:+OCI_RETURN_NULLS check for SPECIAL CASES!
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Fetches all rows from results
     * @return array
     * @ access puclic
     */
    public function fetchAll($DEFAULT = OCI_FETCHSTATEMENT_BY_ROW)
    {
        if ($rows = oci_fetch_all($this->query, $results, 0, -1, $DEFAULT)) {
            return $results;
        } else {
            return false;
        }
    }

    /**
     * Returns the number of rows selected
     * @return int
     * @access public
     */
    function size()
    {
        return oci_num_rows($this->query);
    }

    /**
     * Returns the ID of the last row inserted
     * @return int
     * @access public
     */

    /**
     * Checks for Oracle errors
     * @return boolean
     * @access public
     */
    function isError()
    {
        return $this->oracle->isError();
    }

    function errormessage()
    {
        return $this->oracle->errormessage;
    }
}

?>