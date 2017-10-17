<?php
	session_start();
	$_SESSION['logged_on_usr'] = "";
	header("Location: http://localhost:8080/camagru/index.php",true, 301);
	exit();
?>