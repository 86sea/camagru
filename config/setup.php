<?php
    $DB_DSN = 'mysql:host=localhost;charset=utf8';
    $DB_USER = 'root';
    $DB_PASSWORD = 'foo';
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $db->query("CREATE DATABASE IF NOT EXISTS camagru");
    $DB_DSN = 'mysql:host=localhost;dbname=camagru;charset=utf8';
    $DB_USER = 'root';
    $DB_PASSWORD = 'foo';
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $db->query("CREATE TABLE `users` (
          `userID` int(6) UNSIGNED NOT NULL,
          `username` varchar(30) NOT NULL,
          `passwd` varchar(255) NOT NULL,
          `email` varchar(50) NOT NULL,
          `token` varchar(128) NOT NULL,
          `valid` tinyint(1) DEFAULT NULL,
          `reset` varchar(128) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    $db->query("CREATE TABLE `gallery` (
          `imgID` int(6) UNSIGNED NOT NULL,
          `URL` varchar(2083) NOT NULL,
          `userID` varchar(30) NOT NULL,
          `likes` int(11) NOT NULL DEFAULT '0'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    $db->query("CREATE TABLE `comments` (
          `commentID` int(11) NOT NULL,
          `imgID` int(11) NOT NULL,
          `comment` varchar(140) NOT NULL,
          `username` varchar(30) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");

    $db->query("ALTER TABLE `comments`
          ADD PRIMARY KEY (`commentID`);");

    $db->query("ALTER TABLE `gallery`
          ADD PRIMARY KEY (`imgID`);");

    $db->query("ALTER TABLE `users`
          ADD PRIMARY KEY (`userID`);");

    $db->query("ALTER TABLE `comments`
              MODIFY COLUMN commentID INT auto_increment");

    $db->query("ALTER TABLE `gallery`
              MODIFY COLUMN imgID INT auto_increment");

    $db->query("ALTER TABLE `users`
              MODIFY COLUMN userID INT auto_increment");