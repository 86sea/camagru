<?php
    include "header.php";
    if ($_POST['submit'] == "reset")
    {
        $login = $_POST['login'];
        $email = $_POST['email'];
        $query = $db->prepare("SELECT * FROM users WHERE username=? AND email=?");
        $query->execute(array($login, $email));
        $row_count = $query->rowCount();
        if ($row_count != 1) {
            echo "Account Not found!";
        }
        else {
            $token = openssl_random_pseudo_bytes(16);
            $token = bin2hex($token);
            $query = $db->prepare("INSERT INTO users(reset) VALUES(?)");
            $query = execute(array($token));
            $reset = "Click this link to reset your password: http://localhost:8080/camagru/login.php?reset=$login&token=$token";
            if (mail("$email", "CAMAGRU ACCOUNT RESET PASSWORD", "$reset")){
                echo "An email was sent with a link to reset your password";
            };
        }
    }
    ?>
<div class="login">
    <form action="reset.php" method="post">
        <h1>Username:</h1>
        <input type="text" name="login" value="" title="login">
        <h1>Email:</h1>
        <input type="text" name="email" value="" title="login">
        <button type="submit" name="submit" value="reset">Reset</button>
    </form>
</div>
