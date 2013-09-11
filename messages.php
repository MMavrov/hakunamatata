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

    $seenMessages = $user -> getSeenMessages();
    $newMessages = $user -> getNewMessages();
    $friendInvitations = $user -> getFriendUnvitations();

    $variables['tablebody'] = "";

    for ($i=0; $i < count($friendInvitations); $i++){
        $variables['tablebody'] .= "<tr><td><a class=\"btn btn-danger\" href=\"acceptFriendsInvitation.php?sendToUser=" . $friendInvitations[$i][0] ."\">Friends Invitation</a></td><td><span class=\"label labes-success\">" . $friendInvitations[$i][1]. "</span></td></tr>";
    }

    for ($i=0; $i < count($newMessages); $i++) { 
        $variables['tablebody'] .= "<tr><td><a id=\"btn".$newMessages[$i][1]."\" class=\"btn btn-danger\" onclick=\"readMessage(". $newMessages[$i][1] .")\">New Message</a></td><td><span class=\"label labes-success\">" . $newMessages[$i][0]. "</span></td></tr>";
    }

    for ($i=0; $i < count($seenMessages); $i++){    
        $variables['tablebody'] .= "<tr><td><a class=\"btn btn-success\" onclick=\"readMessage(". $seenMessages[$i][1] .")\">Seen Message</a></td><td><span class=\"label labes-success\">" . $seenMessages[$i][0]. "</span></td></tr>";
    }

    //var_dump($variables);

    $TBS = new clsTinyButStrong;
    $TBS -> SetOption('protect', false); 
    $TBS -> LoadTemplate('templates/messages.html');
    $TBS -> MergeField('content',$content);
    $TBS -> MergeField('variables',$variables);
    $TBS -> Show();

?>