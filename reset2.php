<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Accounts</title>
<?php
    include "header.php";
    if ($_GET['reset'] != ""){
        $login = $_GET['reset'];
        $token = $_GET['token'];
        $query = $db->prepare("SELECT * FROM users WHERE username=? AND reset=?");
        $query->execute(array($login, $token));
        $row_count = $query->rowCount();
        if ($row_count != 1) {
            header('Location: index.php', true, 301);
        }
        else if ($_POST['submit'] == "reset")
        {
            $passwd = $_POST['passwd'];
            $hash = hash(whirlpool, $passwd);
            $query = $db->prepare("UPDATE users SET passwd=? WHERE username=?");
            $query->execute(array($passwd, $login));
            $_POST['submit'] = "login";
            header('Location: accounts.php', true, 301);
        }
    }
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
