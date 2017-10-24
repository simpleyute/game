<?php require 'dbFunctions.php';

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

