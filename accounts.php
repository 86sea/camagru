<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Accounts</title>
<?php
    function create($db)
        {
            $email = $_POST['email'];
            if (strlen($_POST['login']) < 1 || strlen($_POST['passwd']) < 0 || filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE){
                echo "<br><br><br><br>USER NAME NEEDS TO BE BIGGER THAN 1 CHARACTER AND PASSWORD NEEDS TO CONTAIN AT LEAST 8 CHARACTERS AND EMAIL NEEDS TO BE VALID";
                return (false);
            }
            $login = $_POST['login'];
            $passwd = $_POST['passwd'];
            $hash = password_hash($passwd, PASSWORD_BCRYPT);
            $token = openssl_random_pseudo_bytes(16);
            $token = bin2hex($token);
            $query = $db->prepare("SELECT * FROM users WHERE username=?");
            $query->execute(array($login));
            $row_count = $query->rowCount();
            if ($row_count != 0) {
                echo "<br><br><br><br>ACCOUNT ALREADY EXISTS";
                return (false);
            }
            else {
                $query = $db->prepare("INSERT INTO users(username, passwd, email, token, valid)	VALUES(?, ?, ?, ?, ?)");
                $query->execute(array($login, $hash, $email, $token, 0));
                $validation = "http://localhost:8080/camagru/validate.php?user=$login&token=$token";
                mail("$email", "CAMAGRU ACCOUNT VALIDATION", "$validation");
                return (true);
            }
        }
    function login($db){
            if (strlen($_POST['login']) < 1 || strlen($_POST['passwd']) < 0){
                echo "<br><br><br><br>USER NAME NEEDS TO BE BIGGER THAN 1 CHARACTER PASSWORD NEEDS TO CONTAIN AT LEAST 8 CHARACTERS";
                return (false);
            }
            $login = $_POST['login'];
            $passwd = $_POST['passwd'];
            $query = $db->prepare("SELECT * FROM users WHERE username=?");
            $query->execute(array($login));
            $row_count = $query->rowCount();
            if ($row_count != 1)
            {
                echo "<br><br><br><br>ACCOUNT DOES NOT EXIST";
                return (false);
            }
            else {
                $row = $query->fetchAll(PDO::FETCH_ASSOC);
                if (password_verify($passwd , $row[0]['passwd']) != TRUE) {
                    echo "<br><br><br><br>WRONG PASSWORD";
                    return false;
                }
                if ($row[0]['valid'] != 1){
                    echo "<br><br><br><br>ACCOUNT HAS NOT BEEN VALIDATED, CHECK YOUR EMAIL";
                    return false;
                }
                else {
                    session_start();
                    $_SESSION['logged_on_usr'] = $login;
                    return true;
                }
            }
    }

    ?>
<body>
<?php
    include "header.php";
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
            if (create($db) != "true"){
                include "create.php";
            }
            break;
        case "_login":
            if (login($db) != "true"){
                include "login.php";
            }
            else
                header('Location: index.php', true, 301);
            break;
        case "admin":
            // TODO include_once "login_admin.php";
            break;
    }
    if (isset($_GET['action']) && $_GET['action'] == "login")
        include_once "login.php";

?>
<?php include_once "footer.php";?>
</body>
</html>