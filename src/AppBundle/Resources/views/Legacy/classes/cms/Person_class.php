<?php
/**
 * 	Class Person v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */

require_once(Classes.'cms/cms_class.php');
require_once(Classes.'search/searcher_class.php');



class Person extends CMS_Element  implements CMS 
{ 

	
	
	protected function InitVar($pk)
	{
		
		$Search_Person = new Search_Persons($this->db);
		
		if($pk !=false)
		{
			
		// Init groups
		
		$seqno = $pk['Seqno'];
		
		if($this->restricted == false)
		{
			$sql = <<<EOD
					select c.name from (persons) a, (person2groups) b, (groups) c 
					where b.psn_seqno = a.seqno
					and b.grp_name = c.name
					and a.seqno = '$seqno'
EOD;
			$r = $this->db->query($sql);
		
			if($this->db->isError())
			{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}	
		
			$rows = $r->fetchAll();
		
			$tmp = array();
		
			foreach($rows as $row)		{
					$tmp[] = 	$row['NAME'];
									}
			$this->attributes['Groups'] = $tmp;	
		}
		// Init other attributes
		$tblalias = $Search_Person->query->setTable('Persons');
		
		$Search_Person->query->addWhere(array($tblalias.'.seqno =',array($pk['Seqno'])));
		
		$this->Search = $Search_Person;
		
		CMS_Element::InitVar(); // Get attributes from class
		}
		else 
		{
		$this->Search = $Search_Person;
		}
		
		
		if($this->restricted == false)
		{
		$this->nameMap = array('Login_Name'=>'Login Name',
							   'Last_Name'=>'Last Name',
							   'First_Name'=>'First Name',
							   'Password'=>'Password',
							   'Address'=>'Address',
							   'Phone_Number'=>'Phone number',
							   'Email'=>'Email',
							   'Sex'=>'Sex',
							   'Title'=>'Title',
							   'Idod_id'=>'IDOD Id',
							   'Institute'=>'Institute Code',
							   'Groups'=>'Groups');	
		}
		else 
		{
		$this->nameMap = array('Login_Name'=>'Login Name',
							   'Last_Name'=>'Last Name',
							   'First_Name'=>'First Name',
							   'Address'=>'Address',
							   'Phone_Number'=>'Phone number',
							   'Email'=>'Email',
							   'Sex'=>'Sex');	
		}			
		
		
		

 		$this->encrypts  = array('Password');
 									
					
	}
	
