<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'dbFunctions.php';

include 'library/classFunctions.php';
$canvas = new classFunctions();


include("head.html");



echo "<div class = \"container\">";

if(isset($_POST['email'])){
	

//$q=	insertData2(array("email"=>$_POST['email'],
//						 "password" => password_hash($_POST['password'], PASSWORD_DEFAULT) ,
//						"firstname" => $_POST['firstname'] ,
//						"lastname"=>$_POST['lastname'] ,
//						"town"=>$_POST['town'] ,
//						"telephone" =>$_POST['telephone'],
//						 "parish"=>$_POST['parish']),
//						
//						"students","sssssis");
//
//	unset($_POST);
//	return $q;
	//header('Location:/backtoschool/index.php');
	
    
    
    $q=	$canvas->insertData2(["firstname"=>$_POST['firstname'],
						 "lastname" => $_POST['lastname'] ,
                                                  "email" => $_POST['email'] ,
						"address" => $_POST['address'] ,
						"telephone"=>$_POST['telephone'] ,
						"password" => password_hash($_POST['password'], PASSWORD_DEFAULT) , //$_POST['logo'],
						 "parish"=>$_POST['parish'],
                                                "usertype"=>$_POST['usertype']],
            
						"customer","ssssisss");

	unset($_POST);
        echo $q;
	if($q===true){
            
            header('Location:login.php');
        }else
        {
            
            $canvas->writeLog("customer-register.php",$q);
        }
        
        
       
    
    
    
}

?>
<p></p>

<form method = 'post' name = 'register' action = 'register.php' enctype="multipart/form-data">
    
<?php

$canvas->formInput("text", "firstname", "Enter Your First Name", "firstname", "textInput","First Name" ,"","Your First Name",array(NULL));
echo "<div class = \"divider\"></div>";
$canvas->formInput("text", "lastname", "Enter Your Last Name", "lastname", "textInput","Last Name" ,"","Your Last Name",array(NULL));
echo "<div class = \"divider\"></div>";

$canvas->formInput("text","email","Your Email Address","email","textInput", "Email Address","","Your Email Address", array("pattern='[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*'"));
echo "<div class = \"divider\"></div>";
$canvas->formInput("password", "password", "Password", "password", "textInput","Your Login Password" ,"","At least 8 character including one uppercase",array("pattern='(?![0-9]{6,})[0-9a-zA-Z]{6,}'"));
echo "<div class = \"divider\"></div>";
$canvas->formInput("text", "address", "Enter Street Address", "streetaddress", "textInput","Street Address" ,"","Your Street Address",array(NULL));
echo "<div class = \"divider\"></div>";
$canvas->formInput("text", "telephone", "Enter Telephone Number", "telephone", "textInput","Telephone Number" ,"","Your Business Telephone Number, Please Enter At Least 7 Numbers ONLY!",array("pattern='[0-9]{7,}'"));
echo "<div class = \"divider\"></div>";
echo "<label for = \"parish\"> Parish</label>";
$canvas->parishGenerator("Parish");
echo "<div class = \"divider\"></div>";
echo "<label for = \"usertype\">You are a...</label>";
echo "<select name =\"usertype\" id = \"usertype\">"
. "<option value = \"-1\">Register As</option>"
. "<option value = \"1\">Business</option>"
. "<option value = \"2\">Gamer</option>"
. "</select>";
echo "<div class = \"divider\"></div>";
$canvas->formInput("submit", "", "", "", "","", "submit","",array(NULL));




?>
    
    
    
</form>    
</div>
<?php
include("foot.html");
?>

