<?php
    include "config/database.php";
    $imgID = $_POST['imgID'];
    $query = $db->prepare("SELECT * FROM gallery WHERE imgID=?");
        $query->execute(array($imgID));
            $row = $query->fetch(PDO::FETCH_ASSOC);
    $likes = $row['likes'];
    $likes++;
    $query = $db->prepare("UPDATE gallery SET likes=? WHERE imgID=?");
        $query->execute(array($likes, $imgID));
    header('Location: index.php', true, 301);