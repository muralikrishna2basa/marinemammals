<?php
require_once('record_details_class.php');
/**
 *   Record class 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:29/04/2010 
 */
class Record 
{
	/**
	 * List of Record Elements
	 *
	 * @var array
	 */
	protected $elements = array();
	
	/**
	 * Abstract link between the class & a defined identifier
	 *
	 * @var array
	 */
	protected $eltypes = array();
	
	/**
	 * Element used to go to the next line 
	 *
	 * @var unknown_type
	 */
	public $endline = "\n";
	
	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		$this->eltypes = array('pic'=>'Picture_RE',
							   'text'=>'Text_RE',
							   'email'=>'Email_RE',
							   'element'=>'Element_RE'
							  );
	}
	
	/**
	 * Get The Elements
	 *
	 * @return array
	 */
	public function getElements()
	{
		return $this->elements;
	}
	
	/**
	 * Magic Method, Return the Html representation of the record
	 *
	 */
	public function __toString()
	{

		
		foreach($this->elements as $element)
		{
			if($element instanceof Record_Element )
			{
				echo $element;
			}
		}
	}
		
	/**
	 * Set Datas by Id
	 *
	 * @param array $data
	 */
	public function setDatasById($datas)
	{
		if(!is_array($datas) || !isset($datas['id'])){ return false;}
		
		foreach($this->elements as $element)
		{
			if($element->getId() == false) { continue;}
			
			if($element->getId() == $datas['id'])
			{
				$element->setDatas($datas);
			}	
		}	
	}
	/**
	 * Add Element to the list of elements 
	 *
	 * @param string $el
	 * @param array $datas
	 * @return element or false
	 */
	public function addElement($el,$datas = false)
	{
			if(array_key_exists($el,$this->eltypes) )
			{
					
				    $element = new $this->eltypes[$el]();
					
					if($element instanceof Record_Element )
					{
						if(is_array($datas))
						{
							if(isset($datas['name']))
							{
								$element->setName($datas['name']);	
								unset($datas['name']);
							}
							if(isset($datas['id']))
							{
								$element->setId($datas['id']);
							}
							$element->setDatas($datas);
						}
						$this->elements[] = $element;
						
						return $element;
					}
					else 
					{
						return false;
					}
			}
			else 
			{
				return false;
			}
	}
}
/**
 *   Record Element class 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:29/04/2010 
 */
class Record_Element
{
	/**
	 * Array of data's needed for the element to be displayed right
	 *
	 * @var array
	 */
	protected $datas = array();
	
	/**
	 * Type of Record Element
	 *
	 * @var string
	 */
	protected $type;
	
	/**
	 * Name of Record Element
	 *
	 * @var string or false
	 */
	protected $name = false;
	
	/**
	 * Id of Record Element
	 *
	 * @var string or false
	 */
	protected $id = false;
	
	/**
	 * End Tag of the record Element 
	 * To be used in the html output representation
	 * 
	 * @var string
	 */
	protected $closetag;
	
	/**
	 * Constructor
	 *
	 * @param string $type
	 */
	public function __construct($type)
	{
		if(is_string($type) && strlen($type) > 0 )
		{
			$this->type = $type;
		}
	}
	/**
	 * Defined by inheritance
	 *
	 */
	public function __toString()
	{

	}
	
