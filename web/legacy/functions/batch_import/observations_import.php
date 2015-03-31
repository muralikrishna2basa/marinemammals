<?php

/**
 *  Batch - one time import observations
 *  connect to Access database 
 *  connect to Oracle database 
 */

/**
 *  Error 'type'=>'column id that causes the problem'
 *  Error = array('observation id'=>'',
 *                'description'=>'',
 *                 'column name'=>'',
 *                  'column id'=>'');
 * 
 */
class Error
{	
	
	public $observation_id = array();
	public $description = array(); 
	public function __construct(){ }
	public function AddError($id,$description)
	{
		$this->observation_id[] = $id;
		$this->description[] = $description;
		echo 'ROW ID :   '.$id.' Description :   '.$description.'<br>'; 
	}

	
}

$Error = new Error();

/**
 *  Conversion data's 
 */

$date_flag_convert = array('Acceptable'=>'1',
					'Date suspect'=>'2',
					'Date missing'=>'9');			
			

$sex_convert = array('M'=>'ML',
					 'F'=>'FM',
					 'U'=>'UNK');
					 
$cause_of_death_convert = array('N'=>'N',
						'O'=>'O',
						'PB'=>'PB',
						'U'=>null,
						'B'=>'B');					 					
					
/**
 *  Table definitions 
 */
$specimens_ora = array('SCN_NUMBER',
					    'SEX',
					    'RBINS_TAG',
					    'TXN_SEQNO',
					    'MUMMTAGSERIE',
					    'MUMMTAG',
					    'SPECIE_FLAG');

/**
 *  Access & Oracle connections 
 */

// Access databae
$dbAc =  odbc_connect('zeezoogdieren','','');
require_once('../../classes/db/Oracle_class.php');
//development database
$dbOr = new ORACLE('BIOLIB_OWNER','BIOLIB123','BIOLIBD.mumm.ac.be');

// get autopsies in database 

$sql = 'select ref_aut from necropsies';
$rsOr = $dbOr->query($sql);
if($rsOr->isError()){ exit('select ref_aut from necropsies');}
$results = $rsOr->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
$autopsies = $results['REF_AUT']; // list of autopsies

// browse observations table

$sql = "select * from observations";
$rsAc = odbc_exec($dbAc,$sql);

if(!$rsAc){ exit('Error in sql');}


