<?php

include_once(Classes . "db/Oracle_class.php");
include_once(Classes . "search/filter_class.php");
include_once(Classes . "search/pager_class.php");
include_once(Classes . "search/renderer_class.php");

/**
 *    Class BLP_Search, BLP_SEARCHER,.... v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 *  Details:
 * ---------
 *
 * Construct the main table
 * Contains a query instance
 *
 *
 */
class BLP_Search
{
    /**
     * Contains all the database related functions( used by the pager, renderer)
     *
     * @var Oracle object
     */
    public $db;
    /**
     * Contains the BLP_Query object wich will build the complete query
     *
     * @var BLP_Query object
     */
    public $query;
    /**
     * Contains the filters
     *
     *
     * @var array of BLP_FILTER objects keyed with their names
     */
    public $filters = array();
    /**
     * Contains the renderer
     *
     * @var Table_Renderer
     */
    public $renderer;

    public $columns;
    /**
     *  Default table styling
     *
     * @var string
     */
    public $cssclass = 'tab_output';

    public $pk;
    /**
     * The searcher belong to a group level
     * Each filter possess an allowed group level
     * in the addFilter method, a check is performed, so that the filter is group dependent
     * @var integer
     */
    public $grouplevel = 0;

    /**
     * Constructor
     *
     * @param ORACLE $db
     * @param integer $grouplevel
     * @param array $columns
     * @param string $cssclass
     * @param string $pk
     * @return BLP_Search
     */
    public function BLP_Search($db, $grouplevel = false, $columns = false, $cssclass = false, $pk = false)
    {
        if ($grouplevel != false && is_numeric($grouplevel) == true) {
            $this->grouplevel = $grouplevel;
        }

        $this->query = New BLP_Query;

        $this->db = $db;

        $pager = New BLP_Pager($this->query, $this->db);

        if ($columns == false) {
            $columns = $this->columns;
        }
        if ($cssclass == false) {
            $cssclass = $this->cssclass;
        }
        if ($pk == false) {
            $pk = $this->pk;
        }

        $this->init_renderer($columns, $pager, $cssclass, $pk);
    }

    /**
     * Init renderer, might be modified by inheritance
     *
     * @param array $columns
     * @param Pager $pager
     * @param string $cssclass
     * @param string $pk ( json format)
     */
    public function init_renderer($columns, $pager, $cssclass, $pk)
    {
        $this->renderer = New Table_Renderer($columns, $pager, $cssclass, $pk);
    }

    /**
     * Get an array of domain values for the considered filter
     *
     * @param string $filtername
     * @return array
     */
    public function getDomain($filtername)
    {
        $filter = $this->getFilterbyname($filtername);
        if (!$filter) {
            return false;
        } else {
            return $filter->domain;
        }

    }

    /**
     * Return Object Filter given its name
     * If multiple filter with the same name for a searcher, then extract the first filter.
     * @param string $filtername
     * @return BLP_FILTER Object or false
     */
    public function getFilterbyname($filtername)
    {
        foreach ($this->filters as $filter) {
            if ($filter->name == $filtername) {
                return $filter;
            }
        }
        return false;
    }

    /**
     *  Return either array of cgrefcodes or false
     *
     */
    public function getCgrefcodes()
    {
        if (is_object($this->query) && $this->query instanceof BLP_QUERY) {
            return $this->query->cgrefcodes;
        }
        return false;
    }

    /**
     * Given the string representating the class of the filter, the function returns the associated name
     * useful for display in the web application
     *
     * @param  string $filterclass
     * @return string
     */
    public function getFiltername($filterclass)
    {
        $filter = $this->getFilter($filterclass);
        return $filter->name;
    }

    /**
     * Get defined tokens for the Filter
     *
     * @param string $filtername
     * @return array
     */
    public function getTokens($filtername)
    {
        $filter = $this->getFilterbyname($filtername);
        return $filter->getTokens();
    }

    /**
     * Filter by Name
     *
     * @param string $filtername
     * @param string $token
     * @param string $value
     * @return ( void,false)
     */
    public function FilterbyName($filtername, $token = false, $value = false)
    {
        $filter = $this->getFilterbyname($filtername);
        if (is_object($filter) == false) {
            return false;
        }
        if (!$token) {
            $filter->process('<|>');
            return;
        }
        if (!$value) {
            $filter->process($token);
            return;
        }
        $filter->process($token, $value);
    }

