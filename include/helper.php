<?php
// File for helpful external functions

//Password encryption

	//Encrypt Password
	function encPass($unEncPass){
		return md5(salt($unEncPass));// md5 - returns 32 bit hash | We use salt to make the encrypted pass secure to rainbow attacks
	}
	
	//Salt (to artificialy lenghten)password
	function salt($unSaltedPass){
		return sha1(md5($unSaltedPass)).$unSaltedPass;//sha1 - returns sha hash
	}
	
//Password encryption end

//Easy variable reading

	function isSetOr(&$variable, $nulVal = NULL, $or = NULL) {
    	return $variable === $nulVal ? $or : $variable;//returns the variable or if not set returns the $or alternative (by default NULL)
	}

//Easy variable reading end

//Passing global parameters /like lang/
	$variables['global-additionalParameters'] = '';
	
	function addParam($param, $value)
	{
		global $variables;
		if ($variables['global-additionalParameters'] === '')
		{
			$variables['global-additionalParameters'] .= '?';
		}
		else
		{
			$variables['global-additionalParameters'] .= '&';
		}
		$variables['global-additionalParameters'] .= $param.'='.$value;
	}
//Error handling

	//TODO error handling methods

//Error handling end

?>
