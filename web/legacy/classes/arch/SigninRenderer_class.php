<?php
/**
 * 	Class Signin_Renderer v1.0.0
 *  Author: De Winter Johan  
 *  Last Modified:23/12/2009 
 * 
 */
class Signin_Renderer 
{
	protected $islogged = false;
	
	public $csslink;
	
	protected $action;
	
	protected $signout="";
	
	protected $signname="";
	
	protected $accountmaintenance;
	
	public $signedout;
	
	public $errormessage = "";
	
	
	public function __construct($csslink,$action,$signout,$accountmaintenance)
	{
			if($csslink!=false)
			{
				$this->csslink = $csslink;
			}
			if($action == false )
			{
				$this->action = $_SERVER['PHP_SELF'];
			}
			else 
			{
				$this->action = $action;
			}
			if($accountmaintenance != false)
			{
				$this->accountmaintenance = $accountmaintenance;
			}
			if($signout != false)
			{
				$this->signout = $signout;
			}
	}
	
	public function setAction($action){if(is_string($action)){$this->action = $action;}}
    
    public function setSignout($signout){if(is_string($signout)){$this->signout = $signout;}}
    
    public function setAccountMaintenance($accountmaintenance){ if(is_string($accountmaintenance)){$this->accountmaintenance = $accountmaintenance;}}
	
	public function logged($name = "")
	{
		$this->islogged = true;
		
		$this->signname=$name;
	}
  
}
class Signin_Renderer_v1 extends Signin_Renderer 
{
	
	public function __construct($action = false,$signout = false,$accountmaintenance = false)
	{
			$csslink = '<link rel="stylesheet" type="text/css" href="css/Layout/SigninRenderer.css" />';
			
			Signin_Renderer::__construct($csslink,$action,$signout,$accountmaintenance);
	}
	
	public function render()
	{
		// if not logged in 
		if(is_bool($this->islogged) && $this->islogged == false)
		{
			if(strlen($this->signedout)>0)
			{
						$signin = <<<EOD
<div id='banner_signin'>\n<form id='signin_form' action = '$this->action' method = 'post'>
<div class="form_section">
	<label for="sign_in_username">Username</label>
	<input type="text" size="10" name="login" id="sign_in_username"/>
</div>
<div class="form_section">
	<label for="sign_in_password">Password</label>
	<input type="password" size="10" name="password" id="sign_in_password"/>
	<input type="submit" value="Sign-in" class="submit"/>
</div>
<div class='signedout'>$this->signedout</div>
<div class="errormessage">$this->errormessage</div>
</form>
</div>
EOD;
			}
			else 
			{
						$signin = <<<EOD
<div id='banner_signin'>\n<form id='signin_form' action = '$this->action' method = 'post'>
<div class="form_section">
	<label for="sign_in_username">Username</label>
	<input type="text" size="10" name="login" id="sign_in_username"/>
</div>
<div class="form_section">
	<label for="sign_in_password">Password</label>
	<input type="password" size="10" name="password" id="sign_in_password"/>
	<input type="submit" value="Sign-in" class="submit"/>
</div>
<div class ='form_section'>
			<a class='accountmaintenance' href='$this->accountmaintenance'>Lost Credential(s)</a>
</div>
<div class='signedout'>$this->signedout</div>
<div class="errormessage">$this->errormessage</div>
</form>
</div>
EOD;
			}

		}
		else 
		{
			$signin = <<<EOD
<div id='banner_signin'>
	<form id='signin_form' class='logged' action = '$this->action' method = 'post'>			
		<div class = 'form_section'>
			<div id ='signin_message' ><span>Welcome</span> $this->signname</div>
		</div>
		<div class ='form_section'>
			<a href='$this->signout'>Sign Out</a>
		</div>
		<div class="errormessage">$this->errormessage</div>
	</form>
</div>
EOD;
		}
		
		return stripcslashes($signin);	
	}
	
}

?>