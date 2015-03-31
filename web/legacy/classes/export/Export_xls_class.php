<?php
/**
 * 	Class Export XLS v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:12/01/2010 
 * 
 */
//require_once(Classes.'export/Export_interface.php');

class Export_XLS extends Export_File implements Export
{
	
	
 	public $row = 0;
 	
 	public function __construct()
 	{
 		$this->file = $this->__BOF();
 		$this->extension = '.xls';
 	}
 	/**
 	 * BOF : Begin Of FIle
 	 *
 	 * @return excel packed begin of file
 	 */
 	public function __BOF()
 	{
 		return pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
 	}
 	public function __EOF()
 	{
 		 return pack("ss", 0x0A, 0x00);
 	}

    public function WriteCell($value,$row,$col) 
    {
      if(is_numeric($value)) 
      {
         $this->file .= pack("sssss", 0x203, 14, $row, $col, 0x0);
      	 $this->file .= pack("d", $value);
      }
      elseif(is_string($value)) 
      {
    	 $this->file .= pack("ssssss", 0x204, 8 + strlen($value), $row, $col, 0x0, strlen($value));
       	 $this->file .= $value;
      }
   }
   
   public function AddRow(Array $data,$row = Null)
   {
   	
   	 $data = array_values($data);	
      if(!isset($row)) 
      {
         $row = $this->row;
         $this->row++;
      }
      for($i = 0; $i<count($data); $i++) 
      {
         $cell = $data[$i];
         $this->writeCell($cell,$row,$i);
      }
   }

   public function Download($filename) 
   {
 	  parent::SendHeader($filename); 	
      echo $file = $this->file.$this->__EOF();
   }
   

}



?>
