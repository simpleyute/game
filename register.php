<?php require 'dbFunctions.php';

include("head.html");



echo "<div class = \"container\"";
echo "potty";
if(isset($_POST['businessname'])){
	echo "pot";

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
	
    
    
    $q=	insertData2(["name"=>$_POST['businessname'],
						 "email" => $_POST['email'] ,
						"address" => $_POST['address'] ,
						"telephone"=>$_POST['telephone'] ,
						"contact"=>$_POST['contact'] ,
						"logo" =>"test", //$_POST['logo'],
						 "parish"=>$_POST['parish']],
						
						"business","sssisss");

	unset($_POST);
        echo $q;
	return $q;
    
    
    
}

?>
<p></p>

<form method = 'post' name = 'register' action = 'register.php' enctype="multipart/form-data">
    
<?php

formInput("text", "businessname", "Enter Business Name", "businessname", "textInput","Business Name" ,"","Your Business Name",array(NULL));
echo "<div class = \"divider\"></div>";
formInput("text","email","Your Email Address","email","textInput", "Email Address","","Your Email Address", array("pattern='[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*'"));
echo "<div class = \"divider\"></div>";
formInput("text", "address", "Enter Street Address", "streetaddress", "textInput","Street Address" ,"","Your Street Address",array(NULL));
echo "<div class = \"divider\"></div>";
formInput("text", "telephone", "Enter Telephone Number", "telephone", "textInput","Telephone Number" ,"","Your Business Telephone Number, Please Enter At Least 7 Numbers ONLY!",array("pattern='[0-9]{7,}'"));
echo "<div class = \"divider\"></div>";
formInput("text", "contact", "Contact Name", "businesscontactname", "textInput","Business Contact Name" ,"","Your Business Person Contact Name",array(NULL));
echo "<div class = \"divider\"></div>";
echo "<label for = \"parish\"> Parish</label>";
parishGenerator("Parish");
echo "<div class = \"divider\"></div>";
/*formInput("file", "logo", "Logo of Business", "businesslogo", "textInput","Business Logo" ,"","Your Business Logo",array(NULL));
echo "<div class = \"divider\"></div>";*/
formInput("submit", "", "", "", "","", "submit","",array(NULL));




?>
    
    
    
</form>    
</div>
<?php
include("foot.html");
?>

