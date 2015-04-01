<?php
/**
 * 	Class Person v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 */  


require_once(Functions.'Fixcoding.php');
include_once(Classes."order/Table_class.php");
include_once(Classes.'search/search_query.php');
/**
 * Contains all manipulations to be done at the person level
 *
 */
class Person 
{	
	/**
	 * Database ressource
	 *
	 * @var oracle
	 */
	private $db;
	
	public $isError = false;
	
	public $errormessage;
	
	private $table;
	
	/**
	 * Array of available groups
	 *
	 * @var unknown_type
	 */
	public $available_groups = array();
	
	private $person = null;
	/**
	 * Person attributes ( sex, name,login_name,)
	 * For security reason ( and because the password is stored in the session (md5 encrypted) )
	 * The password is not of the party
	 * @var array( attribute => attribute value)
	 */
	private $attributes;
	
	/**
	 * List of group keyed with the group level
	 *
	 * @var array( ADMIN=>4,GUEST=>3) etc...
	 */
	public $groups;
	/**
	 * Contains all datas related to the attributes ( i.e not only the aliases but also their relation to the table columns)
	 *
	 * @var unknown_type
	 */
	public $query_attributes;	   
							   
	public function __construct(ORACLE $db,$person = null)
	{
		
		$this->db = $db;
		if($person !=null)
		{
		if(!$this->isValid($person)){ return false;}
		$this->person = $person;
		$this->setAttributes();
		$this->setGroup();
		$this->GetAvailableGroups();
		}
		$this->table = new Table($db,'persons');
		
	}	
	
	private function GetAvailableGroups()
	{
		$sql = "select name from groups";
		$result = $this->db->query($sql);
		if($this->db->isError()){$this->isError = true;$this->errormessage = $this->db->errormessage();return false;}
		while($item = $result->fetch())
		{
		$this->available_groups[] = $item['NAME'];	
		}
		
	}
	
	private function isValid($person)
	{
		$sql = "select count(*) as num_rows from persons where seqno  = :person";
		$bind = array(':person'=>$person);
		
		$r = $this->db->query($sql,$bind);
		
		if($this->db->isError())
		{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}	
		
		$res = $r->fetch();
		
		if($res['NUM_ROWS'] != 1 )
		{ $this->isError = true; $this->errormessage = 'Person not valid';return false;}
		
		return true;	
	}
	
