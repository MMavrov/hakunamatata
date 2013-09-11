<?php
	require_once('include/db.php');
    require_once('include/helper.php');
    require_once('include/session.php');
    require_once('include/tbs_class.php');
    require_once('include/userInfo.php');

	$type = $_FILES["video"]["type"];
	$size = $_FILES["video"]["size"];
	$videoName = $_FILES["video"]["name"];

	$user = new user;
	if ($_FILES["video"]["error"] > 0) {
		die("Return Code: " . $_FILES["video"]["error"] . "<br>");
	} else {
		echo "Upload: " . $_FILES["video"]["name"] . "<br>";
		echo "Type: " . $_FILES["video"]["type"] . "<br>";
		echo "Size: " . ($_FILES["video"]["size"] / 1024 / 1024) . " kB<br>";
		echo "Temp file: " . $_FILES["video"]["tmp_name"] . "<br>";

		if (file_exists("uploads/" . $user -> userName . "/" . $_FILES["video"]["name"])) {
			die("<p>" . $_FILES["video"]["name"] . " already exists. </p>");
		} else {
			if (!file_exists('uploads/'.$user -> userName)) {
			    mkdir('uploads/'.$user -> userName, 0777, true);
			}
			if(move_uploaded_file($_FILES["video"]["tmp_name"], "uploads/". $user -> userName. "/" .$_FILES["video"]["name"])){
				$uploadedPath = "uploads/". $user -> userName . "/" . $_FILES["video"]["name"];
				echo "Stored in: " . "uploads/" . $user -> userName . '/' . $_FILES["video"]["name"] . "<br>";
			}else{
				echo "error in uploading file"; 
			}
		}
	}
	$stm = $pdo -> prepare('INSERT INTO `uploaded` (`type`, `name`, `path`) 
							VALUES (:type, :videoname, :uploadedpath)');
	$stm -> execute(array(':type' => $type, ':videoname' => $videoName, ':uploadedpath' => $uploadedPath));
?>