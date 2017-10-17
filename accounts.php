<!DOCTYPE html>
<html>
<head>
	<title>Accounts</title>
    <?php
        include_once "header.php";
    function create($db)
        {
            $email = $_POST['email'];
            if (strlen($_POST['login']) < 1 || strlen($_POST['passwd']) < 8 || filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE){
                echo "USER NAME NEEDS TO BE BIGGER THAN 1 CHARACTER AND PASSWORD NEEDS TO CONTAIN AT LEAST 8 CHARACTERS AND EMAIL NEEDS TO BE VALID";
                return (false);
            }
            $login = $_POST['login'];
            $passwd = $_POST['passwd'];
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
                $query->execute(array($login, $hash, $email, $token, 0));
                $validation = "http://localhost:8080/camagru/validate.php?user=$login&token=$token";
                echo mail("$email", "CAMAGRU ACCOUNT VALIDATION", "$validation");
                return (true);
            }
        }
    function login($db){
            if (strlen($_POST['login']) < 1 || strlen($_POST['passwd']) < 8){
                echo "USER NAME NEEDS TO BE BIGGER THAN 1 CHARACTER PASSWORD NEEDS TO CONTAIN AT LEAST 8 CHARACTERS";
                return (false);
            }
            $login = $_POST['login'];
            $passwd = $_POST['passwd'];
            $hash = hash(whirlpool, $passwd);
            $query = $db->prepare("SELECT * FROM users WHERE username=?");
            $query->execute(array($login));
            $row_count = $query->rowCount();
            if ($row_count != 1)
                return (false);
            else {
                $row = $query->fetchAll(PDO::FETCH_ASSOC);
                if ($row[0]['passwd'] != $hash) {
                    echo "WRONG PASSWORD";
                    return false;
                if ($row[0]['valid'] != 1){
                    echo "ACCOUNT HAS NOT BEEN VALIDATION, CHECK YOUR EMAIL";
                }
                } else {
                    session_start();
                    $_SESSION['logged_on_usr'] = $login;
                    return true;
                }
            }
    }
        switch ($_POST['submit']) {

            case "create":
                include_once "create.php";
                break;
            case "login":
                include_once "login.php";
                break;
            case "admin":
                //TODO include_once "login_admin.php";
                break;
        }
        switch ($_POST['submit']) {
        case "_create":
            if (create($db) != 1){
                include "create.php";
            }
            break;
        case "_login":
            if (login($db) != 1){
                include "login.php";
            };
            break;
        case "admin":
           // TODO include_once "login_admin.php";
            break;
    }
    ?>
</head>
<body>

</body>
</html>