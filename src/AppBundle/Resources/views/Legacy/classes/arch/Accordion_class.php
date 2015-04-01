<?php
class Accordion
{
	protected $lists;
	
	protected $elements = array();
	
	protected $title = 'default_accordion';
	
	protected $classes = array();
	
	protected $styles = array();
	
	protected $callback_elements = array();
	
	protected $callback = array();
	
	public $isError= false;
	
	public $errormessage;
	
	public function __construct($title = false)
	{
		if($title != false&& is_string($title) && strlen($title)>0){ $this->title = $title;}
	}
	
	public function addCallback($function,$object = false)
	{
		if($object != false)
		{
			if(method_exists($object,$function))
			{
				$this->callback[$object] = $function;
				return true;
			}
			else 
			{	
				$this->isError = true;
				$this->errormessage= "Callback failed, method not recognized";
				return false;
			}	
		}
		elseif(function_exists($function))
		{
			$this->callback[] = $function;
			return true;
		}
		else 
		{
			$this->isError = true;
			$this->errormessage= "Callback failed, function not recognized";
			return false;
		}		
	}
	
	public function addCallbackElements($function,$object = false)
	{
		if($object != false)
		{
			if(method_exists($object,$function))
			{
				$i = count($this->callback_elements);
				$this->callback_elements["method$i"] = array($function=>$object);
				return true;
			}
			else 
			{	
				$this->isError = true;
				$this->errormessage= "Callback failed, method not recognized";
				return false;
			}	
		}
		elseif(function_exists($function))
		{
			$this->callback_elements[] = $function;
			return true;
		}
		else 
		{
			$this->isError = true;
			$this->errormessage= "Callback failed, function not recognized";
			return false;
		}
	}
	public function addClass($classname)
	{
		if(is_string($classname) && strlen($classname)>0 && !in_array($classname,$this->classes))
		{
			$this->classes[] = $classname;
		}
	}
	
	public function addStyle($element)
	{
		if(is_string($element) && strlen($element)>0 && !in_array($element,$this->styles))
		{
			$this->styles[] = $element;
		}
	}
	public function addList($title,$elements)
	{
		foreach($elements as $href => $name)
		{
			$element = $this->addListElement($title,$href,$name);
			
			if($element == false)
			{
				$this->isError = true;
				$this->errormessage = "element $href belonging to list : $title not successfully added";
				return false;
			}
			
		}
	}
	
	public function addListElement($title,$href,$name)
	{
		// input check
		if(!is_string($title) || strlen($title)<=0){ return false;}
		
		if(!is_string($href) || strlen($href)<=0){ return false;}
		
		if(!is_string($name) || strlen($name)<=0){ return false;}
		
		
		if( !array_key_exists($title,$this->elements) ) { $this->elements[$title] = array();}
		
		if(!array_key_exists($href,$this->elements[$title]))
		{
				$this->elements[$title][$href] = new Li_Element($href,$name);
				
				return $this->elements[$title][$href];
		}
		else 
		{
			return $this->elements[$title][$href];
		}
	
		
		
		
	}
	

	
	public function __toString()
	{
		
		$classes = implode(' ',$this->classes);
		
		if(is_array($this->styles)){$styles = implode(';',$this->styles);}else{$styles ='';}
		
		$tmpString = "<div style='$styles' class='$classes' title='$this->title'>\n";

		// Global callbacks 
		foreach($this->callback as $key => $callback)
		{
			if(is_numeric($key))
			{
				call_user_func($callback,$this);
			}
			else 
			{
				call_user_func(array($key,$callback),$this);
			}			
		}
		// End Global callbacks
		foreach($this->elements as $title => $element)
		{
			$tmpString .= "<div>";
			$tmpString .="<h3>$title</h3>\n";
			$tmpString .= "<ul class = '$classes'>\n";
			
			foreach($element as $href => $li_item)
			{
				if($li_item instanceof Li_Element )
				{
				
					foreach($this->callback_elements as $key => $callback_element)
					{
						if(is_numeric($key))
						{
							call_user_func($callback_element,$li_item);
						}
						else 
						{
							$object = current($callback_element);
							$method = key($callback_element);
							call_user_func(array($object,$method),$li_item);
						}
					}	
					
				$tmpString .= $li_item->__toString()."\n";
				}
			}
		$tmpString .=	"</ul></div>";
		
		}
		
		$tmpString .= "</div>\n";
		
		
		
		return stripcslashes($tmpString);
	}
	
	
}

class Li_Element
{
	public $href;

	public $name;
	
	public $listyles = array();
	
	public $astyles = array();
	
	protected $liclasses = array();
	
	protected $aclasses = array();
	
	
	public function __construct($href = false,$name = false)
	{
		if($href != false&& is_string($href) && strlen($href)>0){ $this->href = $href;}

		if($name != false&& is_string($name) && strlen($name)>0){ $this->name = $name;}

	}
	public function addStyle_li($element)
	{
		if(is_string($element) && strlen($element)>0 && !in_array($element,$this->listyles))
		{
			$this->listyles[] = $element;
		}
	}
	
	public function addStyle_a($classname)
	{		
		if(is_string($element) && strlen($element)>0 && !in_array($element,$this->astyles))
		{
			$this->astyles[] = $element;
		}
		
	}
	
	public function addClass_a($classname)
	{
		if(is_string($classname) && strlen($classname)>0 && !in_array($classname,$this->aclasses))
		{
			$this->aclasses[] = $classname;
		}
	}
	public function addClass_li($classname)
	{
		if(is_string($classname) && strlen($classname)>0 && !in_array($classname,$this->liclasses))
		{
			$this->liclasses[] = $classname;
		}
	}	
	public function __toString()
	{
		$aclasses = implode(' ',$this->aclasses);
		
		$liclasses = implode(' ',$this->liclasses);
		
		if(is_array($this->astyles)){$astyles = "style='".implode(';',$this->astyles)."'";}else{$astyles = "";}
		
		if(is_array($this->listyles)){$listyles = "style='".implode(';',$this->listyles)."'";}else{$listyles = "";}
		
		return stripcslashes("<li class='$liclasses' $listyles><a class='$aclasses' href ='$this->href' $astyles>$this->name</a></li>\n");
	}
	
	
}


?>