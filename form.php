<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
 require 'dbFunctions.php';
 
// generateForm("test","post","mail.php",
// array(
//     "input" =>array(
//    "type" => "text",
//     "id" => "firstname",
//     "placeholder"=>"Enter First Name Here",
//      "label" =>"First Name"
//         
//                    )
//     )
// );
 
 echo "<form method = 'post' name = 'login' action = 'login.php'>";
 
 formInput("text", "email", "Enter Last Name", "lastname", "FrontHeader","Last Name" ,"","Valid E-Mail Address",array("pattern=''"));
 echo "<br>";
 formInput("password", "password", "Please enter Your password", "pw", "FrontHeader", "Password","");
 echo "<br>";
 
 
 formInput("radio","gender","","","","male","male"); 
 formInput("submit", "", "", "", "","", "submit");
 
 echo "</form>";
 
 ?>