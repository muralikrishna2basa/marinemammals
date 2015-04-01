<?php

/**
 *    Class BLP_Renderer v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 *  Details:
 * ---------
 *  Render the results
 *
 *
 */
class BLP_Renderer
{
    /**
     * Contains the array of columns to display by the renderer
     *
     * @var array
     */
    public $columns = array();
    /**
     *  Contains the pager object,i.e methods to display the data's
     *
     */
    public $pager;
    /**
     * css class used to render the table with a prettier aspect
     *
     * @var unknown_type
     */
    public $cssclass;

    /**
     * Hide or Display the footer
     *
     * @var bool
     */
    public $hidefooter = false;

    /**
     * Hide or Display the Search button
     *
     * @var bool
     */
    public $hidesearch = false;
    /**
     * Array of results
     *
     * @var array
     */
    public $res = array();
    /**
     * Array of column class names keyed with their respective column name
     *
     * @var array
     */
    public $columnclass = array();

    public $pk;

    public $fullpk;

    /**
     * Contains all the conditions keyed with the column name.
     *
     * @var unknown_type
     */
    public $conditions = array();

    /**
     * Contains the cell calback keyed with the column name
     *
     * @var unknown_type
     */
    public $colconds = array();

    public $check = array();

    protected $footers = array();


    /**
     * Constructor
     *
     * @param array $columns
     * @param object $results
     */
    public function __construct($columns, $pager, $cssclass, $pk)
    {
        $this->columns = $columns;
        $this->pager = $pager;
        $this->cssclass = $cssclass;
        $this->pk = $pk;
    }

