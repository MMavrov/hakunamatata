<?php
	require_once('include/db.php');
	require_once('include/helper.php');
	require_once('include/session.php');
	require_once('include/tbs_class.php');
	require_once('include/userInfo.php');
	
	$defLang = 'en';//isSetOr($user -> lang, NULL, 'bg');
	$lang = isSetOr($_REQUEST['lang'], NULL, $defLang);
	require ('lang/'.$lang.'.php');

	session_destroy();
	$variables['error'] = isSetOr($_REQUEST['error'], NULL, '');
	$TBS = new clsTinyButStrong;
	$TBS -> SetOption('protect', false); 
	$TBS -> LoadTemplate('templates/login.html');
	$TBS -> MergeField('content',$content);
	$TBS -> MergeField('variables',$variables);
	$TBS -> Show();
	
	
?>