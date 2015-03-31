<?php
/**
 * 	Class BLP_Filter, Filters v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 *  Last Modified:23/02/2010 
 *
 *  Details:
 * ---------
 * 
 * At the filter construction, 
 * It happens that a filter is used only for its added values( columns and joins) to the original query
 * This might be useful for column display, so even if an item is not submitted, one should construct the filter so that the 
 * process method return after the join and column creation... 
 *
 */
include_once(Classes.'search/search_query.php');


class BLP_Filter
{
	/**
	 * Enter description here...
	 *
	 * @var elements the filter must respond to 
	 */
	public $tokens= array();
	/**
	 * Contains the query to be modified
	 *
	 * @var BLP_Query object 
	 */
	public $query;

    /**
     * Contains the filter name
     *
     * @var unknown_type
     */
	public $name;
	
	public $db; 
	/**
	 * Contains the allowable values if specified
	 *
	 * @var unknown_type
	 */
	public $domain = array();
	
	/**
	 * Allowed group level for the filter to be used 
	 * @var numeric
	 */
	public $allowedgrouplevel = 0;
	
	public function __construct($query,$db){ 
		
		 // by default a group level of zero is set
		$this->query = $query;
		$this->initTokens();
		$this->initName();
		$this->db = $db;
		$this->initDomain();
        	}
	public function getTokens() { return $this->tokens;}
	
	public function addToken($token)
	{
		$this->tokens[] = $token;
		return count($this->tokens); 
	}
	
	public function addTokens($tokens) 
	{ $this->tokens = $tokens;}
	
	public function initTokens() {} 
	
	public function initName() {} 
	
	public function initDomain(){}

/**
 * Populate the allowable values for the filter
 * no bindings.
 * @param unknown_type $sql
 */
	public function AddDomain($sql,$item){
		 $item = strtoupper($item); // Because the alias retrieved from the database is in upper case. 
		$results = $this->db->query($sql);
		if($results->isError()){ return;} // In case of a problem => do nothing
		while($result = $results->fetch())
		{$this->domain[]= $result[$item];}
	}
	
}

