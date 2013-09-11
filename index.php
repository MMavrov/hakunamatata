<?php
	require_once('include/db.php');
	require_once('include/helper.php');
	require_once('include/session.php');
	require_once('include/tbs_class.php');
	require_once('include/userInfo.php');
	
	// if(!user::checkUserLoggedIn()){
	// 	header('Location: login.php');
	// }
	
	$defLang = 'en';
	$lang = isSetOr($_REQUEST['lang'], NULL, $defLang);
	require ('lang/'.$lang.'.php');
	
	$username = isSetOr($_REQUEST['username'], NULL, '');
	$password = isSetOr($_REQUEST['password'], NULL, '');

	if ($username !== '' && $password !== ''){
		$password = encPass($password);
		if(user :: login($username, $password)){
			header('Location: home.php');
		}else {
			header('Location: login.php?error=Cannot login!');
		}
	}else{
		$variables['error'] = isSetOr($_REQUEST['error'], NULL, '');
		$TBS = new clsTinyButStrong;
		$TBS -> SetOption('protect', false); 
		$TBS -> LoadTemplate('templates/login.html');
		$TBS -> MergeField('content',$content);
		$TBS -> MergeField('variables',$variables);
		$TBS -> Show();
	}
	
?>