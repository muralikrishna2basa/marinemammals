<?php
/**
 * 	Class Session  v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Session 
{

	public function __construct()
	{ 
		return session_start();  // return true if the session has successfully been started 
	}
    
	public function set($name,$value)
	{
		$_SESSION[$name] = $value;
	}

    public function get($name)
    {

    	if(isset($_SESSION[$name]))
    	{
    		return $_SESSION[$name];
    	}
    	else { return false;}
    	
    }

    public function del($name)
    {
     unset($_SESSION[$name]);	
    }

    public function destroy()
    {
    	$_SESSION = array();
    	session_destroy();
    	session_regenerate_id();
    	
    }

}
?>