    /**
     * get the names of all filters
     *
     * @return array
     */
    public function getFiltersname()
    {
        $Filtersname = array();
        foreach ($this->filters as $filter) {
            $Filtersname[] = $filter->name;
        }
        return $Filtersname;
    }

    public function getFilter($filtername)
    {
        if (array_key_exists($filtername, $this->filters)) {
            return $this->filters[$filtername];
        }
    }


    /**
     * Add dynamically a filter, but only if the user group level is higher than the allowed group level for the filter
     *
     * @param object $query
     * @param array $filter
     * @return bool ( true if success for every filters)
     */
    public function addFilter($filter = false)
    {
        $success = true;

        if (!$filter) {
            return false;
        } else {

            foreach ($filter as $item) {

                $filter_item = new $item($this->query, $this->db);

                if (is_object($filter_item) == true) {
                    if ($this->grouplevel >= $filter_item->allowedgrouplevel) {
                        $this->filters[$item] = $filter_item;
                    }
                } else {
                    $success = false;
                }
            }

            return $success;
        }

    }

    /**
     * Remove all filters implemented by default
     *
     * @return true
     */
    public function RemoveAllFilters()
    {
        $this->filters = array();
        return true;
    }

    /**
     * Remove filter by name
     * Return true if successfull, else otherwise
     *
     * @param string $filtername
     * @return bool
     */
    public function RemoveFilterbyName($filtername)
    {
        foreach ($this->filters as $filterclass => $filter) {
            if ($filtername == $filter->name) {
                unset($this->filters[$filterclass]);
                return true;
            }
        }
        return false;

    }

    /**
     * Get Filters
     *
     * @return array
     */
    public function getFilters()
    {
        return array_keys($this->filters);
    }

    /**
     * Add Order Functionality
     *
     * @param string $order
     */
    public function addOrder($order, $ordertype = 'ASC')
    {
//   		if(in_array($order,$this->query->columns))
//   		{
//   			$this->query->addOrder($order,$ordertype);
//   		}
        $order = array_search($order, $this->query->columns);
        if ($order) {
            $this->query->addOrder("($order)", $ordertype);
        }
    }

    /**
     *    Build the complete html result table
     *
     */
    public function __toString()
    {
        $this->renderer->build();
        return $this->renderer->table;
    }

    public function getIdentifiers($binds)
    {
        $this->query->build();
        $sql=$this->query->sqlquery;
        $binds=$this->query->bindings;
        $res = $this->db->query($sql,$binds);
        if ($res->isError()) {
            return "error";
        }
        $row = $res->fetch();
        foreach($row as $column=>$value){
            foreach($this->pk as $pk){
                if($column==$pk){
                    return $value;
                }
            }
        }
        return false;
    }

}

/**
 *   Search_Necropsy
 *   Search for Necropsies through the database
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   CREATED:23/12/2009
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:20/04/2010
 */
class Search_Necropsy extends BLP_Search
{
    public function Search_Necropsy($db, $grouplevel = false)
    {


        $this->columns = array('Seqno', 'Event Date', 'Description', 'Autopsy Reference', 'Laboratory Reference', 'Program');

        $this->cssclass = 'tab_output';

        $this->pk = 'Seqno';

        $this->BLP_Search($db, $grouplevel);

        $aliastable = $this->query->setTable("Necropsies");

        $aliastable2 = $this->query->setTable("Event_states");

        $basecolumns = array('Seqno' => $aliastable2 . '.SEQNO',
            'Event Date' => $aliastable2 . '.EVENT_DATETIME', //REF: db changes
            'Description' => $aliastable2 . '.DESCRIPTION',
            'Autopsy Reference' => $aliastable . '.REF_AUT',
            'Laboratory Reference' => $aliastable . '.REF_LABO',
            'Program' => $aliastable . '.PROGRAM');


        foreach ($basecolumns as $column => $alias) {
            $this->query->addColumn($column, $alias);
        }
        $this->query->addJoin($aliastable . '.ESE_SEQNO = ' . $aliastable2 . '.SEQNO');

        $filter = array('Filter_Date_Necropsy', 'Filter_Sample_ID_Necropsy', 'Filter_Ref_Aut_Necropsy');

        $this->addFilter($filter);


    }


}

