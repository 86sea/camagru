<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<title>CAMAGRU</title>
	</head>
	<body>
	    <?php
        include_once "header.php";
        session_start();
	    if ($_SESSION['logged_on_usr'] != "")
            echo "<a href='http://localhost:8080/camagru/snap.php'>Take a picture!</a><br>";
	    else
	        echo "PLEASE LOGIN TO CONTINUE";
?>
    </body>
</html>
