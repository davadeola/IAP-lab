<?php
    session_start();
    $username = $_SESSION['username'];
    
    include_once "DBConnector.php";
    

     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      
       header('HTTP/1.0 403 Forbidden');
       echo 'You are forbidden';
     }else{
       $api_key = null;
       
       $api_key = generateApiKey(64);
       header('Content-type: application/json');
      
       echo generateResponse($api_key);

     }
     
      //This is how the key is generated
      function generateApiKey($str_length){
       $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
       //get enough bits for base 64 encoding (and prevent '=' padding)
       // +1 is better than ceil()
       $bytes = openssl_random_pseudo_bytes(3*$str_length/4+1);

       //convert base 64 to base 62 mapping + and / to something from the base 62 map
       //Use the first 2 random bytes for the new characters
       $repl = unpack('C2',$bytes);
 
       $first = $chars[$repl[1]%62];
       $second = $chars[$repl[2]%62];
       return strtr(substr(base64_encode($bytes), 0 ,$str_length), '+/' , "$first$second");
     }
 
     function saveApiKey($api_key){
       //Function that saves the API for the user currently logged in
       $user = $_SESSION['username'];
       $dbcon = new DBConnector();
	$myquery = mysqli_query($dbcon->conn, "SELECT * FROM userme WHERE username='$user'");
	$user_array = mysqli_fetch_assoc($myquery);
	$id = $user_array['id'];
        $sql = "INSERT INTO api_keys(user_id ,api_key) VALUES('$id','$api_key')";
        $res = mysqli_query($dbcon->conn,$sql) or die("Error " .mysqli_error($dbcon->conn));    
        
        return $res;
     }
 
 
     function generateResponse($api_key){
       if(saveApiKey($api_key) === TRUE){
         $res = ['success'=> 1, 'message'=> $api_key];
       }else{
         $res = ['success' => 0, 'message'=> "Something went wrong. Please regenerate the API"];
       }
       return json_encode($res);
     }

     
?>