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


////////////////////////////////////////////////////////////////
if($_SESSION ["usertype"]==1){
   
    
    if(isset($_GET["site"])){

if($_GET['site']==="account"){
        unset($_GET["site"]);
        include_once("account.php");        
}else

if($_GET['site']==="business"){
        unset($_GET["site"]);
        include_once("business.php");        
}else

if($_GET["site"]==="contact"){
        unset($_GET["site"]);  
        include_once("contact.php");
}


    }

else    
{
        include_once("business.php");
}

 
}

////////////////////////////////////////////////////////////////    
  


if($_SESSION["usertype"]==2){

    if(isset($_GET["site"])){

if($_GET['site']==="account"){
        unset($_GET["site"]);
        include_once("account.php");
                            }else
                            
if($_GET['site']==="customer"){
        unset($_GET["site"]);
        include_once("customer.php");
                            }else

if($_GET["site"]==="contact"){
        unset($_GET["site"]);  
        include_once("contact.php");
}
                            
    
                            }
else
    {    
          include_once("customer.php");
}
  
}
  


if ($_SESSION["usertype"]==3){

    if(isset($_GET["site"])){
    
if($_GET["site"]==="addgame"){
        unset($_GET["site"]);  
        include_once("addgame.php");
}else

if($_GET["site"]==="admin"){
        unset($_GET["site"]);  
        include_once("admin.php");
}else

if($_GET["site"]==="account"){
        unset($_GET["site"]);  
        include_once("account.php");
}else

if($_GET["site"]==="contact"){
        unset($_GET["site"]);  
        include_once("contact.php");
}


    }
    
    else
    {


    include_once("admin.php");

    }
    }



 
 //csvReader();

echo "</div>";
include("foot.html");
?>