<?php
/**
 * 	Class Export XML v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:12/01/2010
 * 
 */
//require_once(Classes.'export/Export_interface.php');

class Export_XML extends Export_File implements Export 
{
	protected $col_delimiter;
	
	protected $row_delimiter;
	
	public function __construct($col_delimiter = ',',$row_delimiter = "\n ")
	{
		$this->row_delimiter = $row_delimiter;
		$this->col_delimiter = $col_delimiter;
		$this->extension = ".xml";
		$this->ContentTransferEncoding = "binary";
		
		
	}
	public function __BOF($filename)
	{
		return '<?xml version="1.0" encoding="UTF-8" ?>'."\n"."<$filename>";
		
	}
	public function __EOF($filename)
	{
		return "</$filename>";
	}
	/**
	 * Add Row to the file beeing outputted. 
	 * key data = variable  
	 * value data = variable value
	 * @param array $data
	 * @param string $row
	 */
	public function AddRow(Array $data,$row = Null)
	 {
	 	foreach($data as $key => $value)
	 	{
		$this->file .= "<$key>$value</$key>\n";
	 	}
			
	 }
	 
	  public function Download($filename) 
	  {
	  		parent::SendHeader($filename);
	  		echo $this->__BOF($filename).str_replace(" ","_",$this->file).$this->__EOF($filename);
	  		
	  }
}