/**
 *   Search_Specimen
 *   Search for Specimens through the database
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   MODIFIED DATE:05/01/2010
 *   MODIFIED DATE:18/01/2010
 */
class Search_Specimen extends BLP_Search
{
    public function Search_Specimen($db, $grouplevel = false)
    {

        $this->columns = array('ID', 'Number', 'Sex', 'Identification certainty', 'Species', 'Collection tag');

        $this->cssclass = 'tab_output';

        $this->pk = array('ID');

        $this->BLP_Search($db, $grouplevel);

        $this->query->cgrefcodes = array('Sex' => 'SPECIMENS.SEX');

        $aliastable = $this->query->setTable("Specimens");
        $aliastable1 = $this->query->setTable("Taxa");
        //$aliastable2 = $this->query->setTable("Cg_ref_codes");

        //$this->query->addJoin('(' . $aliastable . '.SPECIE_FLAG =' . $aliastable2 . '.RV_LOW_VALUE' . " and $aliastable2.RV_DOMAIN = 'VALUE_FLAG' " . ')');
        $this->query->addJoin($aliastable1 . '.IDOD_ID = ' . $aliastable . '.TXN_SEQNO');
        $basecolumns = array('ID' => $aliastable . '.SEQNO',
            'Identification certainty' => $aliastable . '.IDENTIFICATION_CERTAINTY',
            'Number' => $aliastable . '.SCN_NUMBER',
            'Sex' => $aliastable . '.SEX',
            'Collection tag' => $aliastable . '.NECROPSY_TAG',
            'Species' => $aliastable1 . '.CANONICAL_NAME');

        foreach ($basecolumns as $column => $alias) {
            $this->query->addColumn($column, $alias);
        }

        $filter = array('Filter_Specimen_Sex',
            'Filter_Specimen_Number',
            'Filter_Specimen_Date',
            'Filter_Specimen_Aut_Ref',
            'Filter_Specimen_Collection_Tag',
            'Filter_Specimen_Taxa');

        $this->addFilter($filter);

    }

}

/**
 *   Search_Organ_Lesions
 *   Search for Organ Lesions through the database
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009
 */
class Search_Organ_Lesions extends BLP_Search
{
    public function Search_Organ_Lesions($db, $grouplevel = false)
    {
        $this->BLP_Search($db, $grouplevel);

        $aliastable1 = $this->query->setTable("Organ_lesions");
        $aliastable2 = $this->query->setTable("Organs");
        $aliastable3 = $this->query->setTable("Lesion_types");
//		$aliastable4 = $this->query->setTable("Lesion_values");
//		$aliastable5 = $this->query->setTable("Parameter_methods");
//		$aliastable6 = $this->query->setTable("Parameter_domains");

        $basecolumns = array('Organ' => $aliastable2 . '.NAME',
            'Processus' => $aliastable3 . '.PROCESSUS',
            'Lesion Name' => $aliastable3 . '.NAME',
            'Description' => $aliastable1 . '.DESCRIPTION');

        foreach ($basecolumns as $column => $alias) {
            $this->query->addColumn($column, $alias);
        }

        $this->query->addJoin($aliastable2 . '.CODE =' . $aliastable3 . '.OGN_CODE');
        $this->query->addJoin($aliastable3 . '.SEQNO =' . $aliastable1 . '.LTE_SEQNO');

        $filter = array('Filter_Autopsy_Ref_Organ_Lesions');
        $this->addFilter($filter);
    }
}

/**
 *   Search_Orders
 *   Search for Orders through the database
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009
 */
class Search_Orders extends BLP_Search
{

