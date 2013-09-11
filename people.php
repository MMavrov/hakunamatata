<?php
	require_once('include/db.php');
    require_once('include/helper.php');
    require_once('include/session.php');
    require_once('include/tbs_class.php');
    require_once('include/userInfo.php');
    
    $defLang = 'en';//isSetOr($user -> lang, NULL, 'bg');
    $lang = isSetOr($_REQUEST['lang'], NULL, $defLang);
    require ('lang/'.$lang.'.php');

    $user = new user;

    $friends = $user -> getFriends();
    $notFriends = $user -> getNotFriends();

    $buttons = array("send message", "send friends request", "request sent");

    $variables['tablebody'] = "";

    for ($i=0; $i < count($friends); $i++) { 
        $tablebody = "<tr><td><a class=\"btn btn-primary\">". $friends[$i][1] ."</a></td> <td><a href=\"redirectToSendMessage.php?sendToUser=". $friends[$i][0] ."\" class=\"btn btn-primary\">". $buttons[0] ."</a></td></tr>";
        $variables['tablebody'] .= $tablebody;
    }

    for ($i=0; $i < count($notFriends); $i++) { 
        if($user -> isFriendRequestSent($notFriends[$i][0]) !== false){
            $tablebody = "<tr><td><a class=\"btn btn-primary\">". $notFriends[$i][1] ."</a></td> <td><a href=\"sendFriendsRequest.php?sendToUser=". $notFriends[$i][0] ."\" class=\"btn btn-danger\">". $buttons[2] ."</a></td></tr>";

        }else{
            $tablebody = "<tr><td><a class=\"btn btn-primary\">". $notFriends[$i][1] ."</a></td> <td><a href=\"sendFriendsRequest.php?sendToUser=". $notFriends[$i][0] ."\" class=\"btn btn-primary\">". $buttons[1] ."</a></td></tr>";
        }
        $variables['tablebody'] .= $tablebody;
    }

    $TBS = new clsTinyButStrong;
    $TBS -> SetOption('protect', false); 
    $TBS -> LoadTemplate('templates/people.html');
    $TBS -> MergeField('content',$content);
    $TBS -> MergeField('variables',$variables);
    $TBS -> Show();

?>