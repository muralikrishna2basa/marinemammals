<?php
/**
 *    Validation Class
 *    
 * 
 */
//    Debugging tests
//
//$val = new Validation();
//$elname = 'test';
//
//$elvalue = '';
//
//
//$val->set($elname,$elvalue,'required');
//
//echo $val->get($elname);
//
class Validation 
{
	protected $status;
	
	public $elements = array();
	
	public $isError;
	
	public $errormessage;
	
	public $NBRConditions;
	
	public $NBRVerifConditions;
	
	public function __construct()
	{
		$this->status = false; // false by default
		$this->isError = false;
		$this->errormessage = "";
		$this->NBRConditions = 0;
		$this->NBRVerifConditions = 0;
	}

	/**
	 * Check that the value has already been submitted
	 *
	 * @param mixed $elvalue
	 * @return bool
	 */
	protected function checksubmit($elvalue)
	{
			if(!isset($elvalue)){
			
				$this->status = false;
				return true;
							   }
	        

			if(is_array($elvalue))
			{
				foreach($elvalue as $val)
				{
					if(!isset($val)){ $this->status = false;return true;}
				}
			}				   
							     
		return false;
	}

	public function set($elname,$elvalue,$methodname,$message = false)
	{
        if(is_array($methodname)) {
            $a=5;
        }
		if(method_exists($this,$methodname))
		{    
			$this->NBRConditions +=1; // add Condition
			
			if($this->checksubmit($elvalue)){ return "";}
			
			$elresponse = $this->$methodname($elvalue,$message);		
			if(!is_string($elresponse))
			{ 	$this->NBRVerifConditions +=1;
				$elresponse = ""; 
			}	// if checked conditions => add
            
			if($this->NBRConditions == $this->NBRVerifConditions)
			{ $this->status = true;}
			else 
			{ $this->status = false;}
				   
			$this->elements[$elname][] = $elresponse;
		}
		else 
		{
			$this->isError = true;
			$this->errormessage = "Method doesn't exist";
			return false;
		}
	}
	
	public function getError($elname)
	{
		if(array_key_exists($elname,$this->elements))
		{
			foreach($this->elements[$elname] as $element)
			{
				if($element !='') { return $element;} // return one of the error
			}
			return "";
		}
		else 
		{
			return false;
		}
	}
	/**
	 * Check if the validation rule succeeded ( true if succeeded false otherwise)
	 *
	 * Used if a custom error rendering is needed. 
	 * 
	 * @param mixed $elname
	 * @return bool
	 */
	public function check($elname)
	{
		if(array_key_exists($elname,$this->elements))
		{
			if(!is_array($this->elements[$elname]))
			{
				return true;
			}
			else 
			{
				return false;
			}
		}
		else 
		{
			return false;
		}
	}
	/**
	 * Accept both string & array, if array => error if all array elements are not set
	 *
	 * @param array,string $el
	 * @param string $message
	 * @return true or message error
	 */
	protected function required($el,$message= false)
	{

		if(is_string($el)){ $el = array($el);}
		$param = 0;
		foreach($el as $elem)
		{
			if(is_null($elem)  || (is_string($elem) && strlen($elem)==0) || (is_array($elem) && next($elem)=='') )
			{
				$param +=1;
			}
		}
		if(count($el) == $param)
		{
			$this->status = false;
			return "<span class='error'>".($message == false?'element required':$message)."</span>";
		}
		else 
		{
			return true;
		}	
	}

	protected function notinit($el,$message = false)
	{
		if(is_string($el) && $el == 'init')
		{
			$this->status = false;
			return "<span class='error'>".($message == false?'element required':$message)."</span>";
		}
	}	
	
	protected function notChoose($el,$message = false)
	{
		if(is_string($el) && $el == 'Choose')
		{
			$this->status = false;
			return "<span class='error'>".($message == false?'element required':$message)."</span>";
		}
	}
	protected function isnumeric($el,$message= false)
	{

		if(!is_numeric($el))
		{
			$this->status = false;
			return "<span class='error'>".($message == false?'element must be numeric':$message)."</span>";
		}
		else 
		{
			return true;
		}
	}
	
	protected function checkdate($el,$message = false)
	{
		$months =array('january','february','march','april','may','june','july','august','october','november','december');

		if(
			!is_array($el) || 
			count($el)!=3 || 
			!is_string($el[0]) ||
			!is_string($el[1]) ||
			!is_string($el[2]) ||
			strlen($el[0])<4 ||
			(current(array_keys($months,$el[1])) == false && current(array_keys($months,$el[1]))!=0) || 
			!checkdate(current(array_keys($months,$el[1]))+1,$el[2],$el[0])
			
			)
		{
			$this->status = false;
			return "<span class='error'>".($message == false?'Wrong date':$message)."</span>";
		}
		else 
		{
			return true;
		}
	}
	public function setStatus($status = false)
	{
		if(is_bool($status)){ $this->status = $status;}
	}
	public function getStatus()
	{
	//	if(isset($_POST) && count($_POST)>0 && $this->NBRConditions == 0){ $this->status = true;}
		
		return $this->status;
	}
	public function setError($errorname,$errormessage='')
	{
		if(strlen($errorname)==0) { return false;}
		
		$this->status = false;
		$this->elements[$errorname][] = $errormessage;
	}
	public function getValue($elname)
	{
		return isset($_POST[str_replace(' ','_',$elname)])?$_POST[str_replace(' ','_',$elname)]:'';
	}
}


?>