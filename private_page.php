<?php
    session_start();

    if(!isset($_SESSION['username'])){
        header("Location:login.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="validate.js"></script>
    <link rel="stylesheet" href="validate.css">
    <title>Document</title>
</head>
<body>

    <p>This is a private page</p>
    <p>We want to protect it</p>
    <p><a href="logout.php">Logout</a></p>
    
</body>
</html>