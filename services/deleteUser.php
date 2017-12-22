<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../dbFunctions.php';
include '../library/classFunctions.php';
$canvas = new classFunctions();
$canvas->newSession();

    
echo $_POST["id"];
$q=	$canvas->delete("customer",
        
        
        array(
             
             "WHERE"=> array(
                 "conditionColumnName" => "id",
                 "symbol"=> "=",
                 "data" => $_POST['id'],
                 "connector"=>"")),
        
        
        NULL);