// FILTER OBSERVATIONS
class Filter_Observation_Observation_type extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'Observation Type';
			
	}
	public function initTokens(){$this->addTokens(array('=','&ne;'));}

	public function initDomain(){
    							$list_items = 'OBSERVATION_TYPE';
								$sql = "select lower(rv_meaning) as $list_items from cg_ref_codes where rv_domain = 'OSN_TYPE'";
							    $this->AddDomain($sql,$list_items);
    }
    
    public function process($token,$item=false) 
	{
	$tblalias = $this->query->setTable('Observations');
	
    if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	
     $column = $this->query->getColumn('Obs. Type'); // because already created by the searcher
     if(!$item) { return;}
     $this->query->addWhere(array("lower($column )".$token,array($item)));
//	$this->query->addWhere(array($tblalias.'.CONSERVATION_MODE '.$token,array($item)));
    
	}
	
}
class Filter_Observation_Latitude extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'latitude';
			
	}
	
	public function initTokens(){$this->addTokens(array('&gt;','=','&ne;'));}
	
	
	public function process($token,$item1=false,$item2=NULL)
	{
	$table = 'Observations';	
		
	$tbl_alias = $this->query->setTable($table);	
	
	// take the Latitude format into account
	$latitude1 = explode(',',rtrim($item1,','));
	if(!is_null($item2)) {$latitude2 = explode(',',rtrim($item2,','));} 
	                else {$latitude2 = explode(',',rtrim($item1,','));}
	                $bv = $latitude1[0];
	                $t = $latitude1[1];
	$totlatitude1 = $latitude1[0]*3600 + $latitude1[1]*60 + $latitude1[2];
	$totlatitude2 = $latitude2[0]*3600 + $latitude2[1]*60 + $latitude2[2];
	
	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	  if(!$item1 ) { return;}
	switch ( $token ) {
		case 'between';
		  $this->query->addWhere(array('to_number(trim(trailing \',\' from regexp_substr(latitude, \'[^,]+,\', 1,  1)))*3600 + 
       to_number(trim(trailing \',\' from regexp_substr(latitude, \'[^,]+,\', 1,  2)))*60   + 
       to_number(trim(trailing \',\' from regexp_substr(latitude, \'[^,]+,\', 1,  3)))',' between ',array($totlatitude1),'and',array($totlatitude2)));
		                                break;
		default:
	        $this->query->addWhere(array('to_number(trim(trailing \',\' from regexp_substr(latitude, \'[^,]+,\', 1,  1)))*3600 + 
       to_number(trim(trailing \',\' from regexp_substr(latitude, \'[^,]+,\', 1,  2)))*60   + 
       to_number(trim(trailing \',\' from regexp_substr(latitude, \'[^,]+,\', 1,  3))) '.$token,array($totlatitude1)));	
	        break;	
	}
	
	}
	
}

/* Class needed : construct the filter ( join table if needed ), as there is as much filter as search conditions, each one will be an 
		extension of the filter . */
class Filter_Date extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'date';
				
	}
	
	public function initTokens(){ $this->addTokens(array('&gt;','&lt;','=','&ne;'));}
	/**
	 * 
	 *
	 * @param token ( search operator), $item1,$item2 operator values
	 */
    public function process($token,$item1 = false,$item2 = null) 
	{
	

	// Add the table join
    $tbl1_alias = $this->query->setTable('Event_states');
    
	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  
	

    if(!$item1 ) { return;}

    
	$date = $tbl1_alias.".EVENT_DATE";
		
	$this->query->addWhere(array("$date ".$token,array($item1)));
	}
	
}
// FILTER NECROPSIES

class Filter_Date_Necropsy extends BLP_Filter 
{
	 public function initName() 
	 {
	 	$this->name = 'date';
	 			
	 }
	 public function initTokens(){ $this->addTokens(array('between','&gt;','&lt;','=','&ne;'));}
	 public function process($token,$item1 = false,$item2 = null) 
	{
	 $tbl1_alias = $this->query->setTable('Event_states');
    $tbl2_alias = $this->query->setTable('Necropsies');	
    
	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	 $this->query->addJoin($tbl1_alias.'.SEQNO = '.$tbl2_alias.'.ESE_SEQNO');    
	    
    		if(!$item1 ) { return;}	
	switch ( $token ) {
		case 'between';
		  $this->query->addWhere(array(' lower('.$tbl1_alias.'.EVENT_DATE) between to_date(',array($item1),',\'dd/mm/yyyy\') and',
		                                'to_date(nvl(',array($item2),',\'01/01/2900\'),\'dd/mm/yyyy\')'));
		                                break;
		default:
	        $this->query->addWhere(array(' lower('.$tbl1_alias.'.EVENT_DATE) '.$token,' to_date(',array($item1),',\'dd/mm/yyyy\')'));
	        break;	
	}
	

    
   
	}
	
}


// FILTER SPECIMENS

class Filter_Specimen_Taxa extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'taxa';
				
	}
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
	public function process($token = false,$item = false) 
	{
		$alias2 = $this->query->setTable('Taxas');

		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	

		
	// already done in searcher	$this->query->addJoin($tblalias.'.TXN_SEQNO ='.$alias2.'.IDOD_ID');
		
		
    
    	if(!$item ) { return;}
		switch( $token) {
		case "like";
    	$this->query->addWhere(array('lower('.$alias2.'.trivial_name) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($alias2.'.trivial_name '.$token,array($item)));
		break;	}
	}
}


class Filter_Specimen_Date extends BLP_Filter 
{
	 
	public function initName() 
	{
		$this->name = 'date';
				
	}
	public function initTokens(){ $this->addTokens(array('&gt;','&lt;','=','&ne;'));}
	/**
	 * 
	 *
	 * @param token ( search operator), $item1,$item2 operator values
	 */
    public function process($token,$item1=false,$item2 = null) 
	{
	

	// Add the table join
    $tbl1_alias = $this->query->setTable('Event_states');
    $tbl2_alias = $this->query->setTable('Specimens');
    $tbl3_alias = $this->query->setTable('Spec2events');
    
    
	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	


    
    $this->query->addJoin($tbl3_alias.'.SCN_SEQNO = '.$tbl2_alias.'.SEQNO');
    $this->query->addJoin($tbl1_alias.'.SEQNO = '.$tbl3_alias.'.ESE_SEQNO');
    	
    if(!$item1 ) { return;}


	$date = $tbl1_alias.".EVENT_DATE";
		
		$this->query->addWhere(array("$date ".$token,array($item1)));
	
	}
	
}

class Filter_Specimen_Aut_Ref extends BLP_Filter {
	public function initName() 
	{
		$this->name = 'autopsy_reference';
				
	}
	public function initTokens(){ $this->addTokens(array('=','&ne;'));}
	public function process($token,$item=false) 
	{
    $tbl1_alias = $this->query->setTable('Event_states');
    $tbl2_alias = $this->query->setTable('Specimens');
    $tbl3_alias = $this->query->setTable('Spec2events');
	$tbl4_alias = $this->query->setTable('Necropsies');
	
	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 

	
	$this->query->addJoin($tbl3_alias.'.SCN_SEQNO = '.$tbl2_alias.'.SEQNO');
    $this->query->addJoin($tbl1_alias.'.SEQNO = '.$tbl3_alias.'.ESE_SEQNO');
	$this->query->addJoin($tbl1_alias.'.SEQNO ='.$tbl4_alias.'.ESE_SEQNO');	
	
	if(!$item ) { return;}
	$this->query->addWhere(array($tbl4_alias.'.REF_AUT '.$token,array($item)));
	}
}

class Filter_Specimen_Sex extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'sex';
				
	}
	public function initTokens(){ $this->addTokens(array('=','&ne;'));}
	
	public function initDomain(){
    							$this->domain = array('UNK','ML','FM');
    }
	
	public function process($token,$item = false) 
	{
	
	$tblalias = $this->query->setTable('Specimens');

	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then default = first token

	if(!$item ) { return;}
	$this->query->addWhere(array($tblalias.'.SEX '.$token,array($item)));
	
	
	}
	
}

class Filter_Specimen_Number extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'number';
				
	}
	public function initTokens(){ $this->addTokens(array('&gt;','&lt;','=','&ne;'));}
	
	
	public function process($token,$item1=false,$item2 = null) 
	{
	
	$tblalias = $this->query->setTable('Specimens');

	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then default = first token
    
	if(!$item1 ) { return;}
    switch ( $token ) {
		case 'between';
		$this->query->addWhere(array('lower('.$tblalias.'.SCN_NUMBER) '.$token,array($item1),' and nvl(',array($item2),')'));
	break;
    default:
    	$this->query->addWhere(array('lower('.$tblalias.'.SCN_NUMBER) '.$token,array($item1)));
	   break;
    
    }
	
	}
	
}

// FILTERS ORGAN LESIONS 

class Filter_Autopsy_Ref_Organ_Lesions extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'autopsy_reference';
				
	}
	public function initTokens(){ $this->addTokens(array('=','&ne;'));}
	public function process($token,$item =false) 
	{
	$tblalias1 = $this->query->setTable('Necropsies');
	$tblalias2 = $this->query->setTable('Organ_Lesions');
    $this->query->addJoin($tblalias1.'.ESE_SEQNO='.$tblalias2.'.NCY_ESE_SEQNO'); 

    if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	if(!$item) { return;}
	$this->query->addWhere(array($tblalias1.'.REF_AUT '.$token,array($item)));
    
	}
}