    // footer is an array of strings
    public function addFooter($footers)
    {
        if (is_string($footers) == true) {
            $this->footers[] = $footers;
            return true;
        }
        if (is_array($footers) == true) {
            foreach ($footers as $footer) {
                if (is_string($footer) == true) {
                    $this->footers[] = $footer;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Add a class to the column row of the corresponding column name
     *
     * @param array $nameclass
     */
    public function addFunctionClass($nameclass)
    {

        foreach ($nameclass as $name => $class) {
            if (in_array($name, $this->columns)) {
                $this->columnclass[$name] = $class;
            }
        }
    }

    /**
     * Add function to the corresponding column
     *
     * @param string $column
     * @param string $function
     */
    public function addFunctionColumn($column, $function)
    {
        $this->conditions[$column] = $function;
    }

    /**
     * Add function to the cell definition
     *
     * @param string $column
     * @param string $function
     */
    public function addCellFunction($column, $function)
    {
        $this->colconds[$column] = $function;
    }

    /**
     * Add a column to be rendered
     *
     * @param string or array  $column
     */
    public function addColumn($column)
    {

        if (is_string($column)) {
            if (!in_array($column, $this->columns)) {
                $this->columns[] = $column;
            }
            return;
        }

        if (is_array($column)) {

            $this->columns += $column;
            return;
        }


    }

    /**
     * Remove a column in the rendering process
     *
     * @param string $column
     */
    public function removeColumn($column)
    {
        if (in_array($column, $this->columns)) {
            unset($this->columns[array_search($column, $this->columns)]);

        }
    }

    /**
     * Sort Columns based on a array of names
     *
     * @param array $columns
     * @return void
     */
    public function sortColumns($columns)
    {

        if (!is_array($columns)) {
            return false;
        }

        $col_tmp = array();

        foreach ($columns as $keycolumn => $valcolumn) {
            if (in_array($valcolumn, $this->columns)) {
                $col_tmp[$keycolumn] = $valcolumn;
            }
        }
        $this->columns = array_unique(array_merge($col_tmp, $this->columns));
    }

}

/**
 *    Class Table_Renderer v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 *  Details:
 * ---------
 *  HTML Table representation
 *
 *
 */
class Table_Renderer extends BLP_Renderer
{

    public $header = "";

    public $body = "";

    public $footer = "";

    public $table = "";

    /**
     * Current Page
     *
     * @var integer
     */
    protected $current = 1; // First Page as Default Page


    /**
     * Set the current page number
     *
     * @param integer $current
     * @return bool ( true on success false otherwise)
     */
    public function setCurrentPage($current)
    {
        if (is_string($current) == true) {
            $this->current = $current;
            return true;
        }
        return false;
    }

    /**
     * Set the Header of the Table
     *
     */
    public function setHeader()
    {
        // contain headers columns linked so that a sort can be applied
        $this->header .= "<tr>\n";

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        $url = $_SERVER['PHP_SELF'];

        $sort_up = "<img width='12' height='12' class='sortleft'  alt='sort up' src='/legacy/img/upac.png'/>";
        $sort_down = "<img width='12' height='12' class='sortright' alt='sort down' src='/legacy/img/downac.png'/>";

        $sorted_up = "<img width='12' height='12' class='sortleft' alt='sorted up' src='/legacy/img/up.png'/>";
        $sorted_down = "<img width='12' height='12' class='sortright' alt='sorted down' src='/legacy/img/down.png'/>";


        foreach ($this->columns as $key => $column) {
            if (!is_string($key)) {
                $classsort = "class='sort'";
            } else {
                $classsort = "class='unsort'";
            }

            if (isset($page)) {
                $sort = $url . '?sort=' . rawurlencode($column) . '&page=' . $page;
            } else {
                $sort = $url . '?sort=' . rawurlencode($column);
            }

            if (isset($_GET['search_sort']) && $column == $_GET['search_sort']) {
                if (is_string($key)) {
                    $this->header .= "<th><a $classsort >$column</a></th>\n";
                } else {
                    $sortpos = array('ASC', 'DESC');
                    if (isset($_GET['sort_type']) && in_array($_GET['sort_type'], $sortpos)) {
                        if ($_GET['sort_type'] == 'ASC') {
                            $this->header .= "<th>$sorted_up<a sorted='" . $_GET['sort_type'] . "' $classsort href = '$sort'>$column</a>$sort_down</th>\n";
                        } else {
                            $this->header .= "<th>$sort_up<a sorted='" . $_GET['sort_type'] . "' $classsort href = '$sort'>$column</a>$sorted_down</th>\n";
                        }
                    } else {
                        $this->header .= "<th>$sort_up<a sorted='true' $classsort href = '$sort'>$column</a>$sort_down</th>\n";
                    }

                }
            } elseif (is_string($key)) {
                $this->header .= "<th><a $classsort >$column</a></th>\n";
            } else {
                $this->header .= "<th>$sort_up<a $classsort href = '$sort'>$column</a>$sort_down</th>\n";
            }
        }

        $this->header .= "</tr>\n";

    }

    public function setBody($current)
    {
        $results = $this->pager->getPagedResults($current);

        $oddeven = 0;

        $oddevenclass = 'even';

        while ($row = $results->fetch()) {
            $this->res[$oddeven] = $row;

            $oddeven++;

            $pk = array();

            // Determine the full pk out of the results set
            // in case of unique Seqno => {Seqno:125242} in case of composition {Seqno:14245,SCN_Seqno:256582}
            if (is_string($this->pk)) {
                $this->pk = array($this->pk);
            }
            foreach ($this->pk as $pk_item) {
                if (isset($row[$pk_item])) {
                    $pk[] = '"' . $pk_item . '":' . $row[$pk_item];
                }
            }

            $pk = '{' . implode(',', $pk) . '}';

            $this->fullpk = $pk;

            //

            if ($oddeven % 2 == 0) {
                $oddevenclass = 'odd';
            } else {
                $oddevenclass = 'even';
            }

            $this->body .= "<tr class = '$oddevenclass' pk = '$pk'>\n";

            foreach ($this->columns as $key => $column) {

                if (array_key_exists($column, $this->columnclass)) {
                    $columnclass = " class = '" . $this->columnclass[$column] . "' ";
                } else {
                    $columnclass = "";
                }

                if (in_array($column, array_keys($this->conditions)) == true && function_exists($this->conditions[$column]) == true) {
                    $condition_success = call_user_func($this->conditions[$column], $this);
                    if ($condition_success != false) // if something goes wrong with the function
                    {
                        if ($condition_success == 'key') // in case the function is ok
                        {
                            $this->body .= "<td $columnclass>" . $key . "</td>\n";
                        } elseif ($condition_success == 'value') {
                            $this->body .= "<td $columnclass>" . $column . "</td>\n";
                        }


                    }
                } elseif (in_array($column, array_keys($this->colconds)) == true && function_exists($this->colconds[$column]) == true) {
                    $this->body .= "<td $columnclass>" . call_user_func($this->colconds[$column], $this->fixEncoding($row[$column])) . "</td>\n";
                } else // if no conditions are implemented, then behaves normally
                {

                    if (is_string($key)) {
                        $this->body .= "<td $columnclass>" . $column . "</td>\n";
                    } elseif(array_key_exists($column,$row)) {
                        $this->body .= "<td $columnclass>" . $this->fixEncoding($row[$column]) . "</td>\n";
                    }
                    else{
                        $this->body .= "<td $columnclass>" . "NO DATA" . "</td>\n";
                    }
                }
            }
            $this->body .= "</tr>\n";
        }

    }

    public function fixEncoding($in_str)
    {
        $cur_encoding = mb_detect_encoding($in_str);
        if ($cur_encoding == "UTF-8" && mb_check_encoding($in_str, "UTF-8"))
            return $in_str;
        else
            return utf8_encode($in_str);
    }

    public function setFooter($current_page)
    {

        if (count($this->footers) > 0) {
            $footers = implode('|', $this->footers);
        } else {
            $footers = '';
        }
        $numrows = $this->pager->num_rows; // total number of records
        $numpages = $this->pager->num_pages; // total number of pages
        $rowspage = $this->pager->rows_per_page; // rows per page
        $current_page = (($current_page - 1) % $numpages) + 1;
        //  contain 1--Num_rows
        //  contain arrow left select arrow right
        // the select choose the current page, the arrow move backward or forward to the desired page

        // 	$footer = "This is the header -- debugging purpose"." current page:($current_page),
        // 	           Number of pages:($numpages) Number of records :($numrows) rows per page:($rowspage)";

        if ($this->hidesearch == false) {
            $searchornot = "<input class = 'searchornot' name='search tool' type ='button' value='Show Filter(s)'></input>";
        } else {
            $searchornot = "<input class = 'searchornot' name='search tool' type ='button' value='Show Filter(s)' style='visibility:hidden;'></input>";
        }

        $footer = "<div class='search'>" . $searchornot . "</div>";

        $rowpage = "<select class='rpp'>";
        for ($rpp = 5; $rpp < 50; $rpp = $rpp + 5) {
            if ($rpp == $rowspage) {
                $rowpage .= "<option selected ='selected'>$rpp</option>";
            } else {
                $rowpage .= "<option>$rpp</option>";
            }
        }
        $rowpage .= "</select>";

        $footer .= "<div class='board'> page $current_page &ndash; $numpages pages &ndash; $numrows records &nbsp; &nbsp; $rowpage rows per page $footers </div>";

        $url = $_SERVER['PHP_SELF'];

        $next = "<a class ='next_page' href ='" . $url . "?page=" . ($current_page + 1) . "' >NEXT</a>";

        $previous = "<a class = 'previous_page' href ='" . $url . "?page=" . ($current_page - 1) . "' >PREV</a>";

        $searchornot = "<input type ='checkbox'></input>";

        $selectpage = "<select>";
        for ($i = 1; $i <= $numpages; $i++) {
            if ($i == $current_page) {
                $selectpage .= "<option selected ='selected'>$i</option>";
            } else {
                $selectpage .= "<option>$i</option>";
            }
        }
        $selectpage .= '</select>';

        $footer .= '<div class = "navigation_bar">' . $previous . ' ' . $selectpage . ' ' . $next . '</div>';

        $this->footer = "<tr><td colspan='" . count($this->columns) . "'>" . $footer . "</td>\n</tr>";
    }

    /**
     *  Build the complete html table
     *
     */
    public function build($current = false)
    {

        if (!is_string($current)) {
            $current = $this->current;
        }

        $this->setHeader();

        $this->setBody($current);

        $this->setFooter($current);

        if ($this->hidefooter == true) {
            $this->table = stripcslashes("<table class = '$this->cssclass' >
    					<thead>$this->header</thead>\n
    					<tfoot style='display:none'>$this->footer</tfoot>\n
    					<tbody>$this->body </tbody>\n
    				  </table>");
        } else {
            $this->table = stripcslashes("<table class = '$this->cssclass' >\n
    					<thead>$this->header</thead>\n
    					<tfoot>$this->footer</tfoot>\n
    					<tbody>$this->body </tbody>\n
    				  </table>");
        }
    }

}


?>