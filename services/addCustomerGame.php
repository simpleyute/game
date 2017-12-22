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

    

$q=	$canvas->insertData2(["id_customer"=>$_GET['id_customer'],
						 "id_game"=>$_GET['id_game']],
						"customer_game","ii");
echo $q;