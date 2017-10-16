<?php

function auth($login, $passwd)
{
	if ($login != "" && $passwd != "")
	{
		$servername="127.0.0.1";
		$username ="root";
		$password = "g5nrqbcm";
		$dbname = "cms_info_db";
		$conn = mysqli_connect($servername, $username, $password);
		$hash = hash(whirlpool, $passwd);
		$sql = "SELECT * FROM cms_info_db.users WHERE username = '$login'";
		$query = mysqli_query($conn, $sql);
		if (mysqli_num_rows($query) == 0)
			return false;
		$row = mysqli_fetch_row($query);
		if ($row[2] != $hash)
		{
			echo $row[2];
			echo "WRONG PASSWORD".$row[0];
			return false;
		}
		else
			return true;
	}
}
?>