class Filter_Ref_Aut_Necropsy extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'Ref_Aut';
		$this->allowedgrouplevel = 3;
				
	}
	public function initTokens(){ $this->addTokens(array('=','&ne;','like'));}
	public function process($token,$item) 
	{
		$tblalias1 =  $this->query->setTable('Necropsies');
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
		
		if(!$item) { return;}
	
		switch( $token) 
		{
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias1.'.REF_AUT) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias1.'.REF_AUT '.$token,array($item)));
		break;	
		}
	}
	
}

/**
 *  Detect the sample id belonging to a specified sample
 *  input seqno : output list of elements from the necropsies searcher
 */
class Filter_Sample_ID_Necropsy extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'Sample_ID';
		$this->allowedgrouplevel = 3;
				
	}
	public function initTokens(){ $this->addTokens(array('=','&ne;','like'));}
	public function process($token,$item) 
	{
		$tblalias1 =  $this->query->setTable('Necropsies');
		$tblalias2 =  $this->query->setTable('Lesions2sample');
		$tblalias3  = $this->query->setTable('Samples');

	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
		
	$this->query->addJoin($tblalias1.'.ESE_SEQNO='.$tblalias2.'.OLN_NCY_ESE_SEQNO');
	$this->query->addJoin($tblalias3.'.SEQNO='.$tblalias2.'.SPE_SEQNO');
	
	if(!$item) { return;}
	
		switch( $token) {
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias3.'.SEQNO) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias3.'.SEQNO '.$token,array($item)));
		break;	}
	
	
	}
}

/**
 *  Detect the autopsy reference belonging to a specified sample
 *  input seqno : output list of elements from the necropsies searcher
 */
class Filter_Sample_Aut_Ref extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'autopsy_reference';
		$this->allowedgrouplevel = 3;
				
	}
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	public function process($token,$item = false) 
	{
		$tblalias1 =  $this->query->setTable('Necropsies');
		$tblalias2 =  $this->query->setTable('Lesions2sample');
		$tblalias3  = $this->query->setTable('Samples');
		
		$this->query->addColumn('Ref_aut',$tblalias1.'.REF_AUT');
	
	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
		
	$this->query->addJoin($tblalias1.'.ESE_SEQNO='.$tblalias2.'.OLN_NCY_ESE_SEQNO');
	$this->query->addJoin($tblalias3.'.SEQNO='.$tblalias2.'.SPE_SEQNO');
	
	if(!$item) { return;}
	
		switch( $token) {
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias1.'.REF_AUT) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias1.'.REF_AUT '.$token,array($item)));
		break;	}
		
	}
}
/**
 * Filter Country 
 * filter needed ( Filter_Sample_Specimen)
 *
 */
