<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!class_exists("classFunctions")){
    
include_once ("/dbFunctions.php");
include '/library/classFunctions.php';
$canvas = new classFunctions();
$canvas->newSession();
}


include("head.html");

$canvas->submenu();


echo "<form method = 'post' name = 'email' action = 'email.php' >";
 
$canvas->formInput("text","email","Your Email Address","email","textInput", "Email Address","","Your Email Address", array("pattern='[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*'"));
echo "<div class = \"divider\"></div>";
echo "<textarea></textarea>";
echo "<div class = \"divider\"></div>";
 

$canvas->formInput("submit", "login", "", "", "","", "Send","",array(NULL));
 

echo "</form>";







echo "</div>";
include("foot.html");