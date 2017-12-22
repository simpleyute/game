<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if($_SESSION["usertype"]!=3){
    header('location:index.html');
}

$canvas->submenu();



$customerSql = "SELECT firstname,lastname,email,telephone,address,parish,id,usertype FROM customer";
$customer = $canvas->select(NULL,NULL,NULL,$customerSql);





 

echo "<table><tr><th>First Name</th><th>Last Name</th><th>E-Mail Address</th><th>Telephone Number</th><th>Address</th><th>Parish</th><th>User Type</th></tr>";
$rowNum=0;
$colNum=0;

while($row=$customer->fetch_assoc()){
    
    if($row["usertype"]!=3){
    echo "<tr>"
        . "<td contenteditable = \"true\" id = \"" .(string)$rowNum .(string)++$colNum ."\">"  .$row["firstname"] ."</td>"
            . "<td contenteditable = \"true\" id = \"" .(string)$rowNum .(string)++$colNum ."\">" .$row["lastname"] ."</td>"
            . "<td contenteditable = \"true\" id = \"" .(string)$rowNum .(string)++$colNum ."\">" .$row["email"] ."</td>"
            . "<td contenteditable = \"true\" id = \"" .(string)$rowNum .(string)++$colNum ."\">" .$row["telephone"] ."</td>"
            . "<td contenteditable = \"true\" id = \"" .(string)$rowNum .(string)++$colNum ."\">" .$row["address"] ."</td>"
            . "<td contenteditable = \"true\" id = \"" .(string)$rowNum .(string)++$colNum ."\">" .$row["parish"] ."</td>"
            . "<td contenteditable = \"true\" id = \"" .(string)$rowNum .(string)++$colNum ."\">" .$row["usertype"] ."</td>"; 
   
    echo "<tr><td><a href = \"#\" onclick = \"ajax(fields={'id' : " .$row["id"] ."},'POST','deleteUser.php')\">Delete</a></td>";
    echo "<td>E-Mail</td>";
    echo"<td><a href = \"#\" onclick = \"ajax(fields={'firstname' : $('#" .(string)$rowNum ."1').text()"  
                                                      .",'lastname': $('#" .(string)$rowNum ."2').text()"
                                                       .",'email': $('#" .(string)$rowNum ."3').text()"
                                                       .",'telephone': $('#" .(string)$rowNum ."4').text()"
                                                       .",'address': $('#" .(string)$rowNum ."5').text()"
                                                       .",'parish': $('#" .(string)$rowNum ."6').text()"
                                                       .",'usertype': $('#" .(string)$rowNum ."7').text()"
                                                       .",'id': ".$row["id"] 
                                                        ."},'POST','updateuser.php')\">Update</a></td></tr>";
    }
//reset column counter
    $colNum = 0;
    
    }

echo "</table>";
