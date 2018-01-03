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


if($_SESSION["usertype"]!=3){
    header('location:logout.php');

}

$canvas->submenu();













if(isset($_POST['submit'])){
	  
    $q=	$canvas->insertData2(["name"=>$_POST['name'],
                              "gametype" => $_POST['gametype'] ,
                                                  
                            ],
            
						"game","ss");

	unset($_POST);
        //echo $q;
	if($q===FALSE){
            
            $canvas->writeLog("addgame" .time(),$q);
        }else
        {
            header("location:canvas.php?site=addgame");
            
        }
        


}




echo "<form method = 'post' name = 'addGame' action = 'addgame.php' >";
 
$canvas->formInput("text","name","Game Name","name","textInput", "The name of the game","","The name of the game", array(NULL));
echo "<div class = \"divider\"></div>";
echo "<select name = \"gametype\">"
        ."<option value = \"casual\" >Casual</option>"
        ."<option value = \"action\" >Action</option>"
        ."<option value = \"Role Playing\" >Role Playing</option>"
        ."<option value = \"racing\" >Racing</option>"
        ."<option value = \"fighting\" >Fighting</option>"
        ."";
echo "<div class = \"divider\"></div><br>";
 

$canvas->formInput("submit", "submit", "", "", "","", "submit","",array(NULL));
 

echo "</form>";

