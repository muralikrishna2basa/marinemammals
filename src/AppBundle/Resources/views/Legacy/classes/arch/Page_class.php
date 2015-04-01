<?php

/**
 *    Class Page v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 */
class Page
{
    /**
     * Page title
     *
     * @var string
     */
    private $title = "Default Page";

    /**
     * Array of html links
     * array(<link rel="stylesheet" type="text/css" href="tab_output.css" ></link>)
     * @var array
     */
    protected $heads = array();

    /**
     * array of html blocks constructing the body
     *
     * @var array
     */
    protected $bodies = array();


    public function __construct($title = false)
    {
        if (is_string($title) == true) {
            $this->title = $title;
        }
        $this->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/Layout/Page.css" />'));
    }

    /**
     * Method to add html block elements to the header( i.e required scripts(javascript, css))
     *
     * @param array $heads
     */
    public function addHead(array $heads)
    {

        foreach ($heads as $head) {
            if (in_array($head, $this->heads) != true) {
                $this->heads[] = $head;
            }
        }
    }

    /**
     * The class delete the header corresponding to the element specified
     * if nothing is supplied, then it deletes all existing javascript files
     * @param string $elem
     */
    public function cleanHead($elem = '.js')
    {
        foreach ($this->heads as $key => $header) {
            if (substr_count($header, $elem) != 0) {
                unset($this->heads[$key]);
            }
        }

    }

    public function addBody(array $bodies)
    {
        foreach ($bodies as $body) {
            if (is_string($body) == true) {
                $this->bodies[] = $body;
            }
        }
    }

    /*Access-Control-Allow-Origin*/
    public function __toString()
    {
        $heads = implode('\n', $this->heads);

        $body = implode('\n', $this->bodies);

        header("Content-Security-Policy: script-src 'self' 'unsafe-inline'");

        $page = <<<EOD
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv="Content-Security-Policy" content="script-src 'self' 'unsafe-inline'" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /> 
<title> $this->title </title>       
$heads
</head>    	
<body>
<div id="Layout_container">
	<div>
		$body
    </div>	
</div>    	
</body>
</html>
EOD;

        return stripcslashes($page); // escape all backslash caracters ( recognise \n )

    }
}