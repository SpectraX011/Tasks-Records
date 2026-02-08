<?php

$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'CRUD';

try{
$conn = new mysqli($db_host,$db_user,$db_password,$db_name);

 if($conn->connect_error){
    throw new Exception("Connection Failed" . $conn->connect_error);

 }
}catch(Exception $e){
    $error_message = "Database connection error:".$e->getMessage();
   if(!isset($_SESSION)){
    session_start();

   }

   $_SESSION['error'] = $error_message;
}


?>