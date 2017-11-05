<?php
include "config/database.php";
    print_r($_POST);
    $comment = $_POST['comment'];
    session_start();
    $comment = $_SESSION['logged_on_usr'] . " Said: ". $comment;
    $imgID = $_POST['imgID'];
    $user = $_POST['user'];
    $query = $db->prepare("INSERT INTO comments(imgID, comment, username)	VALUES(?, ?, ?)");
         $query->execute(array($imgID, $comment, $user));

    $query = $db->prepare("SELECT * FROM users WHERE username=?");
        $query->execute(array($user));
            $email = $query->fetch(PDO::FETCH_ASSOC);

    $email = $email['email'];
    mail("$email", "CAMAGRU COMMENT", "$comment on one of your pics!");
    header('Location: index.php', true, 301);