    public function Search_Orders($db, $grouplevel = false)
    {

        $this->columns = array('Person', 'Request Date', 'Study Description', 'Return Date', 'Rent Date', 'Status');
        $this->cssclass = 'tab_output';
        $this->pk = array('Seqno');

        $this->BLP_Search($db, $grouplevel); // init renderer with columns specified above

        $alias1 = $this->query->setTable("Request_loans");
        $alias2 = $this->query->setTable("Cg_ref_codes");

        $alias3 = $this->query->setTable("Person2requests");
        $alias4 = $this->query->setTable("Persons");

        $this->query->addJoin($alias3 . '.RLN_SEQNO =' . $alias1 . '.SEQNO');
        $this->query->addJoin($alias4 . '.SEQNO =' . $alias3 . '.PSN_SEQNO');


        $basecolumns = array('Seqno' => $alias1 . '.SEQNO',
            'Status' => $alias2 . '.RV_MEANING',
            'Request Date' => $alias1 . '.DATE_REQUEST',
            'Study Description' => $alias1 . '.STUDY_DESCRIPTION',
            'Return Date' => $alias1 . '.DATE_RT',
            'Rent Date' => $alias1 . '.DATE_OUT',
            'Person' => $alias4 . '.LAST_NAME  || \' \' ||' . $alias4 . '.FIRST_NAME');

        foreach ($basecolumns as $column => $alias) {
            $this->query->addColumn($column, $alias);
        }
        $this->query->addJoin($alias1 . '.STATUS =' . $alias2 . '.RV_LOW_VALUE');
        $this->query->addJoin($alias2 . ".RV_DOMAIN = 'STATUS_REQUEST_LOAN'");
        $filter = array('Filter_Order_by_name',
            'Filter_Order_Req_Date',
            'Filter_Order_Return_Date',
            'Filter_Order_Rent_Date',
            'Filter_Order_Study_Description');

        $this->addFilter($filter);
    }
}

/**
 *   Search_Institutes
 *   Search for Institutes through the database
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009
 */
class Search_Institutes extends BLP_Search
{

    public function Search_Institutes($db, $grouplevel = false)
    {
        $this->columns = array('Code', 'Name');
        $this->cssclass = 'tab_output';
        $this->pk = array('Seqno');

        $this->BLP_Search($db, $grouplevel);
        $aliastable = $this->query->setTable("Institutes");

        $basecolumns = array('Seqno' => $aliastable . '.SEQNO',
            'Code' => $aliastable . '.CODE',
            'Name' => $aliastable . '.NAME');

        foreach ($basecolumns as $column => $alias) {
            $this->query->addColumn($column, $alias);
        }

        $filter = array('Filter_Institute_Code', 'Filter_Institute_Name');

        $this->addFilter($filter);
    }

}

/**
 *   Search_Persons
 *   Search for Persons through the database
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009
 */
class Search_Persons extends BLP_Search
{

    public function Search_Persons($db, $grouplevel = false)
    {

        $this->columns = array('Last Name', 'First Name', 'Address', 'Phone number', 'Email');
        $this->cssclass = 'tab_output';

        $this->pk = array('Seqno');

        $this->BLP_Search($db, $grouplevel);

        $aliastable = $this->query->setTable("Persons");
        $aliastable2 = $this->query->setTable("Institutes");


        $basecolumns = array('Seqno' => $aliastable . '.SEQNO',
            'Last Name' => $aliastable . '.LAST_NAME',
            'First Name' => $aliastable . '.FIRST_NAME',
            'Address' => $aliastable . '.ADDRESS',
            'Phone number' => $aliastable . '.PHONE_NUMBER',
            'Email' => $aliastable . '.EMAIL',
            'Sex' => $aliastable . '.SEX',
            'Title' => $aliastable . '.TITLE',
            'Login Name' => $aliastable . '.LOGIN_NAME',
            'IDOD Id' => $aliastable . '.IDOD_ID',
            'Institute Code' => $aliastable2 . '.CODE',
            'Institute Name' => $aliastable2 . '.NAME');

        foreach ($basecolumns as $column => $alias) {
            $this->query->addColumn($column, $alias);
        }

        $this->query->addJoin($aliastable2 . '.SEQNO =' . $aliastable . '.ITE_SEQNO');
        $this->query->addJoin('(' . $aliastable . '.LAST_NAME IS NOT NULL OR ' . $aliastable . '.FIRST_NAME IS NOT NULL' . ')');
        $filter = array('Filter_Person_Name', 'Filter_Person_Email');

        $this->addFilter($filter);

    }
}

