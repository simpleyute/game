<?php require 'dbFunctions.php';

include("head.html");

if(isset($_POST['studentForm'])){
	

$q=	insertData2(array("email"=>$_POST['email'],
						 "password" => password_hash($_POST['password'], PASSWORD_DEFAULT) ,
						"firstname" => $_POST['firstname'] ,
						"lastname"=>$_POST['lastname'] ,
						"town"=>$_POST['town'] ,
						"telephone" =>$_POST['telephone'],
						 "parish"=>$_POST['parish']),
						
						"students","sssssis");

	unset($_POST);
	return $q;
	//header('Location:/backtoschool/index.php');
	}

?>
<p></p>

<form method = 'post' name = 'register' action = 'register.php' enctype="multipart/form-data">
    
<?php

formInput("text", "businessname", "Enter Business Name", "businessname", "textInput","Business Name" ,"","Your Business Name",array("pattern=''"));
echo "<div class = \"divider\"></div>";
formInput("text","email","Your Email Address","email","textInput", "Email Address","","Your Email Address", array("pattern='[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*'"));
echo "<div class = \"divider\"></div>";
formInput("text", "streetaddress", "Enter Street Address", "streetaddress", "textInput","Street Address" ,"","Your Street Address",array("pattern=''"));
echo "<div class = \"divider\"></div>";
formInput("text", "telephone", "Enter Telephone Number", "telephone", "textInput","Telephone Number" ,"","Your Business Telephone Number, Please Enter Numbers ONLY!",array("pattern='[0-9]{7,}'"));
echo "<div class = \"divider\"></div>";
formInput("text", "contact", "Contact Name", "businesscontactname", "textInput","Business Contact Name" ,"","Your Business Person Contact Name",array("pattern=''"));
echo "<div class = \"divider\"></div>";
echo "<label for = \"parish\"> Parish</label>";
parishGenerator("Parish");
echo "<div class = \"divider\"></div>";
formInput("file", "businesslogo", "Logo of Business", "businesslogo", "textInput","Business Logo" ,"","Your Business Logo",array("pattern=''"));
echo "<div class = \"divider\"></div>";
formInput("submit", "", "", "", "","", "submit","",array("pattern=''"));




?>
    
    
    
</form>    

<?php
include("foot.html");
?>

