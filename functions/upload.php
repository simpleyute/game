<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once ("../dbFunctions.php");
include '../library/classFunctions.php';
$canvas = new classFunctions();

$canvas->newSession();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include("../head.html");


if(isset($_POST["submit"])){
//  if( $_SERVER['REQUEST_METHOD']=='POST'){  
    

        if(isset($_FILES["file"]["name"])){
            //check for error
            
            $fileType = strtolower(pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION));
            
            if($_FILES["file"]["error"]>0){
                $canvas->writeLog("upload",$_FILES["file"]["error"]);
                echo $_FILES["file"]["error"];
            }else{
                echo "FILE SIZE: " .$_FILES["file"]["size"] / 1024 ." Kb";
                
            }
            
            //check if file already exits
            if(file_exists("../upload/" . $_SESSION["userid"])){
                echo "FILE ALREADY EXIST";
            } elseif ($fileType!="jpg" && $fileType!="jepg") {
                echo "JPG or JPEG only";
            //    return;
            }
            
            
            else{
                //save file to directory
                $storagename = $_SESSION["userid"] . substr($_FILES["file"]["name"], stripos($_FILES["file"]["name"], "."));
                move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/" .$storagename);
                echo "file stored";
                header('location:../canvas.php');
            }
        }else{
            echo "not seeing file";
            echo $_FILES["file"]["error"];
        }
        
        }else { 
            echo "no file selected";
            }
            
          
            
            ?>