<?php
require_once(Classes.'record/record_class.php');

class Db_records 
{
	protected $db_records = array();
	
	protected $db;
	
	private $current;
	
	private $nbrecords;
	
	public function __construct(Oracle $db)
	{
		$this->db = $db;
		
		$this->current = 0;
		
		$this->nbrecords = 0;
	}
	
	public function add($recordclass,$id)
	{
		    if(class_exists($recordclass))
		    {
			$this->db_records[] = array($id=>$recordclass);

			$this->nbrecords += 1;	
		    }
	}
	public function setCurrentId($id)
	{
		if(!is_string($id) || !strlen($id)>0 ) { return false;}
		foreach($this->db_records as $key => $record)
		{
			if(key($record) == $id){ $this->current = $key;return true;}
		}
		return false;
	}
	public function __toString()
	{
		$current_record = $this->db_records[$this->current%$this->nbrecords];
		
	    if($this->nbrecords == 0)
	    {
			return "";
	    }
		elseif($this->nbrecords == 1)
		{
			$recordclass = current($current_record);
			
			$recordelement = new $recordclass(key($current_record));
			
			return $recordelement->__toString(); // cyclic search
	    }
	    else 
	    {
	    	$recordclass = current($current_record);
			
			$recordelement = new $recordclass($this->db,key($current_record));
	    	
	    	$renderer = $recordelement->getRenderer();
	    	
	    	if($this->current == 0)
	    	{
	    		
	    		$renderer->enablePanel('rightpanel');
				
				$rightrecord = $this->db_records[($this->current +1)%$this->nbrecords];
				
				$renderer->getPanel('rightpanel')->setDatas(array('to_record'=>current($rightrecord),'record_id'=>(string) key($rightrecord)));
				
	    	}
	    	elseif($this->current == $this->nbrecords -1)
	    	{
				
	    		$renderer->enablePanel('leftpanel');
				
				$lefttrecord = $this->db_records[abs($this->current -1)];
				
				$renderer->getPanel('leftpanel')->setDatas(array('to_record'=>current($lefttrecord),'record_id'=>(string) key($lefttrecord)));
	    		
	    	}
	    	else 
	    	{
	    		$renderer->enablePanel('rightpanel');
				
				$renderer->enablePanel('leftpanel');
				
				$lefttrecord = $this->db_records[abs($this->current -1)];
				
				$rightrecord = $this->db_records[($this->current +1)%$this->nbrecords];
				
				$renderer->getPanel('leftpanel')->setDatas(array('to_record'=>current($lefttrecord),'record_id'=>(string) key($lefttrecord)));
				
				$renderer->getPanel('rightpanel')->setDatas(array('to_record'=>current($rightrecord),'record_id'=>(string) key($rightrecord)));

	    	}
	    	return $recordelement->__toString(); 
	    }
	    	
	}
}
class Db_record 
{
	protected $db;
	/**
	 * Contains renderer
	 *
	 * @var unknown_type
	 */
	protected $db_record;
	
	protected $elements;
	
	protected $eltypes;
	
	protected $id;
	
	private $renderer;
	
	protected $name;
	
	public function __construct(Oracle $db,$name,$renderer = false)
	{
		$this->db = $db;
		
		$this->name = $name;
		
		$this->renderer = array('ul'=>'RecordsUlRenderer',
		                        'table'=>'RecordsTableRenderer');
		
		if($renderer == false || !array_key_exists($renderer,$this->renderer))
		{
			$this->db_record = new RecordsUlRenderer(array('class'=>'record_item','name'=>$name));
		}
		else
		{
			$new_renderer = $this->renderer[$renderer];
			
			$this->db_record = new $new_renderer(array('class'=>'record_item','name'=>$name));
		}
		
		$this->getDetails($this->id);
		
		if(is_array($this->eltypes))
		{
			$this->db_record->setElnames(array_keys($this->eltypes)); 
		}
	}
	
