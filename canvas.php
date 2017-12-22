<?php
include_once ("dbFunctions.php");
include 'library/classFunctions.php';
$canvas = new classFunctions();

$canvas->newSession();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("head.html");


if(isset($_GET["site"])){
    if($_GET['site']==="account"){
        unset($_GET["site"]);
        include_once("account.php");
}else if($_GET["site"]==="admin"){
        unset($_GET["site"]);  
        
        include_once("admin.php");
}
 
}else

if($_SESSION ["usertype"]==1){
    include_once("business.php");
    
}else

if($_SESSION["usertype"]==2){
    
    include_once("customer.php");
}else
    
if($_SESSION["usertype"]==3){
    include_once("admin.php");
}



 
 //csvReader();

echo "</div>";
include("foot.html");
?>