class Filter_Sample_Country extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'Country';
		//$this->allowedgrouplevel = 3;
				
	}
	public function initDomain()
	{
								$sql = "select name from places where type = 'CTY'";
							    $this->AddDomain($sql,'NAME');
    }
	public function initTokens()
	{ 
		$this->addTokens(array('=','&ne;'));
	}
	public function process($token,$item = false) 
	{
		$tblalias = $this->query->setTable('Specimens');
		$tblalias2 = $this->query->setTable('MAX_OBS_DATE_SPECIMEN');
		$tblalias3 = $this->query->setTable('OBSERVATIONS_COUNTRY');
		
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
		
		$this->query->addJoin($tblalias.'.SEQNO ='.$tblalias2.'.SCN_SEQNO(+)');
		
		$this->query->addJoin($tblalias2.'.ESE_SEQNO='.$tblalias3.'.OB_SEQNO(+)');
		
		$alias = "Country";
		
		$this->query->addColumn($alias,$tblalias3.'.OB_COUNTRY');
		
		if(!$item) { return;}
     
		

		$this->query->addWhere(array($tblalias3.'.OB_COUNTRY'.$token,array($item)));
	//	$al1.'.SEQNO'
	}
} 
/**
 * Filter the samples based on the date the specimen was 
 * retrieved( the last observation before the autopsy) 
 *
 */
class Filter_Sample_Date_Found extends  BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'Date Found';
	//	$this->allowedgrouplevel = 3;
				
	}
	public function initTokens(){ $this->addTokens(array('&lt;=','&gt;=','=','&ne;'));}
	
	public function process($token,$item=false) 
	{
	   	$tblalias = $this->query->setTable('Specimens');
		$tblalias2 = $this->query->setTable('MAX_OBS_DATE_SPECIMEN');
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 

		$this->query->addJoin($tblalias.'.SEQNO ='.$tblalias2.'.SCN_SEQNO(+)');


		$this->query->addColumn("Date Found",$tblalias2.".EVENT_DATE");
//		
		if(!$item) { return;}
     	
		
//		$where = "$seqno_specimen in (select a.seqno  from specimens a, spec2events b, event_states c
//				  where a.seqno = b.scn_seqno and b.ese_seqno = c.seqno
//                  and c.seqno in (select ese_seqno from observations)
//                  group by a.seqno having max(c.event_date) ";
	
		$this->query->addWhere(array($tblalias2.".EVENT_DATE ".$token,array($item),')'));
	}
}

class Filter_Sample_Ref_Labo extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'reference_labo';
		$this->allowedgrouplevel = 3;
				
	}
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	public function process($token,$item = false) 
	{
		$tblalias1 =  $this->query->setTable('Necropsies');
		$tblalias2 =  $this->query->setTable('Lesions2sample');
		$tblalias3  = $this->query->setTable('Samples');
		
		$this->query->addColumn('Ref_labo',$tblalias1.'.REF_LABO');
	
	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
		
	$this->query->addJoin($tblalias1.'.ESE_SEQNO='.$tblalias2.'.OLN_NCY_ESE_SEQNO');
	$this->query->addJoin($tblalias3.'.SEQNO='.$tblalias2.'.SPE_SEQNO');
	
	if(!$item) { return;}
	
	switch( $token) {
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias1.'.REF_LABO) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias1.'.REF_LABO '.$token,array($item)));
		break;	}
	

		
	}
}
class Filter_Sample_Availability extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'Availability';
		$this->allowedgrouplevel = 3;
	}
	public function initDomain(){
    							$list_items = 'SAMPLE_AVAILABILITY';
								$sql = "select lower(rv_low_value) as $list_items from cg_ref_codes where rv_domain = 'AVAILABILITY'";
							    $this->AddDomain($sql,$list_items);
    }
	public function initTokens(){ $this->addTokens(array('=','&ne;'));}
	
	public function process($token = '<|>',$item = false) 
	{
		$tblalias = $this->query->setTable('Samples');
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
		if(!$item) { return;}
		$column = $tblalias.".AVAILABILITY";
		$this->query->addWhere(array("lower($column )".$token,array($item)));       
	}

}
class Filter_Sample_Seqno extends BLP_Filter
{
	public function initName() 
	{
		$this->name = 'ID';
				
	}
	public function initTokens(){ $this->addTokens(array('in','not in'));}
	public function process($token = '<|>',$item = false) 
	{
		$tblalias = $this->query->setTable('Samples');
	    if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 

	    if(!$item) { return;}
	     
	     
	     
	    $column = $tblalias.".SEQNO";
	    
	    $where = array();
	    $where[]="lower($column) ".$token. "(";
	    $where[] =  array(current($item));
	    next($item);
	    foreach($item as $elem)
	    {
	    	$where[] = ',';
	    	$where[] = array($elem);
	    }
	    $where[] = ')';
	                 
	    // $this->query->addWhere($where);  // bind all variables      
	     $tmp = '('.implode(',',$item).')';    
	     $this->query->addJoin("$column ".$token. " $tmp");
	     
	}
} 

