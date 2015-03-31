<?php
/**
 * 	Class Institute v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
require_once(Classes.'cms/cms_class.php');
require_once(Classes.'search/searcher_class.php');

class Institute extends CMS_Element  implements CMS 
{
	
	protected function InitVar($pk)
	{

		$Search_Institute = new Search_Institutes($this->db);
		
		if($pk !=false)
		{
		$tblalias = $Search_Institute->query->setTable('Institutes');
		
		$Search_Institute->query->addWhere(array($tblalias.'.seqno =',array($pk['Seqno'])));
		
		$this->Search = $Search_Institute;
		
		CMS_Element::InitVar();
		}
		else 
		{
		$this->Search = $Search_Institute;
		}
		
		$this->nameMap = array('Code'=>'Code',
							   'Name'=>'Name',
							   'Seqno'=>'Seqno');	
			
	}
	
	protected function InitForm()
	{
    	// form creation 
    	
		$institute_form = new Form('Institute_form','POST');
		
		$institute_form->setAttribute('class','default_form');

		
		if($_SERVER['PHP_SELF'] == '/functions/cms_load.php')
		{
			$server  = $_SERVER['HTTP_REFERER'];
		}
		else 
		{
			$server  = $_SERVER['PHP_SELF'];
		}
		$institute_form->setAttribute('action',$server);
		

		$institute_form_fs  = $institute_form->addElement('fieldset')->setLabel('Institute Informations');  

		$code_fs   = $institute_form_fs->addElement('text', 'Code', array(''), array('label' => 'Code:') );

		$name_fs   = $institute_form_fs->addElement('text', 'Name', array(''), array('label' => 'Name:') );

		 
		// rules
		
		$code_fs->addRule('required', 'Code required');	
 		$name_fs->addRule('required','Name required');
 		
 		return $institute_form;
		
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
//	if(!$this->CheckAuth('ADMIN'))
//	{ $this->errormessage = "Not Authorized to add an institute"; $this->isError = true; return false;}

	$table = new Table($this->db,'institutes');
	
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
	{ $this->errormessage = "Not Authorized to update an institute"; $this->isError = true; return false;}
	
	$table = new Table($this->db,'institutes');

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
	{ $this->errormessage = "Not Authorized to delete an institute"; $this->isError = true; return false;}
	
	$table = new Table($this->db,'institutes');
	
	$table->Delete($pks);
	
	if($table->isError == true) 
	{ $this->isError = true;$this->errormessage = $table->errormessage;return false;}
	
	
	/* return true in case of successful deletion */
	return true;
			
	}

}
?>