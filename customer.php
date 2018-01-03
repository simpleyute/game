<?php
//require 'dbFunctions.php';


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


if($_SESSION["usertype"]!=2){
    header('Location:index.html');
}


//get list of games
$gameSql = "SELECT * FROM game";
$game = $canvas->select(NULL,NULL,NULL,$gameSql);

$myGameSql = "SELECT name, gametype FROM game g "
        . "INNER JOIN customer_game cg ON cg.id_customer = " .$_SESSION["userid"]
        . " AND cg.id_game = g.id";
$myGame = $canvas->select(NULL,NULL,NULL,$myGameSql);





$canvas->submenu();
//$canvas->thumbnail("upload/" .$_SESSION["userid"] .".jpg\"");

///////////////////////
echo "<div class =\"infoBox\">"
. "Games---<form method=\"post\" action =  \"../functions/print.php\" style = \"display:inline;\"><input type=\"submit\" name=\"create_pdf\" class=\"btn btn-danger\" value=\"PDF\" /></form>"
        . "<div class = \"divider\"></div>";
 
$gamePrint = "<table><tr><th>Name</th><th>Game Type</th></tr>";
echo "<table><tr><th>Name</th><th>Game Type</th></tr>";
while($row=$game->fetch_assoc()){
    
    
    $gamePrint .= "<tr><td>"  .$row["name"] ."</td><td> " .$row["gametype"] ."</td></tr>"; 
    echo "<tr><td>"  .$row["name"] ."</td><td> " .$row["gametype"] ."</td>"; 
    echo "<td><a href = \"#\" onclick = \"ajax(fields={'id_game' : " .$row["id"] .", 'id_customer' : " . $_SESSION["userid"] ."},'GET','addCustomerGame.php')\">Add To My Games</a></td></tr>";

}
$gamePrint .= "</table>";
echo "</table>";

$_SESSION["print"]=$gamePrint;
 
echo "</div >";



///////////////////////
echo "<div class =\"infoBox\">"
. "My Games---<form method=\"post\" action =  \"../functions/print.php\" style = \"display:inline;\"><input type=\"submit\" name=\"create_pdf\" class=\"btn btn-danger\" value=\"PDF\" /></form>"
        . "<div class = \"divider\"></div>";
 
$gamePrint = "<table><tr><th>Name</th><th>Game Type</th></tr>";
echo "<table><tr><th>Name</th><th>Game Type</th></tr>";
while($row=$myGame->fetch_assoc()){
    
    
    $gamePrint .= "<tr><td>"  .$row["name"] ."</td><td> " .$row["gametype"] ."</td></tr>"; 
    echo "<tr><td>"  .$row["name"] ."</td><td> " .$row["gametype"] ."</td>"; 
  

}
$gamePrint .= "</table>";
echo "</table>";

$_SESSION["print"]=$gamePrint;
 
echo "</div >";
////////////////////////////////////////////









echo "</div>"; // closes container

?>