<?php
/**
 * 	Class Taxa v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:05/01/2010 
 * 
 */
require_once(Classes.'cms/cms_class.php');
require_once(Classes.'search/searcher_class.php');

class Taxa extends CMS_Element  implements CMS 
{
	
	protected function InitVar($pk)
	{

		$Search_Taxa = new Search_Taxas($this->db);
		
		if($pk !=false)
		{
		$tblalias = $Search_Taxa->query->setTable('Taxas');
		
		$Search_Taxa->query->addWhere(array($tblalias.'.IDOD_ID =',array($pk['Idod Id'])));
		
		$this->Search = $Search_Taxa;
		
		CMS_Element::InitVar($pk);
		}
		else 
		{
		$this->Search = $Search_Taxa;
		}
		
		$this->nameMap = array('Idod_Id'=>'Idod Id',
							   'Taxa'=>'Taxa',
							   'Trivial_Name'=>'Trivial Name');	
			
	}
	protected function InitForm()
	{
    	// form creation 
    	
		$taxa_form = new Form('Taxa_form','POST');
		
		$taxa_form->setAttribute('class','default_form');

		if($_SERVER['PHP_SELF'] == '/functions/cms_load.php')
		{
			$server  = $_SERVER['HTTP_REFERER'];
		}
		else 
		{
			$server  = $_SERVER['PHP_SELF'];
		}
		
		$taxa_form->setAttribute('action',$server);
		

		$taxa_form_fs  = $taxa_form->addElement('fieldset')->setLabel('Taxa Informations');  

		$idod_id_fs = $taxa_form_fs->addElement('text', 'Idod_Id', array('style' => ''), array('label' => 'Idod Id:') );
		
		$taxa_fs   = $taxa_form_fs->addElement('text', 'Taxa', array('style' => ''), array('label' => 'Taxa:') );

		$trivialname_fs   = $taxa_form_fs->addElement('text', 'Trivial_Name', array('style' => ''), array('label' => 'Trivial Name:') );
 
		// rules
		$idod_id_fs->addRule('required', 'required');	
		$taxa_fs->addRule('required', 'required');	
 		$trivialname_fs->addRule('required','required');
 		
 		return $taxa_form;
		
	}
	/**
	 * Add functionality 
	 * based on a set of attributes
	 *
	 */		
	public function Add(array $attributes)
	{
	$that = $this->CheckAuth('ADMIN');
	
	// restrict method to admin user
	if(!$this->CheckAuth('ADMIN'))
	{ $this->errormessage = "Not Authorized to add a taxa"; $this->isError = true; return false;}

	$table = new Table($this->db,'taxas');
	
	$table->Add($attributes);
	
	if($table->isError == true) 
	{ $this->isError = true;$this->errormessage = $table->errormessage;return false;}

	return true;
	
	}
	/**
	 * Update functionality 
	 * based on a set of attributes
	 *
	 */
	public function Update(array $attributes,$pks = array())
	{
	// restrict method to admin user
	if(!$this->CheckAuth('ADMIN'))
	{ $this->errormessage = "Not Authorized to update a taxa"; $this->isError = true; return false;}
	
	$table = new Table($this->db,'taxas');
	$table->identifier = "Idod_Id";
	
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
	// restrict method to admin user
	if(!$this->CheckAuth('ADMIN'))
	{ $this->errormessage = "Not Authorized to delete a taxa"; $this->isError = true; return false;}
	
	$table = new Table($this->db,'taxas');
	$table->identifier = "Idod_Id";
	
	$table->Delete($pks);
	
	if($table->isError == true) 
	{ $this->isError = true;$this->errormessage = $table->errormessage;return false;}
	
	
	/* return true in case of successful deletion */
	return true;
			
	}	
}


?>
