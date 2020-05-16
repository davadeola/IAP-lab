<?php
  include_once 'DBConnector.php';
  include_once 'User.php';


  $con = new DBConnector;

  if (isset($_POST['btn-save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city_name = $_POST['city_name'];

    $user = new User($first_name, $last_name, $city_name);
    if ($user->validateForm()) {
      $user->createFormErrorsSessions();
      header("Refresh:0");
      echo $user->first_name . "jshuiou";
      die();
    }

    
    $res = $user->save();



    if ($res) {
      echo "Save operation was successful";
    }else{
      echo "An error occurred";
    }

    $data = $user->readAll();

  


  }


 ?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="validate.js" type="text/javascript"></script>
    <link rel="stylesheet" href="validate.css">
    <title>Title goes here</title>
</head>
<body>
    <form class="" action="" method="post" onsubmit="return validateForm()" name="user_details" id="user_details">
      <table align="center">
      <tr>
        <td>
          <div id="form-errors">
            <?php 

              session_start();
              if(!empty($_SESSION['form-errors'])){
                echo " " . $_SESSION['form-errors'];
                unset($_SESSION[form-errors]);
              }

            ?> 
          </div>
        </td>
      </tr>
        <tr>
          <td><input type="text" name="first_name"  placeholder="First name"/></td>
        </tr>
        <tr>
          <td><input type="text" name="last_name"  placeholder="Last name"/></td>
        </tr>
        <tr>
          <td><input type="text" name="city_name"  placeholder="City"/></td>
        </tr>
        <tr>
          <td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
        </tr>
      </table>
    </form>
</body>
</html>
