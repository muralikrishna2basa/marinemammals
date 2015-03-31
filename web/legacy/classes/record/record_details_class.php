<?php
class Picture_RE extends Record_Element 
{
	public function __construct()
	{
		$this->datas = array('src'=>'',
							 'alt'=>'',
							 'class'=>'',
							 'title'=>'',
							 'name'=>'',
							 'id'=>'',
							 'style'=>'');
		
		parent::__construct('picture');
	}
	
	public function __toString()
	{
		$img = "<img ";
        
		$img .= $this->getAttr();
		
		return $img." />";
	}
}
class Text_RE extends Record_Element 
{
	public function __construct()
	{
		$this->datas = array('text'=>'',
		                     'class'=>'',
		                     'name'=>'',
		                     'id'=>'',
							 'style'=>'');
		
		parent::__construct('text');
	}
	public function __toString()
	{
		$datas = $this->datas;
		
		unset($datas['text']);
		
		if(is_string($this->datas['text']) && strlen($this->datas['text']) > 0)
		{
			return "<span ".$this->getAttr($datas).">".$this->datas['text']."</span>";
		}
		elseif($this->datas['text'] instanceof Record_Element )
		{
			return "<span ".$this->getAttr($datas).">".$this->datas['text']->__toString()."</span>";
		}
		elseif(is_array($this->datas['text']) && count($this->datas['text']) >0)
		{
			return "<span ".$this->getAttr($datas).">".implode('',$this->datas['text'])."</span>";
		}
	}
}
class Panel_Element extends Record_Element 
{
	public function __construct()
	{
		$this->datas = array('to_record'=>'',
							  'record_id'=>'',
							  'class'=>'',
							  'panelposition'=>'');
							  
		parent::__construct('Panel');					  
	}
	public function __toString()
	{
		$datas = $this->datas;
		
		$panelposition = "";
		
		switch(current($datas['panelposition']))
		{
			case 'left':$panelposition ='panelleft';break;
			case 'right':$panelposition = 'panelright';break;	
		}
		
		//$datas['class'][] = $panelposition;
		
		$inputattr = $this->getAttr(array('class'=>$datas['to_record'],
										  'name'=>'record_id',	
										  'value'=>$datas['record_id'],
										  'style'=>'display:none;'));
		
		
		$tmp = "<button class='".$panelposition."'><div ".$this->getAttr(array('class'=> $datas['class'])).">"."<input ".$inputattr."/></div></button>";
		
		return $tmp;
	}	
}

class Email_RE extends Record_Element 
{
	public function __construct()
	{
		$this->datas = array('mailto'=>'',
							 'class'=>'',
							 'text'=>'',
							 'name'=>'',
							 'id'=>'',
							 'style'=>'');

		parent::__construct('email');					  
	}
	public function __toString()
	{
		$datas = $this->datas;
		
		unset($datas['text']);
		
		if(is_string($this->datas['mailto'])&& strlen($this->datas['mailto']) > 0)
		{
			$mailto = $this->datas['mailto'];
		}
		elseif(is_array($this->datas['mailto']))
		{
			$mailto = implode('',$this->datas['mailto']);
		}
		unset($datas['mailto']);
		
		$datas['href'] = "mailto:$mailto";
		
		if(is_string($this->datas['text']) && strlen($this->datas['text']) > 0)
		{
			return "<a ".$this->getAttr($datas).">".$this->datas['text']."</a>";
		}
		elseif($this->datas['text'] instanceof Record_Element )
		{
			return "<a ".$this->getAttr($datas).">".$this->datas['text']->__toString()."</a>";
		}
		elseif(is_array($this->datas['text']) && count($this->datas['text']) >0)
		{
			return "<a ".$this->getAttr($datas).">".implode('',$this->datas['text'])."</a>";
		}
		elseif(is_string($this->datas['text']) && strlen($this->datas['text']) == 0)
		{
			return "<a ".$this->getAttr($datas)."></a>";
		}
	}
}

class Element_RE extends Record_Element 
{
	protected $element;
	
	public function __construct($element)
	{
		if(is_string($element) && strlen($element)>0) 
		{
			$this->element = $element;
		}
		
		$this->datas = array('class'=>'',
							 'align'=>'',
							 'title'=>'',
							 'text'=>'',
							 'id'=>'',
							 'style'=>'');
							 
		$this->closetag = "</$this->element>";					 
	}
	
	public function __toString()
	{
		$datas = $this->datas;
		
		unset($datas['text']);

		if(is_string($this->datas['text']) && strlen($this->datas['text']) > 0)
		{
			return "<$this->element".$this->getAttr($datas).">".$this->datas['text'];
		}
		elseif($this->datas['text'] instanceof Record_Element )
		{
			return "<$this->element".$this->getAttr($datas).">".$this->datas['text']->__toString();
		}
		
		return "<$this->element".$this->getAttr($datas).">".$this->datas['text'];
	}		
}

 
?>