	/**
	 * Get Close Tag
	 *
	 * @return string
	 */
	public function getCloseTag()
	{
		return $this->closetag;
	}
	/**
	 * Given A list of keyed attributes 
	 * It returns a string representation of the list
	 *
	 * @param array,string  $attr
	 * @return string
	 */
	public function getAttr($attr = false)
	{
		if($attr == false) 
		{
			$attr = $this->datas;
		}
		
		if(count($attr) == 0){ return "";}
		
		$out = "";
		foreach($attr as $key => $data)
		{
			if(is_string($data) && strlen($data) > 0)
			{
			  $out .= " $key = '$data' ";
			}
			elseif($data instanceof Record_Element )
			{
				
				$out .= " $key = '".$data->__toString()."' ";
			}
			elseif(is_array($data))
			{
				$out .=" $key = '".implode(' ',$data)."' ";
			}
		}
		return $out;
	}
	/**
	 * Return element Type
	 *
	 * @return false or string
	 */
	public function getType()
	{
		return $this->type;	
	}
	/**
	 * Return element Name
	 *
	 * @return false or string
	 */
	public function getName()
	{
		return $this->name;
	}
	/**
	 * Return element Id
	 *
	 * @return false or string
	 */
	public function getId()
	{
		return $this->id;
	}
	/**
	 * Set Element Id 
	 *
	 * @param string $id
	 * @return bool
	 */
	public function setId($id)
	{
		if(is_string($id) && strlen($id) > 0 )
		{
			$this->id = $id;
			return true;
		}
		return false;
	}
	/**
	 * Set Element Name
	 *
	 * @param string $name
	 * @return bool
	 */
	public function setName($name)
	{
		if(is_string($name) && strlen($name) > 0 )
		{
			$this->name = $name;
			return true;
		}
		return false;
	}
	/**
	 * Set Data's based on the defined array key data's ( inheritance)
	 *
	 * the value of the array might be string or belonging to record_element
	 * 
	 * @param array $in
	 */
	public function setDatas(Array $in)
	{
		foreach($this->datas as $key => $data)
		{
			if(array_key_exists($key,$in))
			{
				if(is_string($in[$key]) )
				{
				$this->datas[$key][] = $in[$key];
				}
				elseif(is_array($in[$key])) 
				{
				 if(is_array($this->datas[$key]))
				 {	
				 	$this->datas[$key] = array_merge($this->datas[$key],$in[$key]);
				 }
				 elseif(is_string($this->datas[$key]) && strlen($this->datas[$key])>0)
				 {
				 	$this->datas[$key] = array_push($in[$key],$this->datas[$key]);
				 }
				 else 
				 {
				 	$this->datas[$key] = $in[$key];
				 }	
				
				}
			}
		}

	}
}
/**
 * 	 Class Records
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:29/04/2010 
 */
class Records
{
	/**
	 * Array of Record Elements
	 *
	 * @var array
	 */
	protected $records; 
	
	/**
	 * Define the end line element 	
	 * @var string
	 */
	protected $endline = "\n";
	
	/**
	 * Array of properties tight to the records class
	 *
	 * @var array
	 */
	protected $datas;
	
	/**
	 * List of element names (used for the table renderer for example)
	 *
	 * @var unknown_type
	 */
	protected $elnames;
	
	protected $panels = array('leftpanel'=>false,'rightpanel'=>false);
	
	protected $panelElements = array('leftpanel'=>false,'rightpanel'=>false);
	
	public function setDatas(Array $datas)
	{
		$this->datas = array_merge($this->datas,$datas);
	}
	
	/**
	 * Enable selected panel, if operation successful return true; else return false 
	 *
	 * @param panel type $panel
	 * @return bool
	 */
	public function enablePanel($panel)
	{
		if(!is_string($panel) || !strlen($panel)>0) { return false;}
			
		switch($panel)
		{
			case 'leftpanel':$this->panels['leftpanel'] = true;return true;
			case 'rightpanel':$this->panels['rightpanel'] = true;return true;
		}
		
	}
	
	public function disablePanel($panel)
	{
		if(!is_string($panel) || !strlen($panel)>0) { return false;}
			
		switch($panel)
		{
			case 'leftpanel':$this->panels['leftpanel'] = false;return true;
			case 'rightpanel':$this->panels['rightpanel'] = false;return true;
		}
	}
	
	public function getPanel($panel)
	{
		if(!is_string($panel) || !strlen($panel)>0) { return false;}
		
		switch($panel)
		{
			case 'leftpanel':return $this->panelElements['leftpanel'];
			case 'rightpanel':return $this->panelElements['rightpanel'];
		}
	}
	
	public function setElnames(Array $elnames)
	{
		$this->elnames = $elnames;
	}
	/**
	 * Add Record to the list of record elements
	 *
	 * @return unknown
	 */
	public function addRecord()
	{
		
		$record = new Record();
		
		$this->records[] = $record;
		
		return $record;
	}
	/**
	 * To be filled by inheritance
	 *
	 */
	public function __toString()
	{
		
	}
	
	/**
	 * Constructor
	 *
	 * @param array $datas
	 */
	public function __construct($datas = false)
	{
		if(is_array($datas) && count($datas) > 0 )
		{
			$this->datas = $datas;
		}
		$panelleft = new Panel_Element();
		
		$panelleft->setDatas(array('panelposition'=>'left','class'=>'panel'));
		
		$panelright = new Panel_Element();
		
		$panelright->setDatas(array('panelposition'=>'right','class'=>'panel'));
		
		$this->panelElements['leftpanel'] = $panelleft;
		
		$this->panelElements['rightpanel']  = $panelright;
		
	}
	
	
}
/**
 * 	 Class RecordsUlRenderer
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:29/04/2010 
 */
