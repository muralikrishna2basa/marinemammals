<?php


class Flow
{

    public $FLOW_WARNING = "There is no event sequence number defined to work with, therefore the page cannot load. This happens if you reload the page. Please start the import procedure anew.";
    /**
     * Array of php documents
     *
     * @var array
     */
    protected $includes = array();

    /**
     * Array of php documents name
     *
     *
     */
    protected $includesname = array();
    /**
     * Server
     *
     * @var string
     */
    protected $server;

    protected $flow = 0;

    /**
     * Event key, contains the flow line element
     * ex : array('seqno'=>4) || array('event_State'=>4)
     * @var array
     */
    protected $thread = false;

    /**
     * Database component
     *
     * @var Oracle
     */
    protected $db;
    /**
     * Authentication component
     *
     * @var Object
     */
    protected $auth;

    /**
     * display a statebar item
     *
     * @var array
     */
    protected $statebar = array();

    /**
     * array of posted elements, registered in the includes, and unsetted at the end
     *
     * @var unknown_type
     */
    protected $posted = array();

    public $validation;

    public $flowname = 'flow';

    public function __construct($server = false, $flowname = false, $db = false, $auth = false)
    {
        if ($auth instanceof Auth) {
            $this->auth = $auth;
        }

        if ($flowname != false && is_string($flowname) && strlen($flowname) > 0) {
            $this->flowname .= '_' . $flowname;
        }

        if ($db instanceof Oracle) {
            $this->db = $db;
        }

        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION[$this->flowname])) {
            $flow = unserialize($_SESSION[$this->flowname]);

            if ($flow instanceof Flow) {
                $this->flow = $flow->flow;

                $this->statebar = $flow->statebar;

                $this->validation = $flow->validation;

                $this->thread = $flow->thread;

                return;
            }
        }
        if ($server == false) {
            $this->server = $_SERVER['PHP_SELF'];
        } else {
            $this->server = $server;
        }

    }

    public function addPost($postname)
    {
        if (is_string($postname) && strlen($postname) > 0) {
            $this->posted[] = $postname;
        }
    }

    public function isSubmitted()
    {
        return isset($_POST['button']) ? true : false;
        //return !isset($_POST) || count($_POST)==0?false:true;
    }

    /**
     * Set the state bar
     *
     * @param array $bar
     */
    public function setStateBar($bar)
    {
        if (is_array($bar)) {
            $this->statebar = $bar;
        }
    }

    /**
     * Render the corresponding statebar
     *
     * @return unknown
     */
    protected function renderStateBar()
    {
        $bar_render = "";
        if (count($this->statebar) > 0) {
            $bar_render .= "<div class='statebar'><ul>";
            //$bar_render .= "<div class='outer_statebar'><div class='statebar'><ul>";
            for ($i = 0; $i < count($this->includes); $i++) {
                $elem = $this->statebar[$i % count($this->statebar)];

                if ($this->thread != false && $this->current() != 0 && $i > 0) {
                    $elem = "<a href='$i' class='screen'>$elem</a>";
                }

                //	if(isset($_SESSION[$this->flowname]) && $i > 0 ){ $elem = "<a href='#'>$elem</a>";}

                if ($this->flow == $i) {
                    $bar_render .= "<li class='isclicked'>$elem</li>";
                } else {
                    $bar_render .= "<li>$elem</li>";
                }
            }
            $bar_render .= "</ul></div>";
            //$bar_render .="</ul></div></div>";
        }
        return $bar_render;
    }
