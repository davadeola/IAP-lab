<?php
  include 'Crud.php';
  include_once 'DBConnector.php';
  include "authenticator.php";

 
  class User implements Crud, Authenticator
  {
    private $user_id;
    private $first_name;
    private $last_name;
    private $city_name;
    private $username;
    private $password;

    private $tmzn_off;
    private $utc_timestamp;
    

    function __construct($first_name, $last_name, $city_name, $username, $password)
    {
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->city_name = $city_name;
      $this->username = $username;
      $this->password = $password;
    }

    //use_id setter
    public function setUserId($user_id)
    {
      $this->$user_id = $user_id;
    }

    public function getUserId()
    {
      return $this->$user_id;
    }

    public function getTimezoneOffset()
    {
        return $this->tmzn_off;
    }

    public function setTimezoneOffset($tMzOffset)
    {
        $this->tmzn_off = $tMzOffset;
    }


    //Utc_timestamp (Set and Get)
    public function getUtcTimestamp()
    {
        return $this->utc_timestamp;
    }

    public function setUtcTimestamp($utc_timestamp)
    {
        $this->utc_timestamp = $utc_timestamp;
    }


    public function save()
    {
      $fn = $this->first_name;
      $ln = $this->last_name;
      $city = $this->city_name;
      $uname = $this->username;
      $this->hashPassword();
      $pass = $this->password;
      $tMzOffset = $this->getTimezoneOffset();
      $utc_tmstp = $this->getUtcTimestamp();
      $con = new DBConnector();

      if ($this->isUserExists()) {
        echo "<script>alert('Username is taken')</script>";
        header("Refresh:0");
      }else{
        $res = mysqli_query($con->conn ,"INSERT INTO userme(first_name, last_name, user_city, username, password, created_time, offset) VALUES('$fn', '$ln', '$city', '$uname','$pass', '$utc_tmstp', '$tMzOffset')") or die("Error: ". mysqli_error($con->conn));
      return res;
      }

      
    }

    public function readUnique()
    {
      return null;
    }

    public function readAll()
    {
      $con = new DBConnector();
      $data = mysqli_query($con->conn, "SELECT * FROM userme");
      return $data;
    }

    public function search()
    {
      return null;
    }
    public function update()
    {
      return null;
    }

    public function removeOne()
    {
      return null;
    }


    public function removeAll()
    {
      return null;
    }


    public function validateForm(){
      $fn = $this->first_name;
      $ln = $this->last_name;
      $city = $this->city_name;

      if (fname == "" || lname == "" || city == "") {
        return false;
      }else{
        return true;
      }

      
    }

    public function createFormErrorsSessions(){
      session_start();
      $_SESSION['form_errors'] = "All the fields are required";

    }


    // static constructor
    public static function create(){
      $instance = new self($first_name,$last_name,$city_name,$username,$password);
      return $instance;
    }

    //username setter
    public function setUsername($username){
      $this->username = $username;
    }

    //username getter
    public function getUsername(){
      return $this->username;
    }

    //password setter
    public function setPassword($password){
      $this->password = $password;
    }

    //password getter
    public function getPassword(){
      return $this->password;
    }


    public function hashPassword(){
      $this->password= password_hash($this->password,PASSWORD_DEFAULT);
    }

    public function isPasswordCorrect(){
      $con = new DBConnector;
      $found = false;
      $res = mysqli_query($con->conn, "SELECT * FROM userme") or die("Error: ". mysqli_error($con->conn));

      while($row = mysqli_fetch_array($res)){
        if (password_verify($this->getPassword(), $row['password']) && $this->getUsername()==$row['username']) {
          $found = true;
        }
      }

      $con->closeDatabase();
      return $found;
    }


    public function login(){
      if($this->isPasswordCorrect()){
        header("Location:private_page.php");
      }
    }

    public function createUserSession(){
      session_start();
      $_SESSION['username'] = $this->getUsername();
    }

    public function logout(){
      session_start();
      unset($_SESSION['username']);
      session_destroy();
      header("Location:lab1.php");
    }

    public function isUserExists(){
      $con = new DBConnector;
      $taken = false;
      $res = mysqli_query($con->conn, "SELECT * FROM userme") or die("Error: ". mysqli_error($con->conn));

      while($row = mysqli_fetch_array($res)){
        if ($this->getUsername()==$row['username']) {
          $taken = true;
        }
      }
      return $taken;
    }

  }


 ?>
