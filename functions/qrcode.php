<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(!class_exists("classFunctions")){
    
include '../library/classFunctions.php';
$canvas = new classFunctions();
$canvas->newSession();
}

include("../library/phpqrcode/qrlib.php");

QRcode::png($canvas->csvReader("../upload/quotes.csv"));

?>