class RecordsUlRenderer extends Records 
{

	/**
	 * Return a Html Representation of the body Records
	 *
	 * @return string
	 */
	protected function get_Body_ToHTML()
	{
		$pic_element = false;
		
		$tbody = new Element_RE('div');
		
		$tbody->setDatas(array('class'=>'list'));
		
		$tbl = $tbody->__toString().$this->endline;
		
		$oddeven = 0;
		
		$oddevenclass = 'even';
		
		$ul = new Element_RE('ul');
		
		$tbl .= $ul->__toString().$this->endline;
		
		if(is_array($this->records))
		{ 
		foreach($this->records as $record)
		{
			// in case of zero elements
		
			if(count($record->getElements()) == 0 ) 
			{ 
				continue; // do nothing
			}
	
			
			if(($oddeven++)%2 == 0){ $oddevenclass = 'odd';} else { $oddevenclass = 'even';}
		
			$li = new Element_RE('li');
			
			$li->setDatas(array('class'=>array($oddevenclass,'record')));
		
			$tbl .= $li->__toString().$this->endline;
			
			$ul_record = new Element_RE('ul');
			
			$tbl .= $ul_record->__toString().$this->endline;
			
			foreach($record->getElements() as $element)
			{
				/**
				 *  If a picture element is set, then remember it
				 */
				if($element->getType() == 'picture')
				{
					$pic_element[] = $element;
					continue;
				}	
				

				if($element->getName() != false)
				{
					$li  = new Element_RE('li');
					$li->setDatas(array('class'=>'name'));
					$tbl .= $li->__toString().$this->endline;
					$tbl .= $element->getName().$this->endline.
			        $li->getCloseTag().$this->endline;
			
			
				}
				
				$li  = new Element_RE('li');
			
				$tbl .= $li->__toString().$this->endline;
			
				$tbl .= $element->__toString().$this->endline.
			        	$li->getCloseTag().$this->endline;
				       
			
			}
			
			$tbl .=  $ul_record->getCloseTag().$this->endline;
			$tbl .=  $li->getCloseTag().$this->endline;
			
		}
		}
		$tbl .= $ul->getCloseTag().$this->endline.$tbody->getCloseTag().$this->endline;
		
		$init = true;
		
		$div_pic = new Element_RE('div');
			
		$div_pic->setDatas(array('class'=>'picture'));
			
		$tbl .= $div_pic->__toString().$this->endline;
		if(is_array($pic_element))
		{	
		foreach($pic_element as $pic)
		{
			if($pic instanceof Record_Element )
			{
			
				if($pic->getName() != false)
				{
					$name_el = new Text_RE();
					
					$name_el->setDatas(array('class'=>'textelement','text'=>$pic->getName()));
					
					$tbl .= $name_el->__toString().$this->endline;
				}
			
				if($init)
				{
						 $init = false;
				}
				else 
				{
					$pic->setDatas(array('style'=>'display:none;'));
				}
				
			 	$tbl .= $pic->__toString().$pic->getCloseTag().$this->endline;
			
			
		
			}
		}
		}
		$tbl .= $div_pic->getCloseTag().$this->endline;
		
		return $tbl;
	}
	public function getLeftPanel_TOHTML()
	{
		if(!$this->panels['leftpanel']){ return "";}

		return $this->panelElements['leftpanel']->__toString();
		
	}
	
	public function getRightPanel_TOHTML()
	{
		if(!$this->panels['rightpanel']) { return "";}

		return $this->panelElements['rightpanel']->__toString();
		
		
	}
	/**
	 * Return a Html Representation of the list of records
	 *
	 * @return unknown
	 */
	public function __toString()
	{
		$div = new Element_RE('div');
		
		$div->setDatas($this->datas);
		
		$tbl = $div->__toString().$this->endline;
		
		$tbl .= $this->getLeftPanel_TOHTML();
		
		$tbl .= $this->getRightPanel_TOHTML();
		
		$tbl .= $this->get_Body_ToHTML();
		
		$tbl .= $div->getCloseTag().$this->endline;
		
		return $tbl;
	}
	
}
/**
 * 	 Class RecordsTableRenderer
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:29/04/2010 
 */
