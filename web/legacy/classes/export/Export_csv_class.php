<?php
/**
 * 	Class Export CSV v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:12/01/2010 
 * 
 */
//require_once(Classes.'export/Export_interface.php');

class Export_CSV extends Export_File implements Export 
{
	protected $col_delimiter;
	
	protected $row_delimiter;
	
	public function __construct($col_delimiter = ',',$row_delimiter = "\n ")
	{
		$this->row_delimiter = $row_delimiter;
		$this->col_delimiter = $col_delimiter;
		$this->extension = ".csv";
		$this->ContentTransferEncoding = "vnd.ms-excel";
		
	}
	
	
	 public function AddRow(Array $data,$row = Null)
	 {
		$data = array_values($data);

		$this->file[] = implode($this->col_delimiter,$data);
		
	 }
	 
	  public function Download($filename) 
	  {
	  		parent::SendHeader($filename);
	  		foreach($this->file as $test)
	  		{
	  			echo $test.$this->row_delimiter; // double quotes is imperative
	  		}
	  		
	  }
}