	protected function InitForm()
	{
    	// form creation 
    	
		$form = new Form('Person_form','POST');
		
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
		
		$form_fs  = $form->addElement('fieldset')->setLabel('Login Informations');  //FIELDSET

		$login_name_fs   = $form_fs->addElement('text','Login_Name', array('style' => 'width: 100px;'), array('label' => 'Login Name:'));
		if($this->restricted == false)
		{
			$password_fs     = $form_fs->addElement('password', 'Password', array('style' => 'width: 100px;'), array('label' => 'Password:') );
		
			/* two possible states for the form, either add or update,delete */
			$password_fs->setAttribute('isadd','false');
			
			$password_fs_cfm = $form_fs->addElement('password', 'Password'.'_cfm', array('style' => 'width: 100px;'), array('label' => 'Confirm password:') );
		
			$password_fs_cfm->setAttribute('isadd','false');
		} 
		$pers_details    = $form->addElement('fieldset')->setLabel('Contact details');  //FIELDSET
		
		$last_name_fs    = $pers_details->addElement('text','Last_Name', array('style' => 'width: 100px;'), array('label' => 'Last Name:') );

		$first_name_fs   = $pers_details->addElement('text', 'First_Name', array('style' => 'width: 100px;'), array('label' => 'First Name:') );

	
		$address_fs      = $pers_details->addElement('text','Address', array('style' => 'width: 500px;'), array('label' => 'Address:') );

		$phone_number_fs = $pers_details->addElement('text','Phone_Number' , array('style' => 'width: 100px;'), array('label' => 'Phone Number:') );

		$email_fs        = $pers_details->addElement('text','Email', array('style' => 'width: 150px;'), array('label' => 'Email:') );

		$sex_fs          = $pers_details->addElement('select','Sex', array('style' => 'width: 40px;'), array('label' => 'Sex:') );
		
		$sex_values = array(NULL=>NULL,'M'=>'M','F'=>'F');

		$sex_fs->loadOptions($sex_values);
		if($this->restricted == false)
		{
		
			$person_other_fs = $form->addElement('fieldset')->setLabel('Others');  //FIELDSET


			$sql = "select rv_low_value from cg_ref_codes where rv_domain = 'PSN_TITLE'";
			
			$res = $this->db->query($sql);
			
			$row = $res->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
			
			$psn_title = $row['RV_LOW_VALUE'];

			$title_array = array(NULL=>NULL) + array_combine($psn_title,$psn_title);

			$title_fs = $pers_details->addElement('select', 'Title', array('style' => 'width: 40px;'), array('label' => 'Title:') );

			$title_fs->loadOptions($title_array);
			

			$idod_id_fs      = $person_other_fs->addElement('text','Idod_id', array('style' => 'width: 50px;'), array('label' => 'IDOD ID:') );

			$institute_fs    = $person_other_fs->addElement('select','Institute', array('style' => 'width: 90px;'), array('label' => 'Institute:') );
		
			// load institutes
		
			$sql = "select code, name from institutes";
			$r = $this->db->query($sql);
			if($r->isError()){ $this->isError = true;$this->errormessage = $r->errormessage();return false;}
			$results = $r->fetchAll();
			$tmp = array();
			foreach($results as $result)
			{
				$tmp[$result['CODE']] = $result['NAME'];
			}
			$institute_fs->loadOptions($tmp);
		
			// load groups 
		
			$sql = "select name from groups";
			$r = $this->db->query($sql);
			if($r->isError()){ $this->isError = true;$this->errormessage = $r->errormessage();return false;}
			$results = $r->fetchAll();
			$tmp = array();
			foreach($results as $result){$tmp[$result['NAME']] = $result['NAME'];}
			$available_group_fs        = $person_other_fs->addElement('select','Groups',array('multiple' => 'multiple', 'size' => 4),
				array('options' => $tmp,'label' => 'Available Groups:'));
		
		
		/*
		Rules
		*/
		if( isset($_POST['submit']) && $_POST['submit'] == 'Add' ) 
		{
		$password_fs->addRule('eq', 'Passwords do not match', $password_fs_cfm);
		$password_fs_cfm->addRule('required', 'Password  required');
		$password_fs ->addRule('required', 'Password  required');
		}
		$idod_id_fs->addRule('regex','Must be numeric', '/^\d+$/');
		
		}
		$login_name_fs->addRule('required', 'Login  required');
		$first_name_fs->addRule('required', 'First name required');
		$last_name_fs->addRule('regex', 'Username should contain only letters', '/^[a-zA-Z]+$/');
		$email_fs->addRule('regex','Not a valid email inserted','([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})');
		$sex_fs->addRule('nonempty');
		
 		
 		return $form;
		
	}	
	/**
	 * Add functionality 
	 * based on a set of attributes
	 *
	 */		
	public function Add(array $attributes)
	{
	// restrict method to admin user
	if(!$this->CheckAuth('ADMIN'))
	{ $this->errormessage = "Not Authorized to add this person"; $this->isError = true; return false;}

	if($this->restricted == false)
	{
	
		// handle institute 
	
		$attributes = $this->handleinstitutes($attributes);
	
		if($this->isError == true){ return false;}
	
		// handle groups

		if(isset($attributes['Groups']) && is_array($attributes['Groups']))
		{
			$groups = $attributes['Groups'];
	
			$attributes = array_diff($attributes,array('Groups'=>$groups));
	
		}
	}
	
	$table = new Table($this->db,'persons');
	
	$table->Add($attributes);
	
	if($table->isError == true) 
	{ $this->isError = true;$this->errormessage = $table->errormessage;return false;}
     
	if($this->restricted == false)
	{
		// Get just added element
		$seqno = $this->GetPerson($attributes);
	
	
		foreach($groups as $group)
		{
		if($group !='GUEST') // plsql procedure, add automatically a group
		{
		$this->AddGroup($group,$seqno);
		if($this->isError == true){ return false;}
		}
		}
	}
	return true;
	
	}
	protected function handleinstitutes($attributes)
	{
		
	if(isset($attributes['Institutes.CODE']) && is_string($attributes['Institutes.CODE']) && strlen($attributes['Institutes.CODE'])>0)
	{
	$code = $attributes['Institutes.CODE'];
	
	$sql = "select seqno from institutes where code = '$code'"; 
	
	$r = $this->db->query($sql);
	
	if($r->isError()){ $this->isError = true;$this->errormessage = $r->errormessage();return false; }
	
	$row = $r->fetch();
	
	$seqno = $row['SEQNO']; 
	
	$attributes = array_diff($attributes,array('Institutes.CODE',$code));

	$attributes['Persons.ITE_SEQNO'] = $seqno;
	
	return $attributes;
	}
	
	}

