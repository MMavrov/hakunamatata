<?php
    require_once('include/db.php');
    require_once('include/helper.php');
    require_once('include/session.php');
    require_once('include/tbs_class.php');
    require_once('include/userInfo.php');

    $messageId = $_REQUEST['messageId'];
    $user = new user;
    $user -> changeMessageStatus($messageId);
    $message = $user -> getMessage($messageId);
    echo($message);
    ?>