class Filter_Sample_Analyze_Dest extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'Intended Use';
				
	}
	public function initTokens(){ $this->addTokens(array('=','&ne;'));}
	
	public function initDomain(){
    							$list_items = 'ANALYZE_DEST';
								$sql = "select lower(rv_meaning) as $list_items from cg_ref_codes where rv_domain = 'ANALYZE_DEST'";
							    $this->AddDomain($sql,$list_items);
    }
	
	public function process($token = '<|>',$item = false) 
	{
		$tblalias = $this->query->setTable('Samples');
	    if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	     
	     
	     $column = $this->query->getColumn('Intended Use');
	     
	     if(!$column){ 
	     	$this->query->addColumn('Intended Use',$tblalias.'.RV_MEANING');
	        $this->query->addJoin($tblalias.'.RV_DOMAIN = \'ANALYZE_DEST\'');
	        $aliastable3 = $this->query->setTable("Cg_ref_codes","f"); 
	        $this->query->addJoin($tblalias.'.ANALYZE_DEST ='.$aliastable3.'.RV_LOW_VALUE'); 
	        $column = $this->query->getColumn('Intended Use');  
	                 }
	   //  else { $aliastable3 = $this->query->getTableAlias($column);}            
	       if(!$item) { return;}          
	      $this->query->addWhere(array("lower($column )".$token,array($item)));           
	     
	     
	}
	
}

class Filter_Sample_Specimen extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'Taxa';
		
	}
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
	public function process($token = '<|>',$item = false) 
	{
		$tblalias1 = $this->query->setTable('Samples');
		$tblalias2 = $this->query->setTable('Specimens');
		$tblalias3 = $this->query->setTable('Spec2events');
		$tblalias4 = $this->query->setTable('Event_states');
		$tblalias5  = $this->query->setTable('Lesions2sample');
		$tblalias6 = $this->query->setTable('Taxas');
		
		
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	
		
		$this->query->addJoin($tblalias2.'.TXN_SEQNO ='.$tblalias6.'.IDOD_ID');
		$this->query->addJoin($tblalias3.'.SCN_SEQNO = '.$tblalias2.'.SEQNO');
		$this->query->addJoin($tblalias4.'.SEQNO = '.$tblalias3.'.ESE_SEQNO');
		$this->query->addJoin($tblalias4.'.SEQNO='.$tblalias5.'.OLN_NCY_ESE_SEQNO');
		$this->query->addJoin($tblalias5.'.SPE_SEQNO='.$tblalias1.'.SEQNO');
		
       $this->query->addColumn('Taxa',$tblalias6.'.TRIVIAL_NAME');
	   $this->query->addColumn('Idod_id',$tblalias6.'.IDOD_ID');	
		
	   if(!$item) { return;}
		switch( $token) {
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias6.'.TRIVIAL_NAME) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias6.'.TRIVIAL_NAME '.$token,array($item)));
		break;	}
		
		
	}
	
}
class Filter_Order_by_PersonId extends BLP_Filter {
	public function initName() 
	{
		$this->name = 'Person Id';
		
	}
	public function initTokens(){ $this->addTokens(array('=','&ne;'));}
	 
	public function process($token,$item=false) 
	{
		$tblalias = $this->query->setTable('Request_loans');
		$tblalias2 = $this->query->setTable('Persons');
		$tblalias3 = $this->query->setTable('Person2requests');
	
	
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	
		$this->query->addJoin($tblalias2.'.SEQNO ='.$tblalias3.'.PSN_SEQNO');
		$this->query->addJoin($tblalias3.'.RLN_SEQNO ='.$tblalias.'.SEQNO');
		
		if(!$item) { return;}
		
		$seqno = $tblalias2.".SEQNO";
		
		$this->query->addWhere(array("$seqno ".$token,array($item)));
	}
}
class Filter_Order_Return_Date extends BLP_Filter {
		public function initName() 
	{
		$this->name = 'Return Date';
		
	}
    public function initTokens(){ $this->addTokens(array('&lt;','&gt;','=','&ne;'));}
	
