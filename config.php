<?php
$db = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'foo', array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
?>