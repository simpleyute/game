<?php

 
 require 'dbFunctions.php';
 
 

 //login("students",array("firstname","lastname"),array("email" =>"=" , "password" =>"="),"email");
 
 echo "fsdfds";
 $result = delete("students",
         
         array(
             
             "email"=> array(
                 "symbol"=> "=",
                 "data" => $_POST['email'],
                 "connector"=>"")),
//                    ),
//             
//              "password"=> array(
//                 "symbol"=> "=",
//                 "data" => $_POST['password'],
//                 "connector"=>"AND"
//                    )
//               ),
         
                "email");

 
 if($result==true)
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