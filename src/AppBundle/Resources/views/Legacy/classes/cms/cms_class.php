<?php
/**
 * 
 * 		CMS (Content Management System) v1.0.0
 * 
 * 	5 Methods ( Add, Update, Delete, InitVar, InitForm)
 * 
 *  InitVar ( input = primary key, output = variables needed for update or add )
 *  Author: De Winter Johan 
 *  Last Modified:23/12/2009 
 * 
 * 
 */
include_once(Functions.'Fixcoding.php');

interface CMS 
{
	/**
	 * Add functionality 
	 * based on a set of attributes
	 *
	 */
	public function Add(array $attributes);
	/**
	 * Update functionality 
	 * based on a set of attributes
	 *
	 */
	public function Update(array $attributes,$pks = array());
	/**
	 * Delete functionality 
	 * based on a set of attributes
	 *
	 */
	public function Delete($pks = array());
	
	/**
	 * Output form, web interface
	 *
	 */
	public function __toString();

}

class CMS_Element 
{
		/**
		 * Array of attributes defining a unique item
		 * Format (Table_alias.Table_column => value )
		 * For the init attributes the Format is ( Table_name.Table_column => value)
		 * @var array
		 */
		protected $pk = false;
		/**
		 *  Store a link to a database connection  
		 *   @var Oracle 
		 */
		protected $db;
		/**
		 *  Store an array of elements identified by the pk.
		 * format ( 'alias'=>'value' or array) 
		 *  @var array
		 */
		protected $attributes = array();
		
		/**
		 * error handling mecanism
		 *
		 * @var bool
		 */
		public $isError;
		/**
		 * error handling mecanism
		 *
		 * @var string
		 */
		public $errormessage;
		/**
		 * Person responsible of the object creation
		 *	id of the corresponding person
		 * @var string
		 */
		protected $person;
		
		/**
		 * Implemented by inheritance
		 *
		 * @var Search object
		 */
		protected $Search;
		
		protected $form;
		
		protected $encrypts = array();
		
		/**
		 * Contains a mapping between the web form names and the search names
		 * 
		 * key(form) => value(search)  
		 * @var unknown_type
		 */
		protected $nameMap = false;
		
		
		public $restricted;
		
		
		
		public function __construct(ORACLE $db,$person,$pk = false,$restricted = false)

		{	
			$this->restricted = $restricted;
			
			$this->db = $db;

			$this->InitVar($pk);
			
			$this->form = $this->InitForm();
			
			$pkelem = $this->form->addElement('text', 'pk', array('style' => 'display:none;'), array('label' => '') );

			$this->person = $person;
			
			if($pk != false)
			{
				
			 	if($this->isError == true) { return false;}

			 	$this->FillForm();
			 	
			 	$output = array();
				
			 	foreach($pk as $key=>$item){$output[] = '"'.$key.'":'.$item;}
				 
			 	$pkelem->setAttribute('value','{'.implode(',',$output).'}');	// transform the $pk in json .... just need (json_decode) 	   
			}
			
			$this->InitDecode();
			
		
		}
		
		/**
		 * Get Access to the form, return form is success false otherwize
		 *
		 * @return unknown
		 */
		public function getForm()
		{
			if(is_object($this->form) && $this->form instanceof Form)
			{
				return $this->form;
			}
			else 
			{
				return false;
			}
		}
		protected function Encrypt($attributes)
		{
		
			
			$tmp = array();
			
			foreach($attributes as $key => $value)
			{
				if(in_array($key,$this->encrypts) == true)
				{
					$tmp[$key] = md5($value);
				}
				else 
				{
					$tmp[$key] = $value;
				}
			}
			return $tmp;	
		}
		
		/**
		 * Used when the data's is sending back to the database
		 *
		 * @return array
		 */
		protected function InitDecode()
		{
			$attributes = $this->attributes;
			
			$tmp = array();
			
			foreach($attributes as $key => $value)
			{
				if($value != null) {$tmp[$key] = fixDecoding($value);}
			}
			$this->attributes = $tmp;
		}
		/**
		 * To be filled lated, inheritance
		 *
		 */
		protected function InitVar($pk){
			
		$Search = $this->Search;
			
		$Search->query->build();
			
		$sql = $Search->query->sqlquery;
		
		$binds = $Search->query->bindings;
			
		$results = $this->db->query($sql,$binds);
			
		if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage();return false;}
			
