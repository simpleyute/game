<?php

 
 require 'dbFunctions.php';
 
 

 //login("students",array("firstname","lastname"),array("email" =>"=" , "password" =>"="),"email");
 
 
 $pw = select("students",array("password"),
         
         array(
             
             "email"=> array(
                 "symbol"=> "=",
                 "data" => $_POST['email'],
                 "connector"=>NULL)),
//                    ),
//             
//              "password"=> array(
//                 "symbol"=> "=",
//                 "data" => $_POST['password'],
//                 "connector"=>"AND"
//                    )
//               ),
         
                "email");
 echo $pw;
 
 if(password_verify($_POST['password'], $pw))
 {
     echo "success";
     
 }
 else
 {
     echo "error";
 }
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