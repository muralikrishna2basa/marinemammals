<?php

/**
 * 	Class Sample v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 */  

require_once(Functions.'Fixcoding.php');

class Sample
{
	/**
	 * Database ressource
	 *
	 * @var oracle
	 */
	private $db;
	/**
	 *  Locate precisely the sample, 
	 *  key = (container_type) value = ( container_value) 
	 * @var array
	 */
	private $location = array();
	
	/**
	 * Unique identifier of the sample ( seqno)
	 *
	 * @var int
	 */
	private $sample = null;
	
	private $isError = false;
	
	private $errormessage;
	
	/**
	 *  Contain all the informative content related to the sample 
	 *  i.e type, analyze dest..  info = array( analyze_dest => microbiologie)
	*/
	protected $infos = array();
	/**
	 * specify the list of organs the sample contain
	 * array(lung,...)
	 * @var unknown_type
	 */
	protected $organs = array(); 
	
	
	public function __construct(ORACLE $db,$sample = null)
	{
		$this->db = $db;
		
		if($sample !=null)
		{
		if(!$this->isValid($sample)){ return false;}
		$this->sample = $sample;
		 $this->locate();		
		$this->setInfos();
		$this->setOrgans();
		}
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
	protected function locate($sample = null)
	{
		if($sample == null) { $sample = $this->sample;}
		else { if(!$this->isValid($sample)){ return false;} }
		$sql = "select connect_by_root b.seqno as id_init,container_type,name
					from container_localizations b
					where name !='ROOT'
					connect by b.seqno = prior b.cln_seqno
					start with b.seqno in  ( select cln_seqno from samples where seqno = $sample)";
		
		$r = $this->db->query($sql);
		
		if($this->db->isError())
		{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}	
		
		while($res = $r->fetch())
		{
			$this->location[$res[strtoupper('container_type')]] = $res[strtoupper('name')]; 
		}
		return $this->location;
	}
	/**
	 * 
	 * @return ( bool, false => error, true => job done )
	 */
	protected function setInfos()
	{
	// build the query for the sample under investigation 	

	if(count($this->infos) > 0 || count($this->organs) > 0 ) 
	{ $this->isError = true;$this->errormessage = "infos already determined ";return false;}
	
	$sql = <<<EOD
select 
distinct
       a.availability "Availability", 
       d.RV_MEANING "Conservation Mode",
       c.RV_MEANING "Analyze Dest",
       b.RV_MEANING "Organ Type", 
       f.ref_aut "Ref aut",
       f.ref_labo "Ref Labo",
       i.taxa "taxa",
       h.sex "sex",
       j.name "Organ"

from 
(samples) a,
(cg_ref_codes) b,
(cg_ref_codes) c,
(cg_ref_codes) d,
(lesions2sample) e,
(necropsies) f,
(spec2events) g,
(specimens) h,
(taxas) i,
(organs) j
where b.RV_DOMAIN = 'SPE_TYPE'
and   c.RV_DOMAIN = 'ANALYZE_DEST'
and   d.RV_DOMAIN = 'CONSERVATION_MODE'
and   b.RV_LOW_VALUE = a.spe_type
and   c.RV_LOW_VALUE = a.analyze_dest
and   d.RV_LOW_VALUE = a.conservation_mode
and  f.ese_seqno     = e.oln_ncy_ese_seqno
and e.spe_seqno     = a.seqno
and g.ese_seqno     = f.ese_seqno
and g.scn_seqno   = h.seqno 
and h.txn_seqno  = i.idod_id
and j.code = e.oln_lte_ogn_code
and a.seqno = :seqno
EOD;
	$bind = array(':seqno'=>$this->sample);
	
	$r = $this->db->query($sql,$bind);
	
	if($this->db->isError())
		{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}	

	$r = $r->fetch();	
	$this->infos +=$r; 	
	
	}
	
 protected function setOrgans() 
 {
 	$sql = <<<EOD
	select b.name as name
	from (lesions2sample) a, (organs) b
	where b.code = a.oln_lte_ogn_code
	and spe_seqno = $this->sample	
EOD;
	
 	$r = $this->db->query($sql);
 	
 	if($this->db->isError())
		{ $this->isError = true; $this->errormessage = $this->db->errormessage();return false;}
	while($row = $r->fetch())
	{
		$this->organs[] = $row['NAME'];
	}		
 }
 
 public function render($list)
 {
 		$render_body = '<tbody>';
		$ini = true;
		foreach($list as $item) 
		{   
			$sample = new Sample($this->db,$item);
			if($sample !=false) // if the person is valid
			{   
				if($ini == true)
				{ 
					$ini = false; 
					$render_header = "<thead><tr><td>".implode('</td><td>',array_keys($sample->infos))."</td></tr></thead>";
				}
				$render_body .='<tr><td>'.implode('</td><td><p>',fixEncoding(array_values($sample->infos))).'</p></td></tr>';			
			}
		}
		$render_body .= '</tbody>';
		
		return "<table>$render_header $render_body </table>";
 }

 public function getOrgans() { return $this->organs;} 
 public function getAttributes() { return $this->infos;} 
 public function getlocation(){ return $this->location;}
public function getSample() { return $this->sample; }	
	
	
}
?>