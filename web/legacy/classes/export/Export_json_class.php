<?php
/**
 * 	Class Export JSON v1.0.0
 *  Author: De Winter Johan  
 *  To be Done
 *  Last Modified:12/01/2010 
 * 
 */
//require_once(Classes.'export/Export_interface.php');

class Export_JSON extends Export_File implements Export 
{
	protected $col_delimiter;
	
	protected $row_delimiter;
	
	
	public function AddRow(Array $data,$row = Null)
	 {
	 
			
	 }
	 
	  public function Download($filename) 
	  {
	  		parent::SendHeader($filename);
	  		
	  }
}