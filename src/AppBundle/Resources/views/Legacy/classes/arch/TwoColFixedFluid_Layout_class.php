<?php
/**
 * 	Class Twocolfixedfluid v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
require_once(Classes.'arch/Page_class.php');
class Twocolfixedfluid extends Page 
{
	
	 private $hasnavigation = true;
	 /**
	  * array of html blocks constructing the navigation 
	  *
	  * @var array
	  */
	 protected $navigations = array();
	 /**
	  * array of html blocks constructing the header
	  *
	  * @var array
	  */
	 private $headers = array();
	 
	 /**
	  * array of html blocks constructing the footer 
	  *
	  * @var array
	  */
	 private $footers = array();
	 
	 /**
	  * array of html blocks constructing the content 
	  *
	  * @var array
	  */
	 protected $contents = array();
	 /**
	  * return true if the Layout is started 
	  * handy to only display once the layout -- independtly of possible wrong manipulations 
	  * @var bool
	  */
	 protected $isstarted = false;

	 public function __construct($layout_name = false) 
	 {
 	 	
		if($layout_name == false || is_string($layout_name)==false)
		{
			$layout_name = "Layout v1.0.0";
		}
		
		Page::__construct($layout_name); 
	
		/* set the Layout style sheet */
    	
    	
    	$this->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/Layout/TwoColFixedFluid.css" />'));
	}
	

	
	/**
     * The classes and the webpages might add elements to the layout 
     * Each footer element is stored as an  item 
     *
     * @param array $navigation
     */
     public function addNavigation($navigation){$this->navigations[] = $navigation;return count($this->navigations)-1;}
    
	/**
     * The classes and the webpages might add elements to the layout 
     * Each footer element is stored as an  item 
     *
     * @param array $footer
     */
     public function addFooter($footer){$this->footers[] = $footer;return count($this->footers)-1;}
    /**
     * The classes and the webpages might add elements to the layout 
     * Each footer element is stored as an  item 
     *
     * @param array $Content
     */
     public function addContent($content){$this->contents[] = $content;return count($this->contents)-1;}
    
	/**
     * The classes and the webpages might add elements to the layout 
     * Each header element is stored as an  item 
     *
     * @param array $header
     */
     public function addHeader($header){$this->headers[] = $header;return count($this->headers)-1;}
     
     public function setNavigation($mark) { if(isset($mark) && is_bool($mark)==true ){ $this->hasnavigation = $mark;}}
     
     protected function buildNavigation()
     {
     	if($this->hasnavigation == true) 
     	{
     		$navigation = "<div id=\'Layout_navigation\'>\n";
     		if(isset($this->navigations) &&count($this->navigations >0 ))
     		{ 
     			$navigation .=implode('\n',$this->navigations);
     		}
     		$navigation .="</div>";
     	}
     	else 
     	{ 
     		$navigation = "";
     	}
     	
     	return $navigation;
     }
     
     /**
      * The footer is build, i.e all the elements are loaded in the structure and the structure is returned to the 
      * calling script 
      *
      * @return unknown
      */
     protected function buildFooter() 
     { 
        $footer  = "<div id = 'Layout_footer'>\n";
 		if(isset($this->footers) && count($this->footers)>0 )
 		{ 
 			$footer .= implode('\n',$this->footers);
 		}
    	$footer .= "</div>";
        return $footer;
     }
    
	 /**
      * The header is build, i.e all the elements are loaded in the structure and the structure is returned to the 
      * calling script 
      *
      * @return unknown
      */
     protected function buildHeader() 
     {
    	$header  = "<div id ='Layout_header'>\n";
    	if(isset($this->headers) && count($this->headers) > 0) 
    	{
    		$header .= implode('\n',$this->headers);
    	}
    	$header .= "</div>";
    	return $header; 
     }
     
     /**
      * The Content is build, i.e all the elements are loaded in the structure and the structure is returned to the 
      * calling script 
      *
      * @return unknown
      */
     protected function buildContent()
     {
    	$content = "<div id='Layout_content'>\n";
    	if(isset($this->contents) && count($this->contents)>0) 
    	{
    		$content .=implode('\n',$this->contents);
    	}
    	$content .="</div>"; 
    	return $content;
     }
     
  	/**
  	 * Return the Html Layout
  	 *
  	 */
     public function __toString()
     {
     	$content = $this->buildContent();
     	
     	$header = $this->buildHeader();
     	
     	$navigation = $this->buildNavigation();
     	
     	$wrapper = "<div id='Layout_wrapper'>\n$navigation\n$content\n</div>";
     	
     	$footer = $this->buildFooter();
     	
     	$this->addBody(array($header,$wrapper,$footer));
     	
     	return Page::__toString();
     }
}
?>