class Search_Taxas extends BLP_Search
{
    public function __construct($db, $grouplevel = false)
    {
        $this->columns = array('Idod Id', 'Taxa', 'Trivial Name');
        $this->cssclass = 'tab_output';
        $this->pk = array('Idod Id');
        $this->BLP_Search($db, $grouplevel); // init renderer with columns specified above

        $alias1 = $this->query->setTable("Taxas");
        $this->query->addColumn("Idod Id", $alias1 . ".IDOD_ID");
        $this->query->addColumn("Taxa", $alias1 . ".TAXA");
        $this->query->addColumn("Trivial Name", $alias1 . ".TRIVIAL_NAME");

        $filter = array('Filter_Taxa_Taxa', 'Filter_Taxa_Idod_Id', 'Filter_Taxa_Trivial_Name');

        $this->addFilter($filter);
    }
}

class Search_Spec2events_autopsies extends BLP_Search
{
    public function __construct($db, $grouplevel = false)
    {
        $this->columns = array('Date', 'Place', 'Obs. Type', 'Species', 'Sex', 'Number', 'Specimen ID', 'ODN Collection tag');

        $this->cssclass = 'tab_output';

        $this->pk = array('Picture', 'Specimen ID');

        $this->BLP_Search($db, $grouplevel);

        $alias0 = $this->query->setTable("Spec2Events");
        $alias1 = $this->query->setTable("Event_States");
        $alias2 = $this->query->setTable("Observations");
        $alias3 = $this->query->setTable("Stations");
        $alias4 = $this->query->setTable("Places");
        $alias5 = $this->query->setTable("Cg_ref_codes"); // osn_type
        $alias6 = $this->query->setTable("Specimens");
        $alias7 = $this->query->setTable("Taxa");

        // station type temporarely hidden

        $basecolumns = array('Obs. Type' => $alias5 . '.RV_MEANING',
            'Date' => $alias1 . '.EVENT_DATETIME',//REF: db changes
            'Place' => $alias4 . '.NAME',
            'Species' => $alias7 . '.VERNACULAR_NAME_EN',
            'Number' => $alias6 . '.SCN_NUMBER',
            'Sex' => $alias6 . '.SEX',
            'ODN Collection tag' => $alias6 . '.NECROPSY_TAG',
            'Specimen ID' => $alias6 . '.SEQNO');

        foreach ($basecolumns as $column => $alias) {
            $this->query->addColumn($column, $alias);
        }
        $this->query->addJoin($alias0 . '.ESE_SEQNO = ' . $alias1 . '.SEQNO');
        $this->query->addJoin($alias1 . '.SEQNO = ' . $alias2 . '.ESE_SEQNO');
        $this->query->addJoin($alias2 . '.STN_SEQNO =' . $alias3 . '.SEQNO');
        $this->query->addJoin($alias3 . '.PCE_SEQNO = ' . $alias4 . '.SEQNO (+)');
        //$this->query->addJoin($alias5 . '.RV_DOMAIN = \'OSN_TYPE\'');
        $this->query->addJoin($alias2 . '.OSN_TYPE_REF = ' . $alias5 . '.SEQNO');
        $this->query->addJoin($alias6 . '.SEQNO = ' . $alias0 . '.SCN_SEQNO');
        $this->query->addJoin($alias7 . '.SEQNO = ' . $alias6 . '.TXN_SEQNO');
        $filter = array('Filter_Specimen_Date', 'Filter_Specimen_Taxa', 'Filter_Specimen_Collection_Tag');
        $this->addFilter($filter);
    }
}

/**
 *  Search Specimens to Events
 *
 *  Cross product between Observations & Specimens
 *
 *  Ob1 => Mam1, Ob1 => Mam2
 *  Ob1 => Mam1, Ob2 => Mam1
 *
 *  VERSION:1.0.0
 *  AUTHOR: De Winter Johan
 *  LAST MODIFIED USER:De Winter Johan
 *  LAST MODIFIED DATE:19/04/2010
 */
