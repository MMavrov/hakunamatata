<?php
	require_once('include/db.php');
	require_once('include/helper.php');
	require_once('include/session.php');
	require_once('include/tbs_class.php');
	require_once('include/userInfo.php');
	
	// if(user::checkUserLoggedIn()){
	// 	header('Location: home.php');
	// }
	
	$defLang = 'en';//isSetOr($user -> lang, NULL, 'bg');
	$lang = isSetOr($_REQUEST['lang'], NULL, $defLang);
	require ('lang/'.$lang.'.php');
	
	$username = isSetOr($_POST['username'], NULL, '');
	$password = isSetOr($_POST['password'], NULL, '');

	if ($username !== '' && $password !== ''){
		$password = encPass($password);
		if(user :: login($username, $password)){
			$_SESSION['username'] = $username;
			$_SESSION['session'] = $session;
			header('Location: home.php');
		}else {
			header('Location: login.php?error=Cannot login!');
		}
	}else{
		$variables['error'] = isSetOr($_REQUEST['error'], NULL, 'Cannot login!');
		$TBS = new clsTinyButStrong;
		$TBS -> SetOption('protect', false); 
		$TBS -> LoadTemplate('templates/login.html');
		$TBS -> MergeField('content',$content);
		$TBS -> MergeField('variables',$variables);
		$TBS -> Show();
	}
	
?>