<?php 
/**
 * 	Class Tree_Container_Localizations v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Tree_Container_Localizations extends Tree 
{
	public $mapobjects;
	
	
	public function __construct()
	{
		$this->mapobjects = array('INST'=>'Institute_Object',
								  'BOX'=>'Box_Object',
								  'MIC'=>'Mic_Object',
								   'ROOT'=>'Root_Object',
								   'FR'=>'Fr_Object',
								   'RANK'=>'Rank_Object'); 
	}
	
	public function treeMethod( $current)
	{
		if(count($current)== 0)
		{
			return Tree::treeMethod($current);
		}
		if(isset($current['NAME'])==false || isset($current['SEQNO'])== false)
		{
			$this->isError = true;$this->errormessage = "Not all variables defined"; return false;
		}
		
		if(isset($current['CONTAINER_TYPE'])==true )
		{
			$container_type = $current['CONTAINER_TYPE'];
			if(array_key_exists($container_type,$this->mapobjects)==true)
			{
				$className = $this->mapobjects[$container_type];
			}
			else 
			{
				$this->isError = true;$this->errormessage = "Object Not Mapped";return false;
			}
		}
		else 
		{
				$this->isError = true;$this->errormessage = "Current Container Type not found";return false;
			
		}
		
		$current = array('LEVEL'=>$current['LEVEL'],
						 'CLASSNAME'=>$className,
						  'VALUE' => $current['NAME'],
						  'PK'=>array('SEQNO'=>$current['SEQNO']));
		
		return Tree::treeMethod($current);
	}
	
	
}
/**
 * 	Class Tree v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Tree
{
	public $isError;
	
	public $errormessage;
	
	public $last = null;

	public function __construct() {}

	public function treeMethod( $current ) 
	{
		if( isset( $current['LEVEL'] ) ) 
		{
			//structural elements
			$structure = $this->structureMethod( $current['LEVEL'] );
		}
		else
		{
		return  $this->structureMethod( null );
		}
		// add the item itself
		if(isset($current['CLASSNAME'] )==true && class_exists($current['CLASSNAME']) ==true )
		{
			$item_r = new $current['CLASSNAME']($current['VALUE'],$current['PK']);
			
			if($item_r instanceof Tree_Element)
			{
			$item = $item_r->__toString();
			}
			else 
			{
			$this->isError = true;$this->errormessage ="Item not Recognized as instance of Tree Elements";return false;
			}
		}
		else 
		{
			$item = "";
		}
		return $structure.$item;
	}

	private function structureMethod( $current )
	{
		$structure = "";
		if( is_null( $current ) ) 
		{
			return str_repeat( "</li></ul>", $this->last );
		}
	
		if( is_null( $this->last ) ) 
		{
			//add the opening structure in the case of
			//the first row
			$structure .= '<ul class="init">'; 
		} 
		elseif( $this->last < $current ) 
		{
		//add the structure to start new branches
			$structure .= '<ul>';
		}
		elseif( $this->last > $current) 
		{
		//add the structure to close branches equal to the 
		//difference between the previous and current levels
			$structure .= '</li>'.str_repeat( "</ul></li>", $this->last - $current );
		}
		 else 
		{
			$structure .= '</li>';
		}
	
		// add the item structure
		$structure .= "<li class='drag'>";
	
		// update $this->last so the next row knows whether this row is
		// really its parent
		$this->last = $current;
	
		return $structure;
}
	
	
}
/**
 * 	Class Tree_Element v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
Class Tree_Element 
{
	protected $cssclass;
	
	protected $name;
	
	protected $pk;
	
	protected $image=false;
	
	protected $value;
	
	public function __construct($value,$pk)
	{
		$this->value = $value;
		
		$this->pk = json_encode($pk);
	}
	
	public function __toString()
	{
		$server = $_SERVER['PHP_SELF'];
		return "<img class='item expander' alt='expand' src='img/Container_Localizations/expander.gif'/>".
								 "<img class='item collapser' alt='expand' src='img/Container_Localizations/collapser.gif' style='display:none;'/>".
								(is_bool($this->image)==true?"":"<img  alt='container' src='img/Container_Localizations/$this->image'/>").
								"<a pk='$this->pk' title='$this->pk' href=''>$this->value</a>\n";
	}
}
/**
 * 	Class Institute_Object v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Institute_Object extends Tree_Element 
{
	public function __construct($value,$pk)
	{
		$this->value = $value;
		
		$this->image = "institute.gif";
		
		$this->name = "Institute";

		$this->cssclass = "institute_class";
		Tree_Element::__construct($value,$pk);
	}
	

}
/**
 * 	Class Box_Object v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Box_Object extends Tree_Element 
{
	public function __construct($value,$pk)

	{
		$this->image = "container.png";
		$this->value = $value;
		$this->name = "Box";
		$this->cssclass = "box_class";
		Tree_Element::__construct($value,$pk);
	}
	
	
}
/**
 * 	Class Mic_Object v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Mic_Object extends Tree_Element 
{
	public function __construct($value,$pk)

	{
		$this->image = "microslides.jpg";
		$this->value = $value;
		$this->name = "Mic";
		$this->cssclass = "box_class";
		Tree_Element::__construct($value,$pk);
	}
	
	
}
/**
 * 	Class Root_Object v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Root_Object extends Tree_Element 
{
	public function __construct($value,$pk)

	{
		$this->image = "dolbutt.gif";
		$this->value = $value;
		$this->name = "Root";
		$this->cssclass = "box_class";
		Tree_Element::__construct($value,$pk);
	}
	
	
}
/**
 * 	Class Rank_Object v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Rank_Object extends Tree_Element 
{
	public function __construct($value,$pk)

	{
		$this->image = "cabinet.jpg";
		$this->value = $value;
		$this->name = "Rank";
		$this->cssclass = "box_class";
		Tree_Element::__construct($value,$pk);
	}
	
	
}
/**
 * 	Class Fr_Object v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Fr_Object extends Tree_Element 
{
	public function __construct($value,$pk)

	{
		$this->image = "fridge.gif";
		$this->value = $value;
		$this->name = "Fridge";
		$this->cssclass = "box_class";
		Tree_Element::__construct($value,$pk);
	}
	
	
}


?>