class RecordsTableRenderer extends Records 
{
	/**
	 * Array of Head Elements
	 *
	 * @var array
	 */
	protected $headElements;
	
	/**
	 * Array of footer Elements
	 *
	 * @var array
	 */
	protected $footerElements;
	


/**
 * Get an Html representation of the Header
 *
 * @return string
 */
	protected function get_Head_ToHTML()
	{
		// in case nothing to display
		if(count($this->headElements) == 0) { return "";}
		
		$thead = new Element_RE('thead');
		
		$tbl  = $thead->__toString().$this->endline;
		
		
		
		foreach($this->headElements as $element)
		{
			$tbr = new Element_RE('tr');
			$tbl .= $tbr->__toString().$this->endline;
			
			$tbh  = new Element_RE('th');
			
			$tbl .= $tbh->__toString().$this->endline;
			
			$tbl .= $element->__toString().$this->endline.
			        $tbh->getCloseTag().$this->endline.$tbr->getCloseTag().$this->endline;
		}
		
		$tbl .= $thead->getCloseTag().$this->endline;
		
		return $tbl;
	}
/**
 * Get an Html representation of the footer
 *
 * @return string
 */
	protected function get_Foot_ToHTML()
	{
		// in case nothing to display
		if(count($this->footerElements) == 0) { return "";}
		
		$thead = new Element_RE('tfoot');
		
		$tbl  = $thead->__toString().$this->endline;
		
		foreach($this->footerElements as $element)
		{
			$tbr = new Element_RE('tr');
			$tbl .= $tbr->__toString().$this->endline;
			$tbd  = new Element_RE('td');
			
			$tbl .= $tbd->__toString().$this->endline;
			
			$tbl .= $element->__toString().$this->endline.
			        $tbd->getCloseTag().$this->endline.
			        $tbr->getCloseTag().$this->endline;
		}
		
		$tbl .= $thead->getCloseTag().$this->endline;
		
		return $tbl;		
	}
/**
 * Get an Html representation of the Body
 *
 * @return string
 */
	protected function get_Body_ToHTML()
	{
		$tbody = new Element_RE('tbody');
		
		$tbl = $tbody->__toString().$this->endline;
		
		$oddeven = 0;
		
		$oddevenclass = 'even';
		
		foreach($this->records as $record)
		{
		// in case of zero elements
		
			if(count($record->getElements()) == 0 ) 
			{ 
				return $tbl.$tbody->getCloseTag().$this->endline;
			}
		
			if(($oddeven++)%2 == 0){ $oddevenclass = 'odd';} else { $oddevenclass = 'even';}
		
			$tbr = new Element_RE('tr');
			
			$tbr->setDatas(array('class'=>$oddevenclass));
		
			$tbl .= $tbr->__toString().$this->endline;
			
			foreach($record->getElements() as $element)
			{
			
			
			$tbd  = new Element_RE('td');
			
			$tbl .= $tbd->__toString().$this->endline;
			
			$tbl .= $element->__toString().$this->endline.
			        $tbd->getCloseTag().$this->endline;
			       
			
			}
			
			$tbl .=  $tbr->getCloseTag().$this->endline;
			
		}
		
		$tbl .= $tbody->getCloseTag().$this->endline;
		
		return $tbl;
	}
	protected function setHeaderElements()
	{
		if(is_array($this->elnames))
		{
			foreach($this->elnames as $name)
			{
				if(is_string($name) && strlen($name)>0)
				{
				$headElement = new Text_RE();
				
				$headElement->setDatas(array('text'=>$name));
				
				$this->headElements[] = $headElement;
				}
			}
		}
	}
/**
 * Get an Html representation of the Table
 *
 * @return unknown
 */
	public function __toString()
	{
		$table = new Element_RE('table');
		
		$table->setDatas($this->datas);
		
		$tbl = $table->__toString().$this->endline;
		
		// 
		$this->setHeaderElements();
		
		
		$tbl .= $this->get_Head_ToHTML();
		
		$tbl .= $this->get_Body_ToHTML();
		
		$tbl .= $this->get_Foot_ToHTML();
		
		$tbl .= $table->getCloseTag().$this->endline;
		
		return $tbl;
	}
}
?>