	private function setAttributes()
	{
		$query = new BLP_Query;
		
		$alias1 = $query->setTable('persons');
		$alias2 = $query->setTable('institutes');
		
		$basecolumns = array('Last Name'  => $alias1.'.last_name',
		                     'First Name'=> $alias1.'.first_name',
		                     'Phone Number'        => $alias1.'.phone_number',
		                     'Email'       => $alias1.'.email',
		                     'Sex'  => $alias1.'.sex',
		                     'Login Name'=>$alias1.'.login_name',
		                     'Address' => $alias1.'.address',
		                     'Title'   =>$alias1.'.title',
		                     'Idod id'=>$alias1.'.idod_id',
		                     'Institute'=>$alias2.'.name'
		                     );
		foreach ($basecolumns as   $column=>$alias){
			$query->addColumn($column,$alias);
		}
		
		$query->addJoin($alias1.'.ite_seqno = '.$alias2.'.seqno');
		$query->addWhere(array($alias1.'.seqno =',array($this->person)));
		
		$query->build();
		
		$sql = $query->sqlquery;
		$binds = $query->bindings;
		
        $result = $this->db->query($sql,$binds);
        
		if($this->db->isError())
		{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}	
        
		$this->attributes = $result->fetch();
		
		$this->query_attributes = $query;
        
	}
	public function getInstitutes()
	{
		$sql = "select seqno, name from institutes";
		
		$r = $this->db->query($sql);
		
		if($r->isError())
		{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}	
        
		$tmp = array();
		while($res = $r->fetch())
		{
			$tmp[$res['SEQNO']] = $res['NAME'];
		}
		return $tmp;
	}
	public function getTableAttributes($tablename)
	{
		 $alias = $this->query_attributes->setTable($tablename);
		
		$columns = $this->query_attributes->columns;
		$tmp = array();
		foreach($columns as $key =>$column)
		{
		if(substr_count($key,"$alias.")!=0){ $tmp[str_replace("$alias.",'',$key)]=$column;}			
		}
	
		return $tmp;
	}
	/**
	*   Required by the constructor, set the person group 
	*/
	private function setGroup()
	{
		$sql = <<<EOD
		select c.access_level,c.name from (persons) a, (person2groups) b, (groups) c 
			where b.psn_seqno = a.seqno
			and b.grp_name = c.name
			and a.seqno = $this->person	
EOD;
		$r = $this->db->query($sql);
		
		if($this->db->isError())
		{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}	
		
		while($res = $r->fetch())
		{
		$this->groups[$res['NAME']] = $res['ACCESS_LEVEL'];
		
		}
	}
	/**
	 * Group user verification 
	*/
	public function CheckAuth($group)
	{
	$person = $this->person;	
		
	$sql = "select count(*) as num_rows from (persons) a, (person2groups) b, (groups c) where 
				a.seqno = b.psn_seqno and b.grp_name = c.name and name = :groupname and a.seqno = :person" ;
	
	$bind = array(':person'=>$person,':groupname'=>$group);
	
	$r = $this->db->query($sql,$bind)->fetch();
  	if($this->db->isError()){ $this->isError = true;$this->errormessage = $this->db->errormessage(); return false;}
	if($r['NUM_ROWS'] == 0)
	{ $this->isError = true;$this->errormessage = "User not belonging to group $group";return false;}

	return true;
	}
	public function getGroups($person = null)
	{
		if($person == null || $person == false) { return $this->groups;}
		
		$person_o = new Person($this->db,$person);
	
		if($person_o->isError == true){ $this->isError = true; $this->errormessage = "Unknown person";return false;}
	    
		return $person_o->groups;
			
	}
	public function AddGroup($group,$person = null)
	{
		
	if($person == null || $person == false) { $person = $this->person;}	
	
	/* check that person input is a valid person  */
	
	if(!is_numeric($person)){ $this->isError = true;$this->errormessage = "not valid person format";return false;}
	
	/* Check  autorization*/
	if(!$this->CheckAuth('ADMIN')){ $this->errormessage = "Not Authorized to Add group"; $this->isError = true; return false;}
	
	/* Check that the group belong to the list of available groups */
	
	if( !is_string($group) || !in_array($group,$this->available_groups)){$this->errormessage = "Group unknown"; $this->isError = true; return false; }
	
	
	/* Check that the user exist  */
	
	$person_o = new Person($this->db,$person);
	
	if($person_o->isError == true){ $this->isError = true; $this->errormessage = "Unknown person";return false;}
	
	/* Check that the user doesn't have already the group privilege to add*/
	if(in_array($group,array_keys($person_o->groups))){$this->isError = true; $this->errormessage = "The user is already in the group";return false;}
	
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
	
	/* Check that the group belong to the list of available groups */
	if( !is_string($group) || !in_array($group,$this->available_groups)){$this->errormessage = "Group unknown"; $this->isError = true; return false; }
	
	/* Check that the user exist and got the group to delete */
	
	$person_o = new Person($this->db,$person);
	
	if($person_o->isError == true){ $this->isError = true; $this->errormessage = "Unknown person";return false;}
	
	if(!in_array($group,array_keys($person_o->groups))){$this->isError = true; $this->errormessage = "No group to delete";return false;}
	
	
	$sql = "delete from person2groups where psn_seqno = $person and grp_name = '$group'";
	
	$r = $this->db->query($sql);
	
	if($r->isError()){ $this->errormessage = $r->errormessage(); $this->isError = true; return false;}
	
	
	return true;
	
	}
	public function AddPersonInstitute($person,$institute)
	{

	if(!$this->CheckAuth('ADMIN'))
	{ $this->errormessage = "Not Authorized to create a person"; $this->isError = true; return false;}
	
	
	$person_o = new Person($this->db,$person); 
		
	if($person_o->isError){$this->isError = true;$this->errormessage = "not valid person";return false;}
	
	if($person_o->CheckAuth('ADMIN') == true && $person != $this->person) 
	{ $this->isError = true;$this->errormessage = "Cannot Add Institute to other Admin";return false; }
	
	$this->AlterPersons(array('ite_seqno'=>$institute),array($person));
	
	if($this->isError == true) { return false;}
	
	return true;
	
	}
	/**
	 * Create user, personified by its attributes 
	 * 
	 * @param array $attributes
	 * 
	 * @return bool
	 */
	public function AddPerson($attributes)
	{
	
		
	/* Check authorization */

	if(!$this->CheckAuth('ADMIN'))
	{ $this->errormessage = "Not Authorized to create a person"; $this->isError = true; return false;}
	
	$this->table->Add($attributes);
	
	if($this->table->isError == true) 
	{ $this->isError = true;$this->errormessage = $this->table->errormessage;return false;}
	
	
	/* return true if the person has been successfully created */
 	return true;
	}
	/**
	 * Create institute
	 *
	 * @param array $attributes
	 */
	public function AddInstitute($attributes)
	{
	
	if(!$this->CheckAuth('ADMIN'))
	{ $this->errormessage = "Not Authorized to create an institute"; $this->isError = true; return false;}
		
	$table = new Table($this->db,'institutes');
	
	$table->Add($attributes);
	
	if($this->table->isError == true) 
	{ $this->isError = true;$this->errormessage = $this->table->errormessage;return false;}

	/* return true if the person has been successfully created */
 	return true;
	}
	
