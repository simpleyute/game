<?php

//include 'library/classFunctions.php';
//$canvas = new classFunctions();

if($_SESSION["usertype"]!=1){
    header('Location:index.html');
}



//echo 
// "<div class = \"submenubar\">"
//            ."<div class=\"submenuitem\" id=\"userwelcome\">"
//                ."Welcome " .$_SESSION["email"] .", <a href=\"logout.php\">Logout</a>"
//            ."</div>"
//            ."<div class=\"submenuitem\" id=\"userwelcome\">"
//            ."<a href = \"functions/QRcode.php\">Scan QR Code for today's quote</a>"
//            ."</div>"
//
//        ."</div>";
//        
//echo "<div class = \"container\"> <p></p>";

$canvas->submenu();

//get list of customers
$customerSql = "SELECT c.firstname,c.lastname FROM customer c "
            . "INNER JOIN business_customer bc ON c.id = bc.id_customer"
            . " AND bc.id_business=" .$_SESSION["userid"] ;

$customers = $canvas->select(NULL,NULL,NULL,$customerSql);

$promotionsSql = "SELECT g.name FROM game g "
            . "INNER JOIN business_game bg ON g.id = bg.id_game"
            . " AND bg.id_business=" .$_SESSION["userid"] ;

$promotions = $canvas->select(NULL,NULL,NULL,$promotionsSql);




///////////////////////
echo "<div class =\"infoBox\">"
. "Customers---<form method=\"post\" action =  \"functions/print.php\" style = \"display:inline;\"><input type=\"submit\" name=\"create_pdf\" class=\"btn btn-danger\" value=\"PDF\" /></form>"
        . "<div class = \"divider\"></div>";
   

$customerPrint = "";
while($row=$customers->fetch_assoc()){
    $customerPrint = "<table><tr><th>First Name</th><th>Last Name</th></tr>";
    
    $customerPrint.= "<tr><td>"  .$row["firstname"] ."</td><td> " .$row["lastname"] ."</td></tr>"; 
  // 
    $customerPrint.= "</table>";
}

echo $customerPrint;

$_SESSION["print"]=$customerPrint;
 
echo "</div >";








echo "<div class =\"infoBox\">"
. "Promotions---<form method=\"post\" action =  \"functions/print.php\" style = \"display:inline;\"><input type=\"submit\" name=\"create_pdf\" class=\"btn btn-danger\" value=\"PDF\" /></form>"
        . "<div class = \"divider\"></div>";
     

$promotionsPrint="";
while($row=$promotions->fetch_assoc()){
    $promotionsPrint = "<table><tr><th>GAME NAME</th></tr>";
    
    $promotionsPrint.= "<tr><td>"  .$row["name"] ."</td></tr>"; 
  //  echo "<a href = \"#\" onclick = \"ajax(fields={'id_game' : 1, 'id_business' : 12},'GET','addgame.php')\">Add To My Games</a> <br>";
    $promotionsPrint.= "</table>";
}



$_SESSION["print"]=$promotionsPrint;
 echo "</div >";

 
 
 echo "</div>"; //closes container div