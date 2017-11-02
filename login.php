<?php

 
 require 'dbFunctions.php';
 
 

 login("students",array("firstname","lastname"),array("email" =>"=" , "password" =>"="),"email");
 
 
 
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