while($row = odbc_fetch_array($rsAc)) // foreach observation 
{
	
	// Get list of already registered observations id in oracle database 
	$sql = "select ID_ACCESS_TMP from observations";
	$rsOr = $dbOr->query($sql);
	if($rsOr->isError()){ exit('Error in sql');}
	$results = $rsOr->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
	$access_tmp_id = $results['ID_ACCESS_TMP'];
	
	if(is_array($access_tmp_id) && in_array($row['ID'],$access_tmp_id))
	{
		continue; // nothing to be done since, this observation is already entered in the database
	}
	// Register new Event
	
	$date = $row['Date'];
	
	$dateflag = $date_flag_convert[$row['DateFlag']];
	
	if($dateflag == null) { $dateflag = 2;} // so that it's never null, 
	
	$dateformat = 'yyyy-mm-dd hh24:mi:ss';
	
	$comments = str_replace('\'','',$row['Comments']);
	
	$sql = "insert into event_states(date_flag,event_date,description) values('$dateflag',to_date('$date','$dateformat'),'$comments')";
	
	$dbOr->query($sql);
	if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
	
// Get Newly created event
	$sql = "select cc_next_value - cc_increment as event_state from cg_code_controls
			where cc_domain = 'ESE_SEQ'";
	
	$res = $dbOr->query($sql);
	if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
	
	$results = $res->fetch();
	$event_state = $results['EVENT_STATE']; 
	
	// If applicable, link animals to previously entered one. -- ( autopsy indicator)  
	
	$autopsy_reference = $row['AutopsyReference'];

// IT IS NEEDED TO UPDATE THIS FIELD : 	in_array($autopsy_reference,$autopsies) 
	
	if($autopsy_reference != null && in_array($autopsy_reference,$autopsies))
	{
		// get animal necropsied
		$sql = <<<EOD
select a.seqno, e.idod_id,c.seqno as NEC_SEQNO from specimens a,
                  spec2events b,
                  event_states c, 
                  necropsies d, taxas e
             where a.seqno = b.scn_seqno
             and   c.seqno = b.ese_seqno
             and   d.ese_seqno = c.seqno
             and  a.txn_seqno = e.idod_id
             and   d.ref_aut = '$autopsy_reference'
EOD;
    
	$res = $dbOr->query($sql);
	if($dbOr->isError()){echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
	
	$result = $res->fetch();

	$idod_id = $result['IDOD_ID'];
	$animal_seqno = $result['SEQNO'];
	$ref_aut = $result['NEC_SEQNO'];
	
	// check that the same animal is retrieved between autopsy and observation
	
	if($idod_id != $row['Species'])
	{
		$Error->AddError($row['ID'],'Species mismatch between observation & autopsy');
	}
	
	// link specimen to the newly created event
	
	$sql = "insert into spec2events (scn_seqno,ese_seqno) values ('$animal_seqno','$event_state')";
	$dbOr->query($sql);
	if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
	
	// Add global parameter blubber thickness to the specimen attached to the corresponding necropsy event
	
	$blubber_thikness = $row['BlubberThickness'];
	
	if($blubber_thikness!=null)
	{
		$parameter_method_id = '8';
		$value_flag = '1'; // no indication - so good value assumed
		
		
		$sql = "insert into specimen_values(PMD_SEQNO,S2E_ESE_SEQNO,S2E_SCN_SEQNO,VALUE,VALUE_FLAG) values
		        ('$parameter_method_id','$ref_aut','$animal_seqno',$blubber_thikness,$value_flag)"; 
		$dbOr->query($sql);
		if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
		
	}
	
	$animal = $animal_seqno;
	}
	else // create new specimen, link the newly created specimen to the event 
	{
		$number_specimen = $row['NrOfAnimals'];
		$specie_id = $row['Species'];
		$specie_flag  = '1'; // in the access database this parameter is not set, so let assumes an acceptable value.
		
		$sex = $sex_convert[$row['Sex']];
		$rbins_tag = $row['RBINSTag'];
		$mumm_tag =$row['MUMMTag'];
		$mumm_tagserie = $row['MUMMTagSerie'];
		
		// check that specie_id is defined in oracle ( if not then create it and specify a dumb taxa)
		
		$sql = 'select idod_id from taxas';
		
		$r = $dbOr->query($sql);
		if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
		$res = $r->fetchAll(OCI_FETCHSTATEMENT_BY_COLUMN);
		$idod_ids = $res['IDOD_ID'];
		
		
		if(!in_array($specie_id,$idod_ids))
		{
			// record error, insert new id in database 
			
			$sql = "insert into taxas(idod_id,taxa) values ($specie_id,'created_obs')";
			$dbOr->query($sql);
			if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
			
			$Error->AddError($row['ID'],'Specie Not already in database, created new one');
		}
		
		$sql = "insert into specimens(SCN_NUMBER,SEX,RBINS_TAG,SPECIE_FLAG,TXN_SEQNO,MUMMTAGSERIE,MUMMTAG)
				values('$number_specimen','$sex','$rbins_tag','$specie_flag','$specie_id','$mumm_tagserie','$mumm_tag')";
		
		$dbOr->query($sql);
		if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
		
		// Get Newly Specimen ID
		$sql = "select cc_next_value - cc_increment as specimen_seqno from cg_code_controls
			where cc_domain = 'SCN_SEQ'";
	
	$res = $dbOr->query($sql);
	if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
	
	$results = $res->fetch();
	$specimen_seqno = $results['SPECIMEN_SEQNO']; 
		
	// link the newly created specimen to the newly created event 
	$sql = "insert into spec2events (scn_seqno,ese_seqno) values ('$specimen_seqno','$event_state')";
	$dbOr->query($sql);
	if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
	
	// set animal and event
	$animal = $specimen_seqno;
	
	}
	
	
	// $animal and $event_state define the animal under investigation
	
	
	// Set the global parameters attached to the animal and the corresponding observation 
	
	
	/*
		PARAMETER ( CAUSE OF DEATH)
	*/
	$cause_of_death = $cause_of_death_convert[$row['CauseOfDeath']];
	if($cause_of_death!=null)
	{
		$cause_of_death_PM = '9';
	
		if($cause_of_death == 'PB') 
		{
			$cause_of_death = 'B';
			$value_flag = '2';
		}
		else
		{
			$value_flag = '1';
		}
	
		$sql = "insert into specimen_values( PMD_SEQNO,S2E_ESE_SEQNO,S2E_SCN_SEQNO,VALUE,VALUE_FLAG) values
				('$cause_of_death_PM','$event_state','$animal','$cause_of_death','$value_flag')";
	
		$dbOr->query($sql);
		if($dbOr->isError()){echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}
	}
	
	/*
		PARAMETER ( WEIGHT)
	*/
	
	$weight = $row['Weight'];
	
	if($weight != null)
	{
		$weight_PM = '10';
		$value_flag = '1';
	
		$sql = "insert into specimen_values( PMD_SEQNO,S2E_ESE_SEQNO,S2E_SCN_SEQNO,VALUE,VALUE_FLAG) values
				('$weight_PM','$event_state','$animal','$weight','$value_flag')";
	
		$dbOr->query($sql);
		if($dbOr->isError()){echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}	
	}
	
	/*
		PARAMETER ( LENGTH)
	*/
	
	$length = $row['Length'];
	if($length !=null)
	{
		$length_PM = '1';
		$value_flag = '1';

		$sql = "insert into specimen_values( PMD_SEQNO,S2E_ESE_SEQNO,S2E_SCN_SEQNO,VALUE,VALUE_FLAG) values
				('$length_PM','$event_state','$animal','$length','$value_flag')";
	
		$dbOr->query($sql);
		if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}	

	}
	
	/*
		PARAMETER ( DECOMPOSITION CODE)
	*/
	$decomposition_code = $row['DecompCode'];
	
	if($decomposition_code!=null)
	{
		$decomposition_code_PM = '11';
		$value_flag = '1';
		$decomposition_details = str_replace('\'','',$row['DecompDetails']);
	
		$sql = "insert into specimen_values( PMD_SEQNO,S2E_ESE_SEQNO,S2E_SCN_SEQNO,VALUE,VALUE_FLAG,DESCRIPTION) values
				('$decomposition_code_PM','$event_state','$animal','$decomposition_code','$value_flag','$decomposition_details')";
	
		$dbOr->query($sql);
		if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}	
	}
	// Insert new Observation record 
	
	$latDegree = $row['LatDegrees'];
	$latMin = $row['LatMin'];
	$longDegree = $row['LonDegrees'];
	$longMin = $row['LonMin'];
	
	$latitude = $latDegree.'/'.$latMin;
	$longitude = $longDegree.'/'.$longMin; 
	
	
	$professional_beach  = $row['Professional'];
	$professional_beach_unk = $row['Professional ?'];
	$recreational_beach = $row['Recreational beach'];
	$recreational_beach_unk = $row['Recreational beach ?'];
	$unknown = $row['Unknown'];
	$osn_type = $row['Circumstances'];
	
	$weather = $row['Weather'];
	
	$WebCommentsEN = $row['WebCommentsEN'];
	
	$WebCommentsFR = $row['WebCommentsFR'];
	
	$WebCommentsNL = $row['WebCommentsNL'];
	$rowid = $row['ID'];
	$sql = "insert into observations(ese_seqno,
									 osn_type,
									 latitude,
									 longitude,
									 precision_flag,
									 id_access_tmp,
									 webcomments_en,
									 webcomments_fr,
									 webcomments_nl
									 ) values ('$event_state',
									 '$osn_type',
									 '$latitude',
									 '$longitude',
									 '2',
									 '$rowid',
									 '$WebCommentsEN',
									 '$WebCommentsFR',
									 '$WebCommentsNL'
									 )";
	
	$dbOr->query($sql);
	if($dbOr->isError()){ echo 'ID:  '.$row['ID'].' description : '.$dbOr->errormessage().'<br>'.' SQL'.$sql; return;}	
	
	
}







?>