//	public function init()
//	{
//		$this->flow = 0; // array is zero based
//	}
    public function setDb($db)
    {
        if ($db instanceof ORACLE) {
            $this->db = $db;
        }
    }

    public function setAuth($auth)
    {
        if ($auth instanceof Auth) {
            $this->auth = $auth;
        }
    }

    /**
     * Set the thread element
     *
     * @param array $thread
     */
    public function InitThread()
    {
        $this->thread = false;
    }

    protected function clearPosted()
    {
        foreach ($this->posted as $postname) {
            unset($_POST[$postname]);
        }
    }

    /**
     * Get the thread element
     *
     * @return array
     */
    public function getThread()
    {
        return $this->thread;
    }

    public function addInclude($include) // add Include if file exists
    {
        if (is_string($include) && count($include) > 0) {
            $include = array($include);
        } elseif (count($include) == 0) {
            return false;
        }
        foreach ($include as $key => $item) {
            if (file_exists($item)) {
                $this->includes[] = $item;
                $this->includesname[$key] = "";
            }

        }
    }

    /**
     * add array of javascript and css files in form of an array keyed with the input name
     *
     * @param unknown_type $data
     */
    public function addJsCss($data)
    {
        if (!is_array($data)) {
            return false;
        }

        foreach ($data as $name => $jscss) {
            if (!array_key_exists($name, $this->includesname) || !is_array($jscss)) {
                continue;
            }
            if (array_key_exists('css', $jscss)) {
                $this->includesname[$name]['css'] = $jscss['css'];
            }
            if (array_key_exists('js', $jscss)) {
                $this->includesname[$name]['js'] = $jscss['js'];
            }
        }

    }

    private function getJsCss($position)
    {
        reset($this->includesname);

        for ($i = 0; $i < $position; $i++) {
            next($this->includesname);
        }

        return current($this->includesname);

    }

    public function getCurrentJsCss()
    {
        return $this->getJsCss($this->flow);
    }

    public function getPrevJsCss()
    {
        return $this->getJsCss(($this->flow - 1) % count($this->includes));
    }

    public function getNextJsCss()
    {
        return $this->getJsCss(($this->flow + 1) % count($this->includes));
    }

    public function current()
    {
        return $this->flow;
    }

    public function next()
    {
        $this->flow += 1;
        if ($this->flow > count($this->includes) - 1) {
            $this->flow = count($this->includes) - 1;
        }
        $this->save();
        return $this->flow;
    }

    public function init()
    {
        $this->flow = 0;
        $this->InitThread();
        if ($this->flow > count($this->includes) - 1) {
            $this->flow = count($this->includes) - 1;
        }
        $this->save();
        return $this->flow;

    }

    public function go_to($i)
    {
        $this->flow = $i;
        if ($this->flow > count($this->includes) - 1) {
            $this->flow = count($this->includes) - 1;
        }
        $this->save();
        return $this->flow;
    }

    public function prev()
    {
        $this->flow += -1;
        if ($this->flow == -1) {
            $this->flow = 0;
        }
        $this->save();
        return $this->flow;
    }

    public function getButtons()
    {
        $statebar = $this->renderStateBar();
        if ($this->flow == 0) {
            return "<div class ='flow'>$statebar</div>" .
            "<input style='display:none;' name='flow' value = '$this->flowname'/>";
        }
        if ($this->flow == count($this->includes) - 1) {
            return "<div class ='flow'>
				    <button type='submit' class='prev' name='prev'>" . $this->getButtonImage('previous') . "</button>
				    <button type='submit' class='refresh' name='refresh'>" . $this->getButtonImage('refresh') . "</button>
				    $statebar
					<button type='submit' class='finish' name='finish'>" . $this->getButtonImage('home') . "</button></div>" .
            "<input style='display:none;' name='flow' value = '$this->flowname'/>";
        }

        $test = "<div class ='flow'><button type='submit' class='prev' name='prev'>" . $this->getButtonImage('previous') . "</button>";
        $test .= "<button type='submit' class='refresh' name='refresh'>" .
            $this->getButtonImage('refresh') . "</button>";
        $test .= "$statebar<button type='submit' class='finish' name='finish'>" .
            $this->getButtonImage('home') . "</button>
				  <button type='submit' class='next' name='next'>" . $this->getButtonImage('next') . "</button></div>";
        $test .= "<input style='display:none;' name='flow' value = '$this->flowname'/>";
        return $test;
    }

    public function getInitButton()
    {
        return "<button type='submit' class='next' name='next'>" . $this->getButtonImage('next') . "</button>";
    }

    public function getButtonImage($name)
    {
        switch ($name) {
            case 'refresh':
                return "<img alt='refresh' src='/legacy/img/Container_Localizations/refresh.png'></img>";
            case 'home':
                return "<img alt='home' src='/legacy/img/Container_Localizations/stop.png'></img>";
            case 'next':
                return "<img alt='NEXT' src='/legacy/img/next.png'></img>";
            case 'previous':
                return "<img alt='PREV' src='/legacy/img/previous.png'></img>";
        }
    }

    public function __toString() // return the html content of the corresponding include
    {
        // if a finish button is pressed, then go directly to the first page
        if ((isset($_POST['button']) && $_POST['button'] == 'finish')
            || (isset($_POST['finish']) && $_POST['finish'] == '')
        ) {
            //unset($_SESSION[$this->flowname]);
            $this->init();
        }

        $db = $this->db;
        $auth = $this->auth;

        $cntincludes = count($this->includes);
        if ($cntincludes == 0) {
            return false;
        } // in case no includes has previously been setup
        //	if($cntincludes == 1) { $included = 0;}
        else {
            $included = $this->current() % ($cntincludes);
        }

        ob_start();
        include($this->includes[$included]); // cyclic search

        $this->clearPosted();

        $tmp = ob_get_contents();

        $html = $tmp;
        $html = str_replace("\'", "'", $html); // don't escape quotes i.e if \' => needed '
        $html = fixEncoding($html);

        ob_end_clean();
        return $html;
    }

    public function save()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION[$this->flowname] = serialize($this);
    }

    public function initButton()
    {
        if (isset($_POST) && isset($_POST['button'])) {
            unset($_POST['button']);
        }
    }

    /**
     * Navigate trough the page, detect a pressed button
     *
     * @return bool
     */
    public function navigate()
    {
        if ((isset($_POST['button']) && $_POST['button'] == 'screen') || (isset($_POST['screen']) && $_POST['screen'] == '')) {
            $this->initButton();

            if (isset($_POST['screen_pos'])) {
                $next = $_POST['screen_pos'];
                $this->go_to($next);
                echo $this->__toString();
                return true;
            }


        }


        if ((isset($_POST['button']) && $_POST['button'] == 'next') || (isset($_POST['next']) && $_POST['next'] == '')) {
            $this->initButton();
            $this->next();
            echo $this->__toString();
            return true;
        } elseif ((isset($_POST['button']) && $_POST['button'] == 'prev') || (isset($_POST['prev']) && $_POST['prev'] == '')) {
            $this->initButton();
            $this->prev();
            echo $this->__toString();
            return true;
        } elseif ((isset($_POST['button']) && $_POST['button'] == 'refresh') || (isset($_POST['refresh']) && $_POST['refresh'] == '')) {
            $this->initButton();
            unset($_POST);
            $this->current();
            echo $this->__toString();
            return true;
        } elseif ((isset($_POST['button']) && $_POST['button'] == 'finish') || (isset($_POST['finish']) && $_POST['finish'] == '')) {
            unset($_SESSION[$this->flowname]);
            $this->initButton();
            $this->init();
            echo $this->__toString();
        }

        return false;
    }
}

?>