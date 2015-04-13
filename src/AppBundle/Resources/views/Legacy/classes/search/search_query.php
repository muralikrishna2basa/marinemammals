<?php
/**
 *    Class BLP_Query v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 *  Details:
 * ---------
 *
 *    Build the complete query
 *
 *     sql statement : select (columns) from (tables) (where_clause) order by (order)
 *    format columns : alias_table.name_column  " column name alias",...
 *    format tables  :  table "alias_table",...
 *    format where_clause : where joined_condition1 and joined_condition2,...and filter_1,.... order by ...
 *    format joined_condition1 : alias_table1.column_name1 = alias_table1.column_nam2, ....
 *    format filter_1 : alias_table.column_name operator binded_variable
 *
 *  Each filter contains only one binded variable.
 *
 *  A mechanism is needed to create the aliases
 *  Class needed : build the query,
 *                 contains all the query related data's in the right format( i.e columns,tables,where_clause)
 */
include_once(Functions . 'Fixcoding.php');

class BLP_Query
{
    /**
     * Contains all the tables keyed with their aliases
     * Array('a'=> 'SCHEMA.TABLENAME' )
     * @var array
     *
     */
    public $tables = array();
    /**
     * Contains all the columns keyed with their aliases
     * Array('Table expression'=>'a.COLUMNNAME')
     * @var array
     */
    public $columns = array();

    /**
     * Array('Column expression'=>'Table meaning')
     * Particular treatment for cg_ref_codes, a view might point to multiple elements
     * of cg_ref_codes, i.e Samples.
     *
     * @var array
     */
    public $cgrefcodes = array();
    /**
     * Array of elements constituing the where clause
     *
     * @var array
     */
    public $wheres = array();
    /**
     * Array of binded variables keyed to their binded names
     * Array(':binded_name' => binded_value)
     * @var array
     */
    /**
     * Array of joins no keying scheme
     *
     * @var array
     */
    public $joins = array();

    /**
     * Array of binding values keyed with their aliases :a_0 as example
     * Array( ':a_0' => 'foo' )
     * @var array
     */
    public $bindings = array();

    /**
     * Order by elements
     * no keying scheme
     * @var unknown_type
     */
    public $orders = array();
    /**
     * Complete sql query receptor constructed by build()
     *
     * @var array
     */
    public $sqlquery = false;

    /**
     * get the column, given the corresponding alias
     *
     * @param string $alias
     * @return string
     */
    public function getColumn($alias)
    {
        if (in_array($alias, $this->columns)) {
            return array_search($alias, $this->columns);
        } else {
            return false;
        }
    }

    /**
     * Set the table and create a keyed alias
     *
     * @param string $table
     * @return string alias
     */
    public function addColumn($column, $alias = false)
    {
        // The array of columns must be case insensitive
        // The column is not created if the same column already exists

        $columns = $this->columns;
        $column_search = array();
        foreach ($columns as $alias1 => $column_s) {
            $column_search[$alias1] = strtolower($column_s);
        }
        if (!array_search(strtolower($column), $column_search)) {
            if (!$alias) {
                $this->columns[] = $column;
            } else {
                $this->columns[$alias] = $column;
            }
        }
    }

    /**
     * Set the table along with the other tables defining the query
     *
     * @param string $table
     * @return  the alias of the table ( if already created then search the created alias)
     */
    public function setTable($table = "", $arg = false)
    {
        if ($arg) {
            switch ($arg) {
                case 'f';
                    $alias = chr(count($this->tables) + 97); //0 is "a" cfer http://www.asciitable.com/
                    $this->tables[$alias] = $table;

                    break;
            }
            return $alias;
        }
        // make the array of tables  case insensitive
        $tables = $this->tables;
        $table_search = array();
        foreach ($tables as $alias => $table_s) {
            $table_search[$alias] = strtolower($table_s);
        }


        if (!array_search(strtolower($table), $table_search)) {
            $alias = chr(count($this->tables) + 97); //0 is "a" cfer http://www.asciitable.com/
            $this->tables[$alias] = $table;
            return $alias;
        } else {
            return array_search(strtolower($table), $table_search);
        }
    }


    /**
     * Add a join to the set of joins constructed by the query
     *
     * @param the join to be added
     * @return Number of join conditions
     */
    public function addJoin($join)
    {
        if (!in_array($join, $this->joins)) {
            $this->joins[] = $join;
        }
        return count($this->joins);
    }

