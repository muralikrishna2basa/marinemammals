<?php

/**
 *    Class Menu v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 *  Details:
 * --------
 *
 * Set menus based on the defined group
 *
 * As each group also have a corresponding level, the user connected through the interface
 * will have the menus of the highest level
 *
 */
class Menu
{
    /**
     * Each user is set into a group, the default group of users is GUEST
     *
     * @var string
     */
    protected $group = "GUEST";

    /**
     * Display the menus items in the menu bar
     * collection of items name keyed with their correspondants php destination
     *
     */
    protected $menus;

    /**
     *  Collection of hiddens elements ( contain the name keyed with a boolean specifying the hidden property of each items)
     *
     * @var array
     */
    protected $hiddens = array();

    protected $db;

    protected $hasproceed = false;

    protected $cssclass = "menus_default";

    public function __construct(ORACLE $db, $cssclass = false)
    {
        $this->db = $db;
        if ($cssclass != false) {
            $this->class = $cssclass;
        }
    }

    /**
     * Hide menu item
     *
     * @param string $name
     * @param bool $set
     * @return Bool
     */
    public function setHidden($name, $set = true)
    {
        if (is_bool($set)) {
            $this->hiddens[$name] = $set;
            return true;
        } else {
            return false;
        }

    }

    /**
     * Might be applied in the layout items, so that the hidden property can be set
     *
     *
     * @param unknown_type $grpname
     * @return unknown
     */
    public function retrieve_menus($grpname)
    {
        if (!is_string($grpname)) {
            return array(false => 'Group name is not a string');
        }

        $bind = array(':a0' => $grpname);

        $sql = "select a.name,a.script from (menus) a, (group2menus) b, (groups) c
				where a.seqno = b.mnu_seqno and b.grp_name = c.name
				and c.name = :a0 and a.display = 'Y' order by a.display_order ";

        $r = $this->db->query($sql, $bind);

        if (is_bool($r) || $r == false) {
            return false;
        }

        if ($r->isError()) {
            return array(false => $r->errormessage());
        }

        while ($row = $r->fetch()) {
            $this->menus[$row['NAME']] = $row['SCRIPT'];
        }

        $this->hasproceed = true;
        return true;
    }

    public function setGroup($grpname)
    {
        if (!is_string($grpname)) {
            return;
        }

        $bind = array(':a0' => $grpname);

        $sql = "select count(*) as isgroup from groups where name = :a0";

        $r = $this->db->query($sql, $bind)->fetch();

        if ($r['ISGROUP'] != 1) {
            return array(false => 'Not a registered Group');
        }

        $this->group = $grpname;

        return true;
    }

    public function render()
    {

        $grpname = $this->group;

        if ($this->hasproceed == false) { // if the retrieve_menus method has not been yet called
            $tmp = $this->retrieve_menus($grpname);
            if ($tmp != true) {
                return $tmp;
            }
        }

        $rend = "<ul class = \'$this->cssclass\'>";
        foreach ($this->menus as $item_key => $item_value) {

            if (array_key_exists($item_key, $this->hiddens) && $this->hiddens[$item_key] == true) {
                // display only if not set to hidden
            } else {
                if ($_SERVER['PHP_SELF'] == $item_value) {
                    $rend .= "<li class=\'isclicked\'><a href = \'$item_value\'>$item_key</a></li>";
                } else {
                    $rend .= "<li ><a href = \'$item_value\'>$item_key</a></li>";
                }
            }
        }
        $rend .= "</ul>";
        return $rend;

    }

}

?>