class Search_Spec2events extends BLP_Search
{
    public function __construct($db, $grouplevel = false)
    {
        $this->columns = array('Date', 'Place', 'Obs. Type', 'Species', 'Sex', 'Number', 'Specimen ID', 'ODN Collection tag');

        $this->cssclass = 'tab_output';

        $this->pk = array('Picture', 'Specimen ID');

        $this->BLP_Search($db, $grouplevel);

        $alias0 = $this->query->setTable("Spec2Events");
        $alias1 = $this->query->setTable("Event_States");
        $alias2 = $this->query->setTable("Observations");
        $alias3 = $this->query->setTable("Stations");
        $alias4 = $this->query->setTable("Places");
        $alias5 = $this->query->setTable("Cg_ref_codes"); // osn_type
        $alias6 = $this->query->setTable("Specimens");
        $alias7 = $this->query->setTable("Taxa");

        // station type temporarely hidden

        $basecolumns = array('Obs. Type' => $alias5 . '.RV_MEANING',
            'Date' => $alias1 . '.EVENT_DATETIME',//REF: db changes
            'Place' => $alias4 . '.NAME',
            'Species' => $alias7 . '.VERNACULAR_NAME_EN',
            'Number' => $alias6 . '.SCN_NUMBER',
            'Sex' => $alias6 . '.SEX',
            'Collection tag' => $alias6 . '.NECROPSY_TAG',
            'Specimen ID' => $alias6 . '.SEQNO');

        foreach ($basecolumns as $column => $alias) {
            $this->query->addColumn($column, $alias);
        }
        $this->query->addJoin($alias0 . '.ESE_SEQNO = ' . $alias1 . '.SEQNO');
        $this->query->addJoin($alias1 . '.SEQNO = ' . $alias2 . '.ESE_SEQNO');
        $this->query->addJoin($alias2 . '.STN_SEQNO =' . $alias3 . '.SEQNO');
        $this->query->addJoin($alias3 . '.PCE_SEQNO = ' . $alias4 . '.SEQNO (+)');
        //$this->query->addJoin($alias5 . '.RV_DOMAIN = \'OSN_TYPE\'');
        $this->query->addJoin($alias2 . '.OSN_TYPE_REF = ' . $alias5 . '.SEQNO');
        $this->query->addJoin($alias6 . '.SEQNO = ' . $alias0 . '.SCN_SEQNO');
        $this->query->addJoin($alias7 . '.SEQNO = ' . $alias6 . '.TXN_SEQNO');
        $filter = array('Filter_Date');
        $this->addFilter($filter);
    }
}


/**
 *   Search_Observations
 *   Search for Observations through the database
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:25/01/2010
 */
class Search_Observations extends BLP_Search
{
    public function __construct($db, $grouplevel = false)
    {
        $this->columns = array('Seqno', 'Obs. Type', 'Latitude', 'Longitude', 'Date', 'Date Flag', 'Description');

        $this->cssclass = 'tab_output';

        $this->pk = 'Seqno';

        $this->BLP_Search($db, $grouplevel);

        $alias1 = $this->query->setTable("Observations");
        $alias2 = $this->query->setTable("Event_States");
        $alias3 = $this->query->setTable("Stations");
        $alias4 = $this->query->setTable("Places");
        $alias5 = $this->query->setTable("Cg_ref_codes"); // osn_type
        $alias6 = $this->query->setTable("Cg_ref_codes", "f"); // value flag


        $basecolumns = array('Seqno' => $alias1 . '.ESE_SEQNO',
            'Obs. Type' => $alias5 . '.RV_MEANING',
            'Latitude' => $alias1 . '.LATITUDE',
            'Longitude' => $alias1 . '.LONGITUDE',
            'Date' => $alias2 . '.EVENT_DATETIME',//REF: db changes
            'Date Flag' => $alias6 . '.RV_MEANING',
            'Description' => $alias2 . '.DESCRIPTION');

        foreach ($basecolumns as $column => $alias) {
            $this->query->addColumn($column, $alias);
        }

        $this->query->addJoin($alias1 . '.ESE_SEQNO = ' . $alias2 . '.SEQNO');
        $this->query->addJoin($alias1 . '.STN_SEQNO =' . $alias3 . '.SEQNO');
        $this->query->addJoin($alias3 . '.PCE_SEQNO = ' . $alias4 . '.SEQNO (+)');
        $this->query->addJoin($alias5 . '.RV_DOMAIN = \'OSN_TYPE\'');
        $this->query->addJoin($alias6 . '.RV_DOMAIN = \'VALUE_FLAG\'');
        $this->query->addJoin($alias1 . '.OSN_TYPE_REF = ' . $alias5 . '.SEQNO'); //REF: db changes
        $this->query->addJoin($alias2 . '.EVENT_DATETIME_FLAG_REF = ' . $alias6 . '.SEQNO'); //REF: db changes

        $filter = array('Filter_Date', 'Filter_Observation_Latitude', 'Filter_Observation_Observation_type');
        $this->addFilter($filter);
    }

}