    public function process($token,$item=false) 
	{
		$tblalias = $this->query->setTable('Request_loans');
		
		
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
		
		if(!$item) { return;}

		$date = $tblalias.".DATE_RT";
		
		$this->query->addWhere(array("$date ".$token,array($item)));
	}
}
class Filter_Order_Study_Description extends BLP_Filter {
	public function initName() 
	{
		$this->name = 'Study Description';
		
	}
	
	public function initTokens(){ $this->addTokens(array('like'));}
	
	public function process($token = '<|>',$item = false) 
	{
		$tblalias = $this->query->setTable('Request_loans');
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
		
		if(!$item) { return;}

		$date = $tblalias.".STUDY_DESCRIPTION";
		
		$this->query->addWhere(array("$date ".$token,array($item)));
	}
	
}
class Filter_Order_Rent_Date extends BLP_Filter {
		public function initName() 
	{
		$this->name = 'Rent Date';
		
	}
    public function initTokens(){ $this->addTokens(array('&lt;','&gt;','=','&ne;'));}
	
    public function process($token,$item=false) 
	{
		$tblalias = $this->query->setTable('Request_loans');
		
		
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
		
		if(!$item) { return;}

		$date = $tblalias.".DATE_OUT";
		
		$this->query->addWhere(array("$date ".$token,array($item)));
	}
}
class Filter_Order_Req_Date extends BLP_Filter {
	public function initName() 
	{
		$this->name = 'Request Date';
		
	}
    public function initTokens(){ $this->addTokens(array('&lt;','&gt;','=','&ne;'));}
	
    public function process($token,$item=false) 
	{
		$tblalias = $this->query->setTable('Request_loans');
		
		
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
		
		if(!$item) { return;}

		$date = $tblalias.".DATE_REQUEST";
		
		$this->query->addWhere(array("$date ".$token,array($item)));
	}
}
class Filter_Order_by_name extends BLP_Filter {
	public function initName() 
	{
		$this->name = 'Person';
		$this->allowedgrouplevel = 3;
		
	}
    public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
    public function process($token,$item=false) 
	{
		
	$tblalias = $this->query->setTable('Request_loans');
	$tblalias2 = $this->query->setTable('Persons');
	$tblalias3 = $this->query->setTable('Person2requests');
	
	
	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	
	$this->query->addJoin($tblalias2.'.SEQNO ='.$tblalias3.'.PSN_SEQNO');
	$this->query->addJoin($tblalias3.'.RLN_SEQNO ='.$tblalias.'.SEQNO');
	
	if(!$item) { return;}
	
	$first_name = $tblalias2.'.FIRST_NAME';
	$last_name  = $tblalias2.'.LAST_NAME';
	
	 switch( $token) {
		case "like";
    	$this->query->addWhere(array("(lower($first_name ) || lower($last_name)) ".$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array("(lower($first_name ) || lower($last_name)) ".$token,array($item)));
		break;	
    }
	
	
	
	}
}

class Filter_Institute_Code extends BLP_Filter {
	
	public function initName() 
	{
		$this->name = 'Code';
		
	}
	
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
	public function process($token,$item=false) 
	{
		if(!$item) { return;}
		
		$tablealias = $this->query->setTable('Institutes');
		
		$code = $tablealias.'.CODE';
		
		 switch( $token) {
		case "like";
    	$this->query->addWhere(array("(lower($code ) ) ".$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array("(lower($code )) ".$token,array($item)));
		break;	
    }
	}
	
} 


class Filter_Institute_Name extends BLP_Filter {
	
	public function initName() 
	{	
		$this->name = 'Name';
		
	}
	
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
	public function process($token,$item=false) 
	{
		if(!$item) { return;}
		
		$tablealias = $this->query->setTable('Institutes');
		
		$code = $tablealias.'.Name';
		
		 switch( $token) {
		case "like";
    	$this->query->addWhere(array("(lower($code ) ) ".$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array("(lower($code )) ".$token,array($item)));
		break;	
    }
	}
	
}

class Filter_Person_Name extends BLP_Filter {
	
	public function initName() 
	{
		$this->name = 'Name';
		
	}
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	public function process($token,$item=false) 
	{
		if(!$item) { return;}
		
		$tablealias = $this->query->setTable('persons');
		
		$first_name = $tablealias.'.FIRST_NAME';
		$last_name  = $tablealias.'.LAST_NAME';
		
		 switch( $token) {
		case "like";
    	$this->query->addWhere(array("(lower($first_name ) || lower($last_name)) ".$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array("(lower($first_name ) || lower($last_name)) ".$token,array($item)));
		break;	
    }
	}
}

class Filter_Person_Email extends BLP_Filter {
	
