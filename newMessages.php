<?php
    require_once('include/db.php');
    require_once('include/helper.php');
    require_once('include/session.php');
    require_once('include/tbs_class.php');
    require_once('include/userInfo.php');
	
    $user = new user;
    $newMessages = $user -> getNewMessages();
    
    if(!empty($newMessages)){
        echo"1";
    }else{
        echo"0";
    }
?>