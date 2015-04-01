<?php
/**
 * Export interface
 *  
 *  Author: De Winter Johan 
 *  Last Modified:12/01/2010 
 */

require_once('Export_json_class.php');
require_once('Export_xls_class.php');
require_once('Export_xml_class.php');
require_once('Export_html_class.php');
require_once('Export_csv_class.php');



interface Export
{
	public function Download($filename);
	public function AddRow(Array $data,$row = Null);
}

class Export_File
{
	public $file;
	
	public $extension;
	
	public $ContentTransferEncoding = 'binary';
	
	public function SendHeader($filename) 
	{
	  header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");;
      header("Content-Disposition: attachment;filename=".$filename.$this->extension);
      header("Content-Transfer-Encoding: $this->ContentTransferEncoding ");
	}
}

class Exports 
{
	/**
	 * 
	 * (key,value) = (name,classname) 
	 *
	 * @var array
	 */
	protected $classes;
	
	protected $exfile = false;
	
	public function __construct()
	{
		$this->classes = array('XLS'=>'Export_XLS',
							    'XML'=>'Export_XML',
							    'CSV'=>'Export_CSV');
	}
	
	public function loadClass($classname)
	{
		if(class_exists($this->classes[$classname]))
		{
			
			$class = new $this->classes[$classname]();
			if($class instanceof Export_File)
			{
				return $class;
			}
			else 
			{
				return false;
			}
		}
		return false;
	}
	
	public function setExfile($exfile)
	{
		if(is_string($exfile) && count($exfile)>0)
		{
			$this->exfile = $exfile;
		}
		else 
		{
			return false;
		}	
	}
	
	public function __toString()
	{
		if($this->exfile == false){ return '';}
		
		$options = array_keys($this->classes);
		
		$options_s = '<option>'.implode('</option><option>',$options).'</option>';
		
		$test = <<<EOD
		<form method="POST" action='$this->exfile'>
		<button type="submit" name="testsubmit">Download</button>
		<select name="download_format">$options_s</select>
		</form>
EOD;
		return $test;
	}
	
}
?>