    public function addOrder($order, $ordertype = 'ASC')
    {
        if (!array_key_exists($order, $this->orders)) {
            $this->orders[$order] = $ordertype;
        }
        return count($this->orders);
    }

    /**
     * Given the column expression, this function
     * return the alias of the corresponding name
     * the separator is assumed to be the point
     * @param unknown_type $column
     */
    public function getTableAlias($column)
    {

        if (array_key_exists($column, $this->columns)) {
            $tablealias = explode('.', $this->columns[$column]);
            return $tablealias[0];
        } else {
            return false;
        }
    }


    /**
     * $where is an array ( sql condition => binded value)
     *
     * create the binding ( name + input value)
     * @return void
     */

    public function addWhere($where)
    {
        // convert html encoded elements into sql interpretable elements
        $where = $this->htmlDecode($where);

        $newwhere = "";

        foreach ($where as $elem) {
            if (is_array($elem)) {
                $bind_value = $elem[0];
                $tmp = count($this->bindings);
                $bind_el = chr(($tmp) % 26 + 97) . chr(floor($tmp / 26) + 97);
                $bind_name = ':' . $bind_el . '_' . count($this->wheres);
                $this->bindings[$bind_name] = fixEncoding($bind_value);
                $newwhere .= $bind_name;
            } else {
                $newwhere .= ' ' . $elem . ' ';
            }
        }

        $this->wheres[] = $newwhere;

    }


    /**
     * Enter description here...
     *
     * @param array or string $in
     * @return array
     */
    protected function htmlDecode($in)
    {
        // array to be expanded
        $html_to_decode = array('&ne;' => '!=', '&gt;' => '>', '&lt;' => '<');

        if (is_string($in)) {
            foreach ($html_to_decode as $html => $conv) {
                $in = str_replace($html, $conv, $in);
            }
            return $in;

        } elseif (is_array($in)) {
            for ($i = 0; $i < count($in); $i++) {
                foreach ($html_to_decode as $html => $conv) {
                    $in[$i] = str_replace($html, $conv, $in[$i]);
                }
            }
            return $in;
        }
    }

    /**
     * Build the complete sql request
     *
     * @return string containing the sql statement
     */
    public function build()
    {

        $columns = array();

        foreach ($this->columns as $columnExpression => $columnAlias) {
            if (is_numeric($columnAlias)) {
                $columns[] = $columnExpression;
            } else {
                $columns[] = "($columnExpression) \"$columnAlias\"";
            }
        }
        $columns = implode(", ", $columns);

        $tables = array();

        foreach ($this->tables as $tableAlias => $tableExpression) {
            $tables[] = "($tableExpression) $tableAlias";
        }

        $tables = implode(", ", $tables);

        $where_clause = false;
        // Add the joins

        if ($this->joins) {
            $where_clause .= implode(' and ', $this->joins);
            if ($this->wheres) {
                $where_clause .= ' and ';
                $where_clause .= implode(' and ', $this->wheres);
            }
        }

        if ($this->wheres && !$this->joins) {
            $where_clause .= implode(' and ', $this->wheres);
        }

        if ($where_clause) {
            $where_clause = " WHERE $where_clause ";
        }

        $this->sqlquery = "SELECT $columns FROM $tables $where_clause";

        if ($this->orders) {
            $ordercomplete = array();
            foreach ($this->orders as $ordername => $ordertype) {
                $ordercomplete[] = 'ORDER BY ' . $ordername . ' ' . $ordertype;
            }
            $this->sqlquery .= implode(",", $ordercomplete);
        }
    }

    /**
     * return columns array in format ( table.column => alias )
     * instead of ( (table alias).column => alias)
     */
    public function mapattributes()
    {
        $columns = $this->columns;

        $tables = $this->tables;
        $tmptmp = array();
        foreach ($columns as $key => $value) {
            if (array_key_exists($value, $this->cgrefcodes)) {
                $tmptmp[$this->cgrefcodes[$value]] = $value;
            } else {
                $tmp = explode('.', $key);
                $toto = $tables[$tmp[0]] . '.' . $tmp[1];
                $tmptmp[$tables[$tmp[0]] . '.' . $tmp[1]] = $value;
            }
        }
        return $tmptmp;
    }

}


?>