	public function initName() 
	{
		$this->name = 'Email';
		
	}
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	public function process($token,$item=false) 
	{
		if(!$item) { return;}
		
		$tablealias = $this->query->setTable('persons');
		
		$first_name = $tablealias.'.EMAIL';
		
		switch( $token) {
		case "like";
    	$this->query->addWhere(array("(lower($first_name ) ) ".$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array("(lower($first_name ) ) ".$token,array($item)));
		break;	
    }
	}
}

class Filter_Sample_Request_Loans_Seqno extends BLP_Filter {
	
	public function initName() 
	{	
		$this->name = 'Loan Seqno';
		
	}

	public function initTokens(){ $this->addTokens(array('=','&ne;'));}

	public function process($token,$item=false) 
	{
		$smple_alias = $this->query->setTable('Samples');
		$request_loans_alias = $this->query->setTable('Request_Loans');
		$smple2requests_alias = $this->query->setTable('Sample2Requests');
		
		$this->query->addJoin($smple_alias.'.SEQNO='.$smple2requests_alias.'.SPE_SEQNO');
		$this->query->addJoin($request_loans_alias.'.SEQNO='.$smple2requests_alias.'.RLN_SEQNO');
		
		if(!$item) { return;}
		$column = $request_loans_alias.'.SEQNO';
		$this->query->addWhere(array("$column ".$token,array($item)));
		
	}
}

class Filter_Sample_Sample_Type extends BLP_Filter {
	public function initName() 
	{
		$this->name = 'Sample Type';
		
	}
    public function initTokens(){ $this->addTokens(array('=','&ne;'));}

    public function initDomain(){
    							$list_items = 'SAMPLE_TYPE';
								$sql = "select lower(rv_meaning) as $list_items from cg_ref_codes where rv_domain = 'SPE_TYPE'";
							    $this->AddDomain($sql,$list_items);
    }
	public function process($token,$item=false) 
	{
	$tblalias = $this->query->setTable('Samples');
	if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	
	$column = $this->query->getColumn('Sample Type');
	
	if(!$item) { return;}
	
	$this->query->addWhere(array("lower($column )".$token,array($item)));
    
	
  
	
	}
}
class Filter_Sample_Conservation_mode extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'Conservation Mode';
		
	}
	public function initTokens(){ $this->addTokens(array('=','&ne;'));}
	public function initDomain(){
    							$list_items = 'CONSERVATION_MODE';
								$sql = "select lower(rv_meaning) as $list_items from cg_ref_codes where rv_domain = 'CONSERVATION_MODE'";
							    $this->AddDomain($sql,$list_items);
    }
	public function process($token,$item=false) 
	{
	$tblalias = $this->query->setTable('Samples');
	
    if(!in_array(($token),$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 
	
     $column = $this->query->getColumn('Conservation Mode'); // because already created by the searcher
     if(!$item) { return;}
     $this->query->addWhere(array("lower($column )".$token,array($item)));
//	$this->query->addWhere(array($tblalias.'.CONSERVATION_MODE '.$token,array($item)));
    
	}
}
/**
 * Based on a user input, the filter returns all matched Samples 
 *
 */
class Filter_Sample_Organs extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'Organ';
		
	}
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
	public function process($token,$item = false) 
	{
    $tblalias = $this->query->setTable('Samples');
  	$tblalias2 = $this->query->setTable('Organs');
  	$tblalias3 = $this->query->setTable('Lesions2sample');
  	   $this->query->addColumn('Organ',$tblalias2.'.NAME');
    if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 

    $this->query->addJoin($tblalias.'.SEQNO='.$tblalias3.'.SPE_SEQNO');
    $this->query->addJoin($tblalias2.'.CODE='.$tblalias3.'.OLN_LTE_OGN_CODE');
    
    if(!$item) { return;}
    
    switch( $token) {
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias2.'.NAME) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias2.'.NAME '.$token,array($item)));
		break;	
    }
    
    
	}
}
class Filter_Sample_Localizations_Type extends BLP_Filter 
{
	public function initName() 
	{
		$this->name = 'localization_type';
		$this->allowedgrouplevel =3;
		
	}
	public function initDomain(){
    							$list_items = 'CONSERVATION_TYPE';
								$sql = "select lower(rv_meaning) as $list_items from cg_ref_codes where rv_domain = 'CONTAINER_TYPE'";
							    $this->AddDomain($sql,$list_items);
    }
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
	public function process($token = '<|>',$item = false) 
	{
		$tblalias = $this->query->setTable('Samples');
		
		// The "connect by" condition must be performed before the joined condition 
		// This is the reason of this table
	
		$tblalias1 = $this->query->setTable('LOCALISATIONS_V');

		$this->query->addColumn('Container Type',$tblalias1.'.container_type');
		$this->query->addColumn('Name',$tblalias1.'.name');
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 

		
		$this->query->addJoin($tblalias1.'.id_init ='.$tblalias.'.CLN_SEQNO');
		
		if(!$item) { return;}
		
		switch( $token) {
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias1.'.container_type) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias1.'.container_type '.$token,array($item)));
		break;	
    }
		
		
	}
	
}
/**
 * Filter the samples by localization id, 
 * 
 * If the filter id is equivalent to institute RBINS, than all samples located in the institute will be displayed 
 * 
 */
class Filter_Sample_Localizations_Seqno extends BLP_Filter 
{
	public function initName() 
	{
	$this->name = 'localization seqno';
	$this->allowedgrouplevel = 3;
	}
	public function initTokens(){ $this->addTokens(array('=','&ne;'));}
	