		$rows = $results->fetchAll();
			
			// Ensure that only one element is retrieved -- idea of primary key
		if(count($rows) != 1) { $this->isError = true;$this->errormessage = "not correctly identified element";return false;}
			
		$this->attributes += current($rows);
			
		return true; // in case of success		
		}
		/**
		 * To be filled lated, inheritance
		 *
		 */
		protected function InitForm(){}
		
		
		/**
		 * Helper, to get the correct attributes to the add,update, delete function interface
		 *
		 * @param array $attr
		 * @return array
		 */
		protected function getAttributes(array $attr)
		{
			
			
			// transform form to search 
			$attributes = $this->mapFormtoSearch($attr);
			
			// transform search ( cgrefcodes) in coded values
			
			$attributes = $this->AttributeMapCg_ref_codes($attributes);
			
			// transform search to input 
			
			$columns = $this->Search->query->mapattributes();
			
			foreach($columns as $key => $item)
			{
				if(isset($attributes[$item]))
				{
					$value = $attributes[$item];
					
					unset($attributes[$item]);
					
					$attributes[$key] = $value;
				}
			}
			return $attributes;
		}
		/**
		 *  Map attributes meaning in CG_REF_CODES to its appropriate code
		 * i.e    attributes[coco] = Histology => attributes[coco] = HIS
		 *  coco = search input. => after $this->mapFormtoSearch($attr); before search to tables input 
		 *
		 * @return void
		 */
		protected function AttributeMapCg_ref_codes($attributes)
		{
			$sql = "select rv_low_value as ABR, rv_meaning as MEANING from cg_ref_codes";
			
			$r = $this->db->query($sql);
			
			if($r->isError()){ $this->isError = true;$this->errormessage = "unable to retrieve cg_ref_codes";return false;}
			
			$results = $r->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
			
			$results = array_combine(fixEncoding($results['ABR']),fixEncoding($results['MEANING']));
			
			foreach($attributes as $attributeName => $attributeValue)
			{
				$cgrefcodes = $this->Search->getCgrefcodes();
				if($cgrefcodes == false){$cgrefcodes = array();} 
				
			 if(in_array($attributeValue,$results) == true && array_key_exists($attributeName,$cgrefcodes))
			 {
			 	$attributes[$attributeName] = array_search($attributeValue,$results);
			 }	
				
			}
			return $attributes;
		}
		
		/**
		 * Map attributes from search format to form format 
		 *
		 * @return unknown
		 */
		protected function mapSearchtoForm()
		{
			$attributes = $this->attributes;
			
			$maps = $this->nameMap;
			
			$tmp = array();
			foreach($maps as $form => $search)
			{
			 if(array_key_exists($search,$attributes) == true)
			 {
			 	$tmp[$form] = $attributes[$search];
			 }	
			}
			return $tmp;
		}
		
		protected function mapFormtoSearch($attributes)
		{
			$maps = $this->nameMap;
			$tmp = array();
			
			foreach($attributes as $form => $value)
			{
				if(array_key_exists($form,$maps) == true)
				{
					$tmp[$maps[$form]] = $value;
				}
			}
			return $tmp;
		}

	/**
	 * Output form, web interface, perform user task ( update, delete, add)
	 *
	 */
	public function __toString()
	{
		// condition : ($this->form->getValue() == null) avoid multiple form-interactions problem on a same page 
		if(!$this->form->validate() || $this->form->getValue() == null)
		{

			if( isset($_GET['pk']) && strlen($_GET['pk'])>0) {
				$this->form->isAdd = false;
				return $this->form->__toString();
			}
			else 
			{
				$this->form->iSAdd = true;
				return $this->form->__toString();
			}
					
		}
		
		
		if(isset($_POST['submit']) && $_POST['submit'] == 'Add' )
		{

			$attributes = $this->form->getValue();
			
			$attributes = $this->Encrypt($attributes);
			
			$tmp = $this->getAttributes($attributes);  // WRONG
			
			$this->Add($tmp);
			$this->form->isAdd = false;
			
			if($this->isError == false)
			{
				$message = "<span class='successmessage'>The informations have been successfully added</span>";
			}
			else 
			{
				$message = $this->errormessage;
			}
			return $this->form->__toString().$message;
			
		}
		
		
		if(isset($_POST['submit']) && $_POST['submit'] == 'Update' && isset($_POST['pk']) && strlen($_POST['pk'])>0)
		{
			$attributes = $this->form->getValue();
			
			$tmp = $this->getAttributes($attributes);  // WRONG 
			
			$pk    = json_decode($attributes['pk'],true);
			
			// to cope with the pk definition of the table_class helper
			
			$this->Update($tmp,array_values($pk)); 
			
			if( isset($_GET['pk']) && strlen($_GET['pk'])>0) 
			{
				$this->form->isAdd = false;
				if($this->isError == false)
				{
					$message = "<span class='successmessage'>The informations have been successfully updated</span>";
				}
				else 
				{
					$message = $this->errormessage;
				}
			return $this->form->__toString().$message;
			}
			else 
			{
				if($this->isError == false)
				{
					$message = "<span class='successmessage'>The informations have been successfully updated</span>";
				}
				else 
				{
					$message = $this->errormessage;
				}
			return $this->form->__toString().$message;
				
			}
			
			
		}
		if(isset($_POST['submit']) && $_POST['submit'] == 'Delete' && isset($_POST['pk']) && strlen($_POST['pk'])>0)
		{
			$attributes = $this->form->getValue();
			$pk    = json_decode($attributes['pk'],true);
			
			$this->Delete(array_values($pk));
			$this->form->isAdd = true;	
			if($this->isError == false)
			{
				$message = "<span class='successmessage'>The informations have been successfully updated</span>";
			}
			else 
			{
					$message = $this->errormessage;
			}
			return $this->form->__toString().$message;
			
		}
		

		
	}
	
	/**
	 * Fill the form at instantiation, if and only if a pk is set up 
	 * example : $institute = new institute($db,$person,$pk)
	 * 
	 */
	protected function FillForm()
	{
	
		$form = $this->form;
		
		foreach ($form as $element) {    $this->FillElement($element);  }
		
	}
	
	protected function FillElement($element)
	{
		$attributes = $this->mapSearchtoForm();
			
		if ('fieldset' == $element->getType()) 
			{
				$this->FillFieldset($element);
			}
			
			else 
			{
				if(array_key_exists($element->getName(),$attributes))
				{
					if($attributes[$element->getName()] != null) 
					{
					$element->setValue(fixEncoding($attributes[$element->getName()]));
					}
				}
			}
	}
	protected function FillFieldset($fieldset)
	{
		foreach ($fieldset as $element) {$this->FillElement($element);}
	}
	
	/**
	 * Check authorization for basic operations
	 *
	 * @param  array $group, string $group
	 * @return unknown
	 */
	public function CheckAuth($group)
	{

	$person = $this->person;	

	if(is_string($group)==true){$groups = array($group);} else { $groups = $group;}
	
	foreach($groups as $group)
	{
		$sql = "select count(*) as num_rows from (persons) a, (person2groups) b, (groups c) where 
				a.seqno = b.psn_seqno and b.grp_name = c.name and name = :groupname and a.seqno = :person" ;
	
		$bind = array(':person'=>$person,':groupname'=>$group);
	
		$r = $this->db->query($sql,$bind);
		if($r->isError()){ $this->isError = true;$this->errormessage = $r->errormessage(); return false;}
	
		$row = $r->fetch();
		if($row['NUM_ROWS'] == 0)
		{ $this->isError = true;$this->errormessage = "User not belonging to group $group";return false;}

		return true;
	}
	
	
	
	}
		
}

?>