/**
 *   Search_Samples
 *   Search for samples through the database
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009
 */
class Search_Samples extends BLP_Search
{

    public function Search_Samples($db, $grouplevel = false)
    {

        $this->columns = array('Seqno', 'Conservation Mode', 'Availability', 'Intended Use', 'Sample Type');

        $this->cssclass = 'tab_output';
        $this->pk = array('Seqno');

        $this->BLP_Search($db, $grouplevel); // init renderer with columns specified above
// must be set after $this->BLP_Search
        $this->query->cgrefcodes = array('Conservation Mode' => 'SAMPLES.CONSERVATION_MODE',
            'Analyze Dest' => 'SAMPLES.ANALYZE_DEST',
            'Availability' => 'SAMPLES.AVAILABILITY',
            'Sample Type' => 'SAMPLES.SPE_TYPE');

        $aliastable1 = $this->query->setTable("Samples");
        $aliastable2 = $this->query->setTable("Cg_ref_codes");
        $aliastable3 = $this->query->setTable("Cg_ref_codes", "f"); // Force the table to be set
        $aliastable4 = $this->query->setTable("Cg_ref_codes", "f"); // Force the table to be set
        //$aliastable5 = $this->query->setTable("Cg_ref_codes", "f"); // Force the table to be set

        $basecolumns = array('Seqno' => $aliastable1 . '.SEQNO',
            'Conservation Mode' => $aliastable2 . '.RV_MEANING',
            'Intended Use' => $aliastable3 . '.RV_MEANING',
            'Sample Type' => $aliastable4 . '.RV_MEANING',
            //'Availability' => $aliastable5 . '.AVAILABILITY'
        );

        foreach ($basecolumns as $column => $alias) {
            $this->query->addColumn($column, $alias);
        }

        $this->query->addJoin($aliastable1 . '.CONSERVATION_MODE =' . $aliastable2 . '.RV_LOW_VALUE');
        $this->query->addJoin($aliastable1 . '.ANALYZE_DEST =' . $aliastable3 . '.RV_LOW_VALUE');
        $this->query->addJoin($aliastable1 . '.SPE_TYPE =' . $aliastable4 . '.RV_LOW_VALUE');
        //$this->query->addJoin($aliastable1 . '.AVAILABILITY =' . $aliastable5 . '.RV_LOW_VALUE');
        $this->query->addJoin($aliastable2 . '.RV_DOMAIN = \'CONSERVATION_MODE\'');
        $this->query->addJoin($aliastable3 . '.RV_DOMAIN = \'ANALYZE_DEST\'');
        $this->query->addJoin($aliastable4 . '.RV_DOMAIN = \'SAMPLE_TYPE\'');
        //$this->query->addJoin($aliastable5 . '.RV_DOMAIN = \'AVAILABILITY\'');

        $filter = array('Filter_Sample_Conservation_mode',
            'Filter_Sample_Organs',
            'Filter_Sample_Localizations_Type',
            'Filter_Sample_Localizations_Name',
            'Filter_Sample_Specimen',
            'Filter_Sample_Sample_Type',
            'Filter_Sample_Analyze_Dest',
            'Filter_Sample_Aut_Ref',
            'Filter_Sample_Ref_Labo',
            'Filter_Sample_Localizations_Seqno',
            'Filter_Sample_Availability',
            'Filter_Sample_Date_Found');

        $this->addFilter($filter);
    }
}

?>