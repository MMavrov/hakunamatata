<?php
    require_once('include/db.php');
    require_once('include/helper.php');
    require_once('include/session.php');
    require_once('include/tbs_class.php');
    require_once('include/userInfo.php');
	
    $user = new user;
    $allGossips = $user -> getAllGossips();
    
    for ($i=0; $i < count($allGossips); $i++){
        echo("<tr><td>". $allGossips[$i][0] ."</td><td>". $allGossips[$i][1] ."</td></tr>");
    }
?>