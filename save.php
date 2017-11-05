<?php
    include "config/database.php";
        $imageData = file_get_contents("php://input");
        $filter = substr($imageData, -1);
        $filterData = substr($imageData, 0, -1);
        $filteredData = substr($imageData, strpos($imageData, ",") + 1);
        $unencodedData = base64_decode($filteredData);
        $fp = fopen('temp.png', 'wb');
        fwrite($fp, $unencodedData);
        fclose($fp);
    //https://stackoverflow.com/questions/3876299/merging-two-images-with-php
        $time = time();
        session_start();
        $name = $_SESSION['logged_on_usr'].$time. ".png";
        $dest = imagecreatefrompng("temp.png");
        $src = imagecreatefrompng("stock/$filter.png");
        imagealphablending($dest, true);
        imagesavealpha($dest, true);
        imagealphablending($src, true);
        imagesavealpha($src, true);
        imagecopy($dest, $src, 0, 0, 0, 0, 640, 484);
        imagepng($dest, "gallery/$name");
        imagedestroy($dest);
        imagedestroy($src);
        $query = $db->prepare("INSERT INTO gallery(URL, userID)	VALUES(?, ?)");
        $query->execute(array($name, $_SESSION['logged_on_usr']));
        // https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/send
        header("Location: snap.php", true, 301);