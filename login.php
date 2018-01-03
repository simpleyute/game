<?php
//check if user is authenticated

 require_once 'dbFunctions.php';
 
 include 'library/classFunctions.php';
$canvas = new classFunctions();


/////if a session is active and a user tries to login close that session
if(session_status()==PHP_SESSION_ACTIVE){
session_unset();
session_destroy();
}

 $canvas->newSession();

include("head.html");

 

 
 echo "<p></p><p></p><p></p><p></p><div class = \"container\">";
 
 if(isset($_GET["timeout"])){
     if($_GET["timeout"] =="true"){
     echo "<div class = \"errordiv\" >"
     ."Your session has timed out, please login once more."
     ."</div>";
     echo "<p></p>";
                            }
 }
 

 //login("students",array("firstname","lastname"),array("email" =>"=" , "password" =>"="),"email");
 
 if(isset($_POST['login'])){
     
 
 $result = $canvas->select("customer",array("password","id","usertype"),
         
         array(
             
             "WHERE"=> array(
                 "conditionTableName" => "email",
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
         
                NULL);
 $pw=$result->fetch_assoc();
 
 
 if(password_verify($_POST['password'], $pw["password"]))
 {
     $_SESSION["email"]=$_POST["email"];
     $_SESSION["userid"] = $pw["id"];
     $_SESSION["usertype"] = $pw["usertype"];
     
     
     header('Location:canvas.php');
     
     
     
 }
 else
 {
    echo "<div class = \"errordiv\"> Email or Password Incorrect. Please try again!</div><p></p> ";
 }
 
 
 
 }
 
 
echo "<form method = 'post' name = 'login' action = 'login.php' >";
 
$canvas->formInput("text","email","Your Email Address","email","textInput", "Email Address","","Your Email Address", array("pattern='[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*'"));
echo "<div class = \"divider\"></div>";
$canvas->formInput("password", "password", "Password", "login", "textInput","Your Login Password" ,"","Your Password",array(NULL));
echo "<div class = \"divider\"></div>";
 

$canvas->formInput("submit", "login", "", "", "","", "Login","",array(NULL));
 

echo "</form>";

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
 
 
 
echo "</div>";
include("foot.html");
 
?>