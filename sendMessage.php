<?php
	require_once('include/db.php');
    require_once('include/helper.php');
    require_once('include/session.php');
    require_once('include/tbs_class.php');
    require_once('include/userInfo.php');
    
    $defLang = 'en';//isSetOr($user -> lang, NULL, 'bg');
    $lang = isSetOr($_REQUEST['lang'], NULL, $defLang);
    require ('lang/'.$lang.'.php');

    $message = $_REQUEST['message'];

    // var_dump($message);
    // var_dump($_SESSION['sendToUser']);

    $user = new user;
    $user -> postMessage($message, $_SESSION['sendToUser']);
    echo("Message Sent");

?>