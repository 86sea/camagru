<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Accounts</title>
<?php
    include "header.php";
    session_start();
    if ($_GET['reset'] != "" && $_SESSION['reset_login'] == "") {
        $_SESSION['reset_login'] = $_GET['reset'];
        $_SESSION['reset_token'] = $_GET['token'];
    }
    if ($_POST['passwd'] != "" && $_POST['submit'] == "reset") {
        echo "wtf";
        $login = $_SESSION['reset_login'];
        $token = $_SESSION['reset_token'];
       $query = $db->prepare("SELECT * FROM users WHERE username=? AND reset=?");
        $query->execute(array($login, $token));
        $row_count = $query->rowCount();
        if ($row_count != 1) {
            echo "INVALID USERNAME OR RESET TOKEN";
        }
        else {
            $passwd = $_POST['passwd'];
            $hash = hash(whirlpool, $passwd);
            $query = $db->prepare("UPDATE users SET passwd=? WHERE username=?");
            $query->execute(array($hash, $login));
            session_unset();
            header('Location: accounts.php?action=login', true, 301);
        }
    }
   // print_r($_SESSION);
    //print_r($_GET);
    print_r($_POST);

?>
</head>
<body>
<div class="login">
    <form action="reset2.php" method="post">
        <h1>Password:</h1>
        <input type="password" name="passwd" value="" title="pass">
        <button type="submit" name="submit" value="reset">Reset password and go to login page.</button>
    </form>
</div>
</body>
</html>
