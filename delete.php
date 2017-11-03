<?php
include "config/database.php";
print_r($_POST);
$imgID = $_POST['imgID'];
$src = $_POST['src'];
$imgID = (int)$imgID;
$query = $db->prepare("DELETE FROM gallery WHERE imgID=?");
$query->execute(array($imgID));
unlink($src);
header("Location: snap.php", true, 301);