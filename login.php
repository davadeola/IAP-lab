<?php

include_once 'DBConnector.php';
include_once 'User.php';

$con = new DBConnector;

if(isset($_POST['btn-login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $instance = User::create();

    $instance->setPassword($password);
    $instance->setUsername($username);

    if ($instance->isPasswordCorrect()) {
        $instance->login();

        $con->closeDatabase();

        $instance->createUserSession();
    }else{
        $con->closeDatabase();
        header("Location:login.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="validate.js"></script>
    <link rel="stylesheet" href="validate.css" type="text/css">
    <title>Document</title>
</head>
<body>

    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="login" name="login">
        <table align="center">
        <tr>
          <td><input type="text" name="username" placeholder="Username" required></td>
        </tr>
        </tr>
            <td><input type="password" name="password" id="" placeholder="Password" required></td>
        <tr>
          <td><button type="submit" name="btn-login"><strong>LOGIN</strong></button></td>
        </tr>

        </table>
    </form>
    
</body>
</html>