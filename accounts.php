<!DOCTYPE html>
<html>
<head>
	<title>Accounts</title>
    <?php
        include_once "header.php";
        function create()
        {
            $login = $_POST['login'];
            $passwd = $_POST['passwd'];
            $email = $_POST['email'];
            $hash = hash(whirlpool, $passwd);
            $token = openssl_random_pseudo_bytes(16);
            $token = bin2hex($token);
            $query = $db->prepare("SELECT * FROM users WHERE username=?");
            $query->execute(array($login));
            $row_count = $query->rowCount();
            if ($row_count != 0)
                return (false);
            else {
                $query = $db->prepare("INSERT INTO users(username, passwd, email, token, valid)
			VALUES(?, ?, ?, ?, ?)");
                $query->execute(array($login, $passwd, $email, $token, 0));
            }
            $query = "INSERT INTO users(username, passwd, email, token, valid)
			VALUES('$login', '$hash', '$email', '$token', '0')";


        }
        switch ($_POST['submit']) {

            case "create":
                include_once "create.php";
                break;
            case "login":
                include_once "login.php";
                break;
            case "admin":
                include_once "login_admin.php";
                break;
        }
    ?>
</head>
<body>
    <?php
        if (create())
            ;//TODO
        else
            ;

    ?>
</body>
</html>