	/**
	 * Update functionality 
	 * based on a set of attributes
	 *
	 */
	public function Update(array $attributes,$pks = array())
	{
	// Restrict method to admin user ( debug purpose for $_SESSION['seqno'] == $this->person to be modified later)
	if(!$this->CheckAuth('ADMIN') && $_SESSION['seqno'] != $this->person)
	{ $this->errormessage = "Not Authorized to update this person"; $this->isError = true; return false;}
	else{ $this->errormessage = ''; }// reset error message 
	
	
	if($this->restricted == false)
	{	
	$attributes = $this->handleinstitutes($attributes);
	
	if($this->isError == true){ return false;}
	
	// handle groups
	
	
	if(isset($attributes['Groups']) && is_array($attributes['Groups']))
	{
	$groups = $attributes['Groups'];
	
	$attributes = array_diff($attributes,array('Groups'=>$groups));
	
	$seqno = current($pks);
	
	$oldgroups = $this->getGroups($seqno);
	
	foreach($oldgroups as $oldgroup) // check for groups to delete 
	{
		if(!in_array($oldgroup,$groups) == true) 
		{
			
		$this->DeleteGroup($oldgroup,$seqno);		
		if($this->isError == true){ return false;}
		}
	}
	
	foreach($groups as $group)
	{
		if(!in_array($group,$oldgroups) == true)
		{
			 $this->AddGroup($group,$seqno); 	
		 
			 if($this->isError == true){ return false;}
		}
	}
	
	
	}
	
	}
	
	$table = new Table($this->db,'persons');

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
	{ $this->errormessage = "Not Authorized to delete this person"; $this->isError = true; return false;}
	
	$table = new Table($this->db,'persons');
	
	$table->Delete($pks);
	
	if($table->isError == true) 
	{ $this->isError = true;$this->errormessage = $table->errormessage;return false;}
	
	
	/* return true in case of successful deletion */
	return true;
			
	}


		/**
	 * Given a list of attributes, search for the corresponding unique person.
	 * Might be useful later on
	 * @param person attributes $attributes
	 * @return integer or false if a problem occur
	 */
	public function GetPerson(array $attributes = null)
	{
	/* In case no attributes are supplied, this simply means that the user want its own id number */
	if($attributes == null) { return $this->person;}	
		
	/* sanitary check*/
	if(!is_array($attributes) || count($attributes) <= 0 ){$this->isError = true;$this->errormessage = 'attribute format wrong';return false;}		
	
	$columns_array = array_keys($attributes);
	
	
	
	$values_array = array_values($attributes); 
	
	
	$binded_array = array();$tmp = array();
	foreach($columns_array as $item) 
	{
		$tp = chr(count($tmp) + 97);
		$binded_array[] = ":".$tp; $tmp[] = $item."=:".$tp;
	}
	
	$columns = implode(' and ',$tmp);
	
	$binds = array_combine($binded_array,$values_array);
	
	$sql = "select count(*) as num_persons from persons where $columns";
	
	$result = $this->db->query($sql,$binds);
	
	if($result->isError()) { $this->isError = true;$this->errormessage = $result->errormessage();return false;}
	
	$tmp = $result->fetch();
	
	if($tmp['NUM_PERSONS'] !=1) {$this->isError = true;$this->errormessage = "Person not unique or impossible to identify";return false;}
	
	/* In case everything work as expected, retrieve person identification number -- not optimal  */
	$results = $this->db->query("select seqno from persons where $columns",$binds)->fetch();
	
	if($this->db->iserror()){$this->isError = true;$this->errormessage = $this->db->errormessage();return false;}
	
	return $results['SEQNO'];
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $group
	 * @param unknown_type $person
	 * @return unknown
	 */
	public function AddGroup($group,$person = null)
	{
		
	if($person == null || $person == false) { $person = $this->person;}	
	
	/* check that person input is a valid person  */
	
	if(!is_numeric($person)){ $this->isError = true;$this->errormessage = "not valid person format";return false;}
	
	/* Check  autorization*/
	if(!$this->CheckAuth('ADMIN')){ $this->errormessage = "Not Authorized to Add group"; $this->isError = true; return false;}
	

	$sql = "insert into person2groups (psn_seqno,grp_name) values ($person,'$group')";
	
	$r = $this->db->query($sql);
	
	if($r->isError()){ $this->errormessage = $r->errormessage(); $this->isError = true; return false;}
	
	
	return true;
	}
	
	public function DeleteGroup($group,$person = null)
	{
	
	if($person == null || $person == false) { $person = $this->person;}	
	
	
	/* Check that person input is a valid person  */
    if(!is_numeric($person)){ $this->isError = true;$this->errormessage = "not valid person format";return false;}
	
	/* Check  autorization*/
	if(!$this->CheckAuth('ADMIN')){ $this->errormessage = "Not Authorized to Delete group"; $this->isError = true; return false;}
	
	$sql = "delete from person2groups where psn_seqno = $person and grp_name = '$group'";
	
	$r = $this->db->query($sql);
	
	if($r->isError()){ $this->errormessage = $r->errormessage(); $this->isError = true; return false;}
	
	
	return true;
	
	}
	
	private function getGroups($seqno)
	{
		$sql = <<<EOD
		select c.name from (persons) a, (person2groups) b, (groups) c 
			where b.psn_seqno = a.seqno
			and b.grp_name = c.name
			and a.seqno = $seqno	
EOD;
		$r = $this->db->query($sql);
		
		if($this->db->isError())
		{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}	
		
		$rows = $r->fetchAll();
		$tmp = array();
		foreach($rows as $row){$tmp[] = $row['NAME'];}
		return $tmp;
	}

	
}
?>