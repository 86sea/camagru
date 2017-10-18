<?php
    $DB_DSN = 'mysql:host=localhost;dbname=camagru;charset=utf8';
    $DB_USER = 'root';
    $DB_PASSWORD = 'foo';
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
