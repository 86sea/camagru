<?php
    include_once "header.php";
    $login = $_GET['user'];
    $token = $_GET['token'];
    $query = $db->prepare("SELECT * FROM users WHERE username=? AND token =?");
    $query->execute(array($login, $token));
    $row_count = $query->rowCount();
    if ($row_count != 1)
        echo "LINK INVALID";
    else {
        $query = $db->prepare("UPDATE users SET valid=? WHERE username=?");
        $query->execute(array(1, $login));
        echo "VALIDATION SUCCESSFULL";
    }
?>