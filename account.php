<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if($_SESSION["usertype"]==1 || $_SESSION["usertype"]==2 || $_SESSION["usertype"]==3){
    




$canvas->submenu();



echo "Upload Your Image Here!<br>";

echo "<form name = \"file\" method = \"post\" enctype = \"multipart/form-data\" action = \"functions/upload.php\" > ";
echo "<input type = \"submit\" name = \"submit\" >";
echo "<input type = \"file\"  name = \"file\" id = \"file\" required>";


echo "</form>";
}else{
    header('Location:index.html');
}