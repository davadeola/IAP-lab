<?php
  include_once 'DBConnector.php';
  include_once 'User.php';
  include_once 'fileUploader.php';


  $con = new DBConnector;
  

  if (isset($_POST['btn-save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city_name = $_POST['city_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];


    $utc_timestamp = $_POST['utc_timestamp'];
      $offset = $_POST['time_zone_offset'];


    $_SESSION['username'] = $username;
    
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $final_file_name = $_FILES['fileToUpload']['tmp_name'];
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $user = new User($first_name, $last_name, $city_name, $username, $password);

    $user->setUtcTimestamp($utc_timestamp);
    $user->setTimezoneOffset($offset);

    //FileUpload Instance
      $fileUpload = new FileUploader();

      //Setting the username
      $fileUpload->setUsername($username);

      //Using setter methods
      $fileUpload->setOriginalName($file_name);
      $fileUpload->setFileType($file_type);
      $fileUpload->setFinalFileName($final_file_name);
      $fileUpload->setFileSize($file_size);

    if (!$user->validateForm()) {
      $user->createFormErrorsSessions();
      header("Refresh:0");
      die();
    }else{
      if ($fileUpload->fileWasSelected()) {
        
        if ($fileUpload->fileTypeisCorrect()) {
          
          if ($fileUpload->fileSizeIsCorrect()) {
            
            if (!($fileUpload->fileAlreadyExists())) {
              $res = $user->save();
             $fileUpload->uploadFile();

             if ($res) {
              echo "Save operation was successful";
            }else{
              echo "An error occurred";
            }
  
            }else{
              echo "FILE EXISTS"."<br>";
  
            }
  
          }else{
            echo "PICK A SMALLER SIZE"."<br>";
          }
  
        }else{
          echo "INCORRECT TYPE"."<br>";
        }
  
  
      }else{echo "NO FILE DETECTED"."<br>";}

      

    }

    
    
    


    

    $data = $user->readAll();

  


  }


 ?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="validate.js" type="text/javascript"></script>
    <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> 
    <script type="text/javascript" src="timezone.js"></script>
    <link rel="stylesheet" href="validate.css">
    <title>Title goes here</title>
</head>
<body>
    <form class="" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return validateForm()" name="user_details" id="user_details" enctype="multipart/form-data">
      <table align="center">
      <tr>
        <td>
          <div id="form-errors">
            <?php 

              session_start();
              if(!empty($_SESSION['form_errors'])){
                echo " " . $_SESSION['form_errors'];
                unset($_SESSION['form_errors']);
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
        <tr>
          <td><input type="text" name="username" placeholder="Username"></td>
        </tr>

        </tr>
            <td><input type="password" name="password" id="" placeholder="Password"></td>
        <tr>

        <tr>
              <td>Profile Image: <input type="file" name="fileToUpload" id="fileToUpload"></td>
        </tr>

        <tr>
                 <td> <input type="hidden" name="utc_timestamp" id="utc_timestamp" value=""> </td> 
             </tr>

             <tr>
                     <td> <input type="hidden" name="time_zone_offset" id="time_zone_offset" value=""> </td>
             </tr>

          <td><button type="submit" name="btn-save" id="submit"><strong>SAVE</strong></button></td>
        </tr>

        <tr>
            <td><a href="login.php">Login</a></td>
        </tr>
      </table>
    </form>
</body>
</html>
