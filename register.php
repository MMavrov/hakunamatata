<?php
	require_once('include/db.php');
	require_once('include/helper.php');
	require_once('include/session.php');
	require_once('include/tbs_class.php');
	require_once('include/userInfo.php');
	
	// if(user::checkUserLoggedIn()){
	// 	header('Location: home.php');
	// }
	
	$defLang = 'en';
	$lang = isSetOr($_REQUEST['lang'], NULL, $defLang);
	require ('lang/'.$lang.'.php');
	
	$username = isSetOr($_REQUEST['name'], NULL, '');
	$firstName = isSetOr($_REQUEST['firstname'], NULL, '');
	$lastName = isSetOr($_REQUEST['lastname'], NULL, '');
	$email = isSetOr($_REQUEST['email'], NULL, '');
	$password = isSetOr($_REQUEST['password'], NULL, '');
	
	if ($username !== '' && $password !== '' && $firstName !== '' && $lastName !== '' && $email !== ''){
		$password = encPass($password);
		if(user :: registerUser($username, $firstName, $lastName, $password, $email)){
			header('Location: login.php');
		}else {
			header('Location: register.php?error=Username exists!');
		}
	}else{
		$variables['error'] = isSetOr($_REQUEST['error'], NULL, '');
		$TBS = new clsTinyButStrong;
		$TBS -> SetOption('protect', false); 
		$TBS -> LoadTemplate('templates/register.html');
		$TBS -> MergeField('content',$content);
		$TBS -> MergeField('variables',$variables);
		$TBS -> Show();
	}
	

?>