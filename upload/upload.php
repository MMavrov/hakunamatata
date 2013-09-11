<?php
	require_once('include/db.php');
    require_once('include/helper.php');
    require_once('include/session.php');
    require_once('include/tbs_class.php');
    require_once('include/userInfo.php');

	$type = $_FILES["video"]["type"];
	$size = $_FILES["video"]["size"];
	$videoname = $_FILES["video"]["name"];

	if ($_FILES["video"]["error"] > 0) {
		die("Return Code: " . $_FILES["video"]["error"] . "<br>");
	} else {
		echo "Upload: " . $_FILES["video"]["name"] . "<br>";
		echo "Type: " . $_FILES["video"]["type"] . "<br>";
		echo "Size: " . ($_FILES["video"]["size"] / 1024 / 1024) . " kB<br>";
		echo "Temp file: " . $_FILES["video"]["tmp_name"] . "<br>";

		if (file_exists("uploads/" . $_FILES["video"]["name"])) {
			die("<p>" . $_FILES["video"]["name"] . " already exists. </p>");
		} else {
			move_uploaded_file($_FILES["video"]["tmp_name"], "uploads/" . $_FILES["video"]["name"]);
			//Да се добави ."$username/". по някакъв начин .. там .. :D като се добавят и user-и
			$uploadedPath = "uploads/"/* . "$username/"*/ . $_FILES["video"]["name"];
			echo "Stored in: " . "uploads/" . $_FILES["video"]["name"] . "<br>";
		}
	}
	
	$sql = "INSERT INTO uploadedvideos (id, type, name, path) VALUES ('', '$type', '$videoname', '$uploadedPath')";
	$result = mysql_query($sql);
	if ($result) {
		echo "Video uploaded";
	} else {
		echo "ERROR in SQL query";
	}
	mysql_close();
?>