	public function process($token = '<|>',$item = false) 
	{
			$tblalias = $this->query->setTable('Samples');
		
		
		$whereclause = "select seqno from container_localizations where name !='ROOT'
					connect by nocycle prior seqno =  cln_seqno
					start with seqno";
		
		$this->query->addColumn('Container Localization',$tblalias.'.CLN_SEQNO');
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 

		if(!$item) { return;}
		
	
		$this->query->addWhere(array($tblalias.'.CLN_SEQNO in ( ',$whereclause,' ', $token,' ',array($item),')'));

	
	}
}

class Filter_Taxa_Taxa extends BLP_Filter 
{
	public function initName() 
	{
	$this->name = 'Taxa';
//	$this->allowedgrouplevel = 3;
	}

	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
	public function process($token = '<|>',$item = false) 
	{
		$tblalias1 = $this->query->setTable('Taxas');
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 

		if(!$item) { return;}
		
		switch( $token) 
		{
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias1.'.TAXA) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias1.'.TAXA '.$token,array($item)));
		break;	
        }
	}
}

class Filter_Taxa_Idod_Id extends BLP_Filter 
{
	public function initName() 
	{
	$this->name = 'Idod Id';
//	$this->allowedgrouplevel = 3;
	}

	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
	public function process($token = '<|>',$item = false) 
	{
		$tblalias1 = $this->query->setTable('Taxas');
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 

		if(!$item) { return;}
		
		switch( $token) 
		{
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias1.'.IDOD_ID) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias1.'.IDOD_ID '.$token,array($item)));
		break;	
        }
	}
}

class Filter_Taxa_Trivial_Name extends BLP_Filter 
{
	public function initName() 
	{
	$this->name = 'Trivial Name';
//	$this->allowedgrouplevel = 3;
	}

	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
	public function process($token = '<|>',$item = false) 
	{
		$tblalias1 = $this->query->setTable('Taxas');
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 

		if(!$item) { return;}
		
		switch( $token) 
		{
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias1.'.TRIVIAL_NAME) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias1.'.TRIVIAL_NAME '.$token,array($item)));
		break;	
        }
	}
}

/**
 * The filter is of interest since it searches through all elements of the hierarchy
 * i.e a sample contained in the box - 31 will be found if the search element is the name Ulg  
 *  Institute Ulg -- box 31
 */
class Filter_Sample_Localizations_Name extends BLP_Filter 
{
	public function initName() 
	{
	$this->name = 'localization_name';
	$this->allowedgrouplevel = 3;
	
	}
	public function initTokens(){ $this->addTokens(array('like','=','&ne;'));}
	
	public function process($token = '<|>',$item = false) 
	{
			$tblalias = $this->query->setTable('Samples');
		
		// The "connect by" condition must be performed before the joined condition 
		// This is the reason of this table
		$tbl_def = 'select connect_by_root b.seqno as id_init,container_type,name
					from container_localizations b
					where name !=\'ROOT\'
					connect by nocycle b.seqno = prior b.cln_seqno
					start with b.seqno in  ( select cln_seqno from samples)';
		
		$tblalias1 = $this->query->setTable($tbl_def);
		$this->query->addColumn('Container Type',$tblalias1.'.container_type');
		$this->query->addColumn('Name',$tblalias1.'.name');
		
		if(!in_array($token,$this->tokens)){ $token = $this->tokens[0];}  // if the operator is unknown, then choose the first one 

		$this->query->addJoin($tblalias1.'.id_init ='.$tblalias.'.CLN_SEQNO');
		
		if(!$item) { return;}
		
		switch( $token) 
		{
		case "like";
    	$this->query->addWhere(array('lower('.$tblalias1.'.name) '.$token.' lower(',array("%$item%"),')'));
    	break;
		default:
		$this->query->addWhere(array($tblalias1.'.name '.$token,array($item)));
		break;	
        }
			
	}
}
?>