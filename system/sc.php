<?php
class SC
{
	// get
	static function get($name)
	{
		if(isset($_COOKIE[$name]))
			return $_COOKIE[$name];

		if(isset($_SESSION[$name]))
			return $_SESSION[$name];

		return null;
	}

	// set
	static function setSession($name, $value)
	{
		$_SESSION[$name] = $value;
	}

	static function setCookie($name, $value)
	{
		setcookie($name, $value, time() + (3600*24*365), '/');
	}

 	// remove
	static function remove($name)
	{
		if(isset($_SESSION[$name]))
			unset($_SESSION[$name]);

		if(isset($_COOKIE[$name]))
		{
			setcookie($name, "", time()-360000,'/');
			unset($_COOKIE[$name]);
		}
	}
}
?>