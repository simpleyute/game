<?php

 
 require 'dbFunctions.php';
 
 echo "sdfdfs";
 
 login("users","email,firstname",array("email" =>"LIKE" , "password" =>"="));
 
 
 
// $email=$_POST['email'];
// $password=$_POST['password'];
// 
// $q=mysqli_query($conn,"SELECT email FROM students WHERE email ='$email' AND password = '$password'");
// 
// 
// if(mysqli_fetch_object($q))
//  echo "success";
// else
//  echo "error";
 
 
?>