	public function getId()
	{
		return $this->id;
	}
	/**
	 * Set the renderer to be used
	 *
	 * @param string $renderer
	 * @return false or renderer
	 */
	public function setRenderer($renderer = false)
	{
		if($renderer != false && array_key_exists($renderer,$this->renderer))
		{
			$new_renderer = $this->renderer[$renderer];
			
			$this->db_record = new $new_renderer(array('class'=>'record_item','name'=>$this->name));
			
		    if(is_array($this->eltypes))
		    {
				$this->db_record->setElnames(array_keys($this->eltypes)); 
			}
			
			return $this->db_record;
		}
		return false;
	}
	public function getName()
	{
		return $this->name;
	}	
	public function getRenderer()
	{
		if($this->db_record instanceof Records )
		{
			return $this->db_record;
		}
		else 
		{
			return false;
		}	
	}
	/**
	 * Implemented by inheritance
	 *
	 */
	protected function getDetails($id)
	{
		
	}

	/**
	 *  Get Html representation of class
	 */
	public function __toString()
	{
		if(!is_array($this->elements)) { return "";}

        $record = $this->db_record->addRecord();
        $record->addElement('text',array('text'=>$this->id,'class'=>'data-id','name'=>'Specimen ID'));
		foreach($this->elements as $key => $element)
		{
			$record = $this->db_record->addRecord();
			
			if(current($this->eltypes) == 'text' && $key !== 'Specimen ID')
			{
				$record->addElement('text',array('text'=>$element,'class'=>'textelement','name'=>key($this->eltypes)));
			}
			elseif(current($this->eltypes) == 'email')
			{
				$record->addElement('email',array('name'=>key($this->eltypes),'mailto'=>$element,'text'=>$element));
			}
			elseif(current($this->eltypes) == 'picture')
			{
				$record->addElement('pic',array('src'=>$element,'alt'=>'Picture','class'=>array('pic_element')));
			}	
			next($this->eltypes);
		}
			return $this->db_record->__toString();
	}	
}

class User_record extends Db_record 
{

	
	public function __construct(Oracle $db,$id)
	{
		$this->id = $id;
		
		parent::__construct($db,'User');
	}
	
	protected function getDetails($id)
	{
		$sql = "select nvl(a.last_name,' ') as last_name,
				       nvl(a.first_name,' ') as first_name,
				       nvl(a.address,' ') as address,
				       nvl(a.phone_number,' ') as phone_number,
				       nvl(a.email,' ') as email,
				       nvl(b.name,' ') as name,
				       a.pic 
				       from persons a, institutes b where a.ite_seqno = b.seqno and a.seqno = :id";
		
		$bind = array(':id'=>$id);
		
		$res = $this->db->query($sql,$bind);
		
		$this->elements =  $res->fetch();
		
		$this->eltypes = array('Last Name'=>'text',
							   'First Name'=>'text',
							    'Address'=>'text',
							    'Phone Number'=>'text',
							    'Email'=>'email',
							    'Institute'=>'text',
							   );
		$this->eltypes[] = "picture";					   
	}
}
class Specimen_record extends Db_record 
{
	public function __construct(Oracle $db,$id)
	{
		$this->id = $id;
		
		parent::__construct($db,'Specimen');
	}
	
	protected function getDetails($id)
	{
		if($id == 'init') { return "";}
		
		$sql = <<<EOD
SELECT 
g.SEQNO "Specimen ID",
nvl(h.VERNACULAR_NAME_EN,' ') "Species",
g.SCN_NUMBER "Number",
nvl(g.COLLECTION_TAG,' ') "RBINS Collection tag",
nvl(g.SEX,' ') "Sex" 
FROM 
(Specimens) g, 
(Taxa) h
WHERE 
h.SEQNO = g.TXN_SEQNO
and g.SEQNO = :id 
EOD;


		$bind = array(':id'=>$id);
		
		$res = $this->db->query($sql,$bind);
		
		$this->elements =  $res->fetch();

		$this->eltypes = array('Specimen ID'=>'text',
								'Species'=>'text',
							    'Number'=>'text',
							    'RBINS Collection tag'=>'text',
							    'Sex'=>'text'
							   );
		$this->eltypes[] = "picture";					   
	}	
}
?>