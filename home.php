<?php
    require_once('include/db.php');
    require_once('include/helper.php');
    require_once('include/session.php');
    require_once('include/tbs_class.php');
    require_once('include/userInfo.php');
    
    $defLang = 'en';//isSetOr($user -> lang, NULL, 'bg');
    $lang = isSetOr($_REQUEST['lang'], NULL, $defLang);
    require ('lang/'.$lang.'.php');
    
    $variables['username'] = isSetOr($_SESSION['username'], NULL, "");

    $user = new user;
    $gossips = $user -> getAllGossips();

    $variables['gossipTableBody'] = "";

    for ($i=0; $i < count($gossips); $i++){
        $variables['gossipTableBody'] .= "<tr><td>". $gossips[$i][0] ."</td><td>".$gossips[$i][1]."</td></tr>";
    }

    //CHECK FOR NEW MESSAGES!
    // $user = new user;

    // if($user -> haveNewMessages() === false){
    //     echo("false");
    // }else{
    //     echo("true");
    // }

    $TBS = new clsTinyButStrong;
    $TBS -> SetOption('protect', false); 
    $TBS -> LoadTemplate('templates/homepage.html');
    $TBS -> MergeField('content',$content);
    $TBS -> MergeField('variables',$variables);
    $TBS -> Show();
?>