	/**
	 * Alter institutes personified by their ids 
	 * 
	 * @param array $attributes
	 * @param integer $person
	 * @return bool
	 */
	public function AlterInstitutes(array $attributes,$institutes = array())
	{
	if($this->CheckAuth('ADMIN') == false)
	{$this->isError = true; $this->errormessage = "Not enough privilege to alter this institutes"; return false; }		
	
	$table = new Table($this->db,'institutes');
	
	$table->Alter($attributes,$institutes);
		
	if($table->isError == true) 
	{ $this->isError = true;$this->errormessage = $table->errormessage;return false;}
	
	
	/* Return true if the user has been successfully altered*/
	return true;
	
	}
	/**
	 * Alter users personified by their ids 
	 * 
	 * @param array $attributes
	 * @param integer $person
	 * @return bool
	 */
	public function AlterPersons(array $attributes,$persons = array())
	{
	if($this->CheckAuth('ADMIN') == false)
	{$this->isError = true; $this->errormessage = "Not enough privilege to alter this users"; return false; }	
	/* In case the person is null, then the user is trying to alter itself
	   It is always allowed
	*/
	if(count($persons) == 0) { $persons = array($this->person);}	
	
	
	if( $persons != array($this->person) ) 
	/* exit if a person is not valid or if the user try to modify an admin user which is not itself */
	{   
		$person_o = array();
		foreach($persons as $person)
		{
		
		$person_o[] = new Person($this->db,$person); /* overwritting classes seems to give problems */
		
		if(end($person_o)->isError){$this->isError = true;$this->errormessage = "not valid person format";return false;}
	
		/* Check that the person to alter doesn't belong to the admin group and that the alterer belong to the admin group */
		if(end($person_o)->CheckAuth('ADMIN') == true ) 
		{ $this->isError = true; $this->errormessage = "Not enough privilege to alter an Admin"; return false; }
		
		
		}
	}
	
	$this->table->Alter($attributes,$persons);
		
	if($this->table->isError == true) 
	{ $this->isError = true;$this->errormessage = $this->table->errormessage;return false;}
	
	
	/* Return true if the user has been successfully altered*/
	return true;
	
	}
	/**
	 * Add protection interface to the operation ( i.e deletion )
	 *
	 * @param array $institutes
	 * @return bool
	 */
	public function DeleteInstitutes($institutes = array())
	{
	
	if($this->CheckAuth('ADMIN') == false)
	{$this->isError = true; $this->errormessage = "Not enough privilege to alter this users"; return false; }	
	
	$table = new Table($this->db,'institutes');
	
	$table->Delete($institutes);
	
	if($table->isError == true) 
	{ $this->isError = true;$this->errormessage = $table->errormessage;return false;}
	
	
	/* return true in case of successful deletion */
	return true;
	}
	/**
	 * Delete user personified by its id 
	 *
	 * @param integer $person
	 * @return bool
	 */
	public function DeletePersons($persons = array())
	{
	
	if($this->CheckAuth('ADMIN') == false)
	{$this->isError = true; $this->errormessage = "Not enough privilege to alter this users"; return false; }	
	
	if(count($persons) == 0) { $persons = array($this->person);}	
	
	
	if( $persons != array($this->person) ) 
	/* exit if a person is not valid or if the user try to modify an admin user which is not itself */
	{
		$person_o = array();
		foreach($persons as $person)
		{
		
		$person_o[] = new Person($this->db,$person);
		
		if(end($person_o)->isError){$this->isError = true;$this->errormessage = "not valid person format";return false;}
	
		/* Check that the person to alter doesn't belong to the admin group and that the alterer belong to the admin group */
		if(end($person_o)->CheckAuth('ADMIN') == true ) 
		{$this->isError = true; $this->errormessage = "Not enough privilege to alter an Admin"; return false; }
		}
	}
	
	$this->table->Delete($persons);
	
	if($this->table->isError == true) 
	{ $this->isError = true;$this->errormessage = $this->table->errormessage;return false;}
	
	
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
	foreach($columns_array as $item) { $binded_array[] = ":".$item; $tmp[] = $item."=:".$item;}
	
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
	 * Given a list of person identifier, output an html representation of this list 
	 * Method : Addition of small queries...  not be the fastest way, however, as the amount 
	 * of small queries is limited, this might not affect the rendering speed
	 * @param unknown_type $list
	 */
	public function render($list)
	{
		
		$render_body = '<tbody>';
		$ini = true;
		foreach($list as $item) 
		{   
			$person = new Person($this->db,$item);
			if($person !=false) // if the person is valid
			{   
				if($ini == true)
				{ 
					$ini = false; 
					$render_header = "<thead><tr><td>".implode('</td><td>',array_keys($person->attributes))."</td></tr></thead>";
				}
				$render_body .='<tr><td>'.implode('</td><td>',fixEncoding(array_values($person->attributes))).'</td></tr>';			
			}
		}
		$render_body .= '</tbody>';
		
		return "<table>$render_header $render_body </table>";
		
	}
	public function getAttributes() { return $this->attributes;}
}

?>