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

    

$q=	$canvas->update("customer",
        
        
        array(
             
             
             "firstname" => $_POST['firstname'] ,
             "lastname" => $_POST['lastname'] ,
             "email" => $_POST['email'] ,
             "address" => $_POST['address'] ,
             "telephone" => $_POST['telephone'] ,
             "parish" => $_POST['parish'] ,
             "usertype" => $_POST['usertype'] ,
            ),
        
        
         array(
             
             "WHERE"=> array(
                 "conditionColumnName" => "id",
                 "symbol"=> "=",
                 "data" => $_POST['id'],
                 "connector"=>"")),"");