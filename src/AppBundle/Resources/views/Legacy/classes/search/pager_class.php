<?php

/**
 *    Class BLP_Filter, Filters v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 *  Details:
 * ---------
 *
 *               oracle.php, search_query.php
 *           for a specific query, the pager returns the paged results ( i.e the number of results
 *           belonging to a specific page, the results are part of the oracleresults ressource )
 *
 */

include_once(Classes . 'search/search_query.php');


class BLP_Pager
{
    /**
     * Contains the database instance
     *
     * @var unknown_type
     */
    public $db;

    /**
     * Query object that will be wrapped
     *
     * @var object
     */
    public $query;


    public $num_pages = false;
    /**
     * contains the total number of rows for the output
     *
     * @var Integer
     */
    public $num_rows = false;
    /**
     * Rows per page
     *
     * @var Integer
     */
    public $rows_per_page = false;

    public $start_row;

    public $end_row;

    public $default_rows_per_page = 15;

    public function __construct($query, $db, $rows_per_page = false)
    {
        $this->query = $query;
        $this->db = $db; // get it from Searcher

        if ($rows_per_page == false) {
            $rows_per_page = $this->default_rows_per_page;
        } // DEfault number of rows per page
        $this->rows_per_page = $rows_per_page;
    }

    public function setRowsPage($in)
    {
        $this->rows_per_page = $in;
    }

    /**
     * Given a current row, it compute the starting point of the bandwidth
     * and the ending point of the bandwidth;
     * @param integer $current
     * @return starting row
     */
    public function bandwidth($current)
    {
        if (!$this->num_rows) {
            $this->getNumrows();
        }
        $this->getNumpages(); // Instanciate the number of pages

        if ($current < 1) {
            $current = 1;
        }

        if ($this->num_rows == 0) {
            $current = 1;
        } else {

            $current = ($current - 1) % (ceil($this->num_rows / $this->rows_per_page)) + 1;
        }
        if ($current < 2) {
            $current = 1;
        }
        $this->start_row = ($current - 1) * $this->rows_per_page + 1;
        $this->end_row = $this->start_row + $this->rows_per_page - 1;
        return $this->end_row - $this->start_row;
    }

    public function getNumpages()
    {

        if ($this->num_pages) {
            return $this->num_pages;
        }

        if (!$this->num_rows) {
            $num_rows = $this->getNumrows();
        }

        if ($this->num_rows < 1) {
            $total_rows = 1;
        } else {
            $total_rows = $this->num_rows;
        }
        $this->num_pages = ceil($total_rows / $this->rows_per_page);
        return ceil($total_rows / $this->rows_per_page);
    }

    /**
     * To get the number of rows and associated pages a get Numb rows is first needed
     *
     * @return unknown
     */
    public function getNumrows()
    {

        if ($this->query->sqlquery == false) {
            $this->query->build();
        }


        $sql = $this->query->sqlquery;
        $binds = $this->query->bindings;

        $sql = "SELECT count(*) AS NUM_ROWS FROM($sql)";

        if (count($binds) > 0) {
            $result = $this->db->query($sql, $binds);
        } else {
            $result = $this->db->query($sql);
        }

        if ($row = $result->fetch()) {

            $this->num_rows = $row['NUM_ROWS'];

        } else {
            $this->num_rows = 0;
        }


        return $this->num_rows;
    }

    public function getPagedResults($currentpage)
    {

        $this->bandwidth($currentpage);

        $start_row = $this->start_row;
        $end_row = $this->end_row;

        if ($this->query->sqlquery == false) {
            $this->query->build();
        }
        $sql = $this->query->sqlquery;

        $this->query->bindings[':start_row'] = $start_row;
        $this->query->bindings[':end_row'] = $end_row;

        $sql = "SELECT
            *
         FROM 
            (
                SELECT
                    r.*, ROWNUM as row_number 
                FROM
                    ( $sql ) r
                WHERE
                    ROWNUM <= :end_row
            )
         WHERE :start_row <= row_number";

        $binds = $this->query->bindings;
        if (count($binds) > 0) {
            return $this->db->query($sql, $binds);
        } else {
            return $this->db->query($sql);
        }
    }


}

?>