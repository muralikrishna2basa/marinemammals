<?php
require_once(Classes.'cms/cms_class.php');
require_once(Classes.'search/searcher_class.php');
/**
 * 	Class Sample v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Sample extends CMS_Element  implements CMS 
{	
	public $location;
	
	protected function InitVar($pk)
	{
		$Search_Sample = new Search_Samples($this->db,5);
		
		$Search_Sample->RemoveAllFilters(); // Remove all filters implemented by default 
		
		$success = $Search_Sample->addFilter(array('Filter_Sample_Localizations_Seqno'));
		
		$Search_Sample->FilterbyName('localization seqno','#');
		
		
		if($pk !=false)
		{
			$tblalias = $Search_Sample->query->setTable('Samples');
			
			$Search_Sample->query->addWhere(array($tblalias.'.seqno =',array($pk['Seqno'])));
			
			$this->Search = $Search_Sample;
		
			CMS_Element::InitVar();
			
		}
		else 
		{
			$this->Search = $Search_Sample;
		}
		
		$this->nameMap = array('Availability'=>'Availability',
							   'Conservation_Mode'=>'Conservation Mode',
							   'Analyze_dest'=>'Analyze Dest',
							   'Sample_Type'=>'Sample Type',
							   'container_localization'=>'Container Localization');	
		
	}
	protected function InitForm()
	{
		$form = new Form('Sample_form','POST');
		
		$form->setAttribute('class','default_form');

		if($_SERVER['PHP_SELF'] == '/functions/cms_load.php')
		{
			$server  = $_SERVER['HTTP_REFERER'];
		}
		else 
		{
			$server  = $_SERVER['PHP_SELF'];
		}
		
		
		$form->setAttribute('action',$server);
		
		$availability = $form->addElement('select','Availability', 
										 array('style' => 'width: 40px;'), array('label' => 'Availability:') );
		
		$availability->loadOptions(array(NULL=>NULL,'yes'=>'yes','no'=>'no'));
	
		
		$conservation_mode = $form->addElement('select','Conservation_Mode', 
										 array('style' => 'width: 120px;'), array('label' => 'Conservation Mode:') );
										 
										 
		$sql = "select rv_meaning as content, rv_low_value as abr from cg_ref_codes where rv_domain ='CONSERVATION_MODE'";

		$results = $this->db->query($sql);
		
		if($results->isError()){ $this->isError = true; $this->errormessage = "Not possible to retrieve Conservation Mode from cg_ref_codes";return false;}
		
		$row = $results->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
		
		$conservation_mode->loadOptions(array_combine(fixEncoding($row['CONTENT']),fixEncoding($row['CONTENT'])));
		
		$analyze_dest = $form->addElement('select','Analyze_dest', 
										 array('style' => 'width: 120px;'), array('label' => 'Analyze Dest:') );
										 
		$sql = "select rv_meaning as content, rv_low_value as abr from cg_ref_codes where rv_domain ='ANALYZE_DEST'";	

		$results = $this->db->query($sql);
		
		if($results->isError()){ $this->isError = true; $this->errormessage = "Not possible to retrieve Analyze Dest from cg_ref_codes";return false;}
		
		$row = $results->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
		
		$analyze_dest->loadOptions(array_combine(fixEncoding($row['CONTENT']),fixEncoding($row['CONTENT'])));
		
		$sample_type = $form->addElement('select','Sample_Type', 
										 array('style' => 'width: 120px;'), array('label' => 'Sample Type:') );
										 
		$sql = "select rv_meaning as content, rv_low_value as abr from cg_ref_codes where rv_domain ='SPE_TYPE'";	

		$results = $this->db->query($sql);
		
		if($results->isError()){ $this->isError = true; $this->errormessage = "Not possible to retrieve SAMPLE TYPE Dest from cg_ref_codes";return false;}
		
		$row = $results->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
		
		$sample_type->loadOptions(array_combine(fixEncoding($row['CONTENT']),fixEncoding($row['CONTENT'])));

		$container_localization = $form->addElement('text','container_localization', 
										 array('style' => 'width: 120px;'), array('label' => 'Container Localization:') ); 
		
		$container_localization->setAttribute('class','drop');								 
		 
		 // Rules
		 
		 $container_localization->addRule('required', 'Localization required');	
		 
		 return $form;
	}	
	/**
	 * Add functionality 
	 * based on a set of attributes
	 *
	 */		
	public function Add(array $attributes)
	{
		
		
	if(!$this->CheckAuth(array('ADMIN','AUTOPSIER')))
	{ $this->errormessage = "Not Authorized to Add Sample"; $this->isError = true; return false;}

	
	$table = new Table($this->db,'samples');
	// prior to add, the attributes belonging to cg_ref_codes must be converted back to a table attribute element 
	
	$table->Add($attributes);
	
	if($table->isError == true) 
	{ $this->isError = true;$this->errormessage = $this->table->errormessage;return false;}

	return true;
			
		
	}

	/**
	 * Update functionality 
	 * based on a set of attributes
	 *
	 */
	public function Update(array $attributes,$pks = array())
	{
		
	if(!$this->CheckAuth(array('ADMIN','AUTOPSIER')))
	{ $this->errormessage = "Not Authorized to Alter Sample"; $this->isError = true; return false;}

	// prior to add, the attributes belonging to cg_ref_codes must be converted back to a table attribute element 
	
	
	
	$table = new Table($this->db,'samples');

	$table->Alter($attributes,$pks);
		
	if($table->isError == true) 
	{ $this->isError = true;$this->errormessage = $table->errormessage;return false;}
	
	return true;		
		
	}
	/**
	 * Delete functionality 
	 * based on a set of attributes
	 *
	 */
	public function Delete($pks = array())
	{

	if(!$this->CheckAuth(array('ADMIN')))
	{ $this->errormessage = "Not Authorized to Alter Sample"; $this->isError = true; return false;}
			
	$table = new Table($this->db,'samples');
	
	$table->Delete($pks);
	
	if($table->isError == true) 
	{ $this->isError = true;$this->errormessage = $table->errormessage;return false;}
	
	
	/* return true in case of successful deletion */
	return true;
		
	}
	
	/**
	 * Check the validity of the sample
	 *
	 * @param integer $sample
	 * @return bool 
	 */
	protected function isValid($sample)
	{	

		$sql = "select count(*) as num_rows from samples where seqno  = :sample";
		$bind = array(':sample'=>$sample);
		
		$r = $this->db->query($sql,$bind);
		
		if($this->db->isError())
		{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}	
		
		$res = $r->fetch();
		
		if($res['NUM_ROWS'] != 1 )
		{ $this->isError = true; $this->errormessage = 'sample not valid';return false;}
		
		return true;
		
	}
	
	/**
	 * The method is called, if and only if the object sample has been instantiated, meaning that the sample
	 * object contain a valid sample !!!
	 * 
	 * return an array of location, return false if an error occur 
	 * 
	 */
	public function locate($sample)
	{
		if($this->isValid($sample) != true) 
		{ $this->isError = true;$this->errormessage = "Sample not valid ";return false;}
		
		
		$sql = "select connect_by_root b.seqno as id_init,container_type,name
					from container_localizations b
					where name !='ROOT'
					connect by b.seqno = prior b.cln_seqno
					start with b.seqno in  ( select cln_seqno from samples where seqno = $sample)";
		
		$r = $this->db->query($sql);
		
		if($this->db->isError()== true)
		{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}	
		
		while($res = $r->fetch())
		{
			$this->location[$res[strtoupper('container_type')]] = $res[strtoupper('name')]; 
		}
		return $this->location;
	}

}	
?>