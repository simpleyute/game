<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classFunctions
 *
 * @author GTS
 */
class classFunctions {
    //put your code here
    //
    function parishGenerator($name){
	echo "
<select name='parish' id='parish'>
<option value = '-1'>"; echo $name; echo "</option>
<option value = 'Kingston and St.Andrew'>Kingston and St.Andrew</option>
<option value = 'St.Elizabeth'>St.Elizabeth</option>
<option value = 'Trelawny'>Trelawny</option>
<option value = 'St.James'>St.James</option>
<option value = 'Hanover'>Hanover</option>
<option value = 'Westmoreland'>Westmoreland</option>
<option value = 'St.Catherine'>St.Catherine</option>
<option value = 'St.Mary'>St.Mary</option>
<option value = 'Clarendon'>Clarendon</option>
<option value = 'St.Ann'>St.Ann</option>
<option value = 'Manchester'>Manchester</option>
<option value = 'St.Thomas'>St.Thomas</option>
<option value = 'Portland'>Portland</option>
</select>	
	";
}












/*
This functions takes two arguments, the first is an array with the columns and data to be inserted in the 
database, the second is the name of the table to be used. The third parameter -$types- is used for biding 
the data to the query using the msqli_stmt::bind_param

*/

function insertData2($fields,$table,$types){
global $conn;

$sql = "INSERT INTO " .$table ." ("; // top of insert sql command
$sqlValues=") VALUES ("; // begining of the VALUES section of the insert statement


 foreach ($fields as $name => $value){
 $sql .= $name .",";
 $sqlValues .= "?,";
 
 if($value===""){
     die();
 }
     
 
  }
	
	$sql = rtrim($sql,','); // this rtrim function will remove the trailing comma at the end of the previous foreach loop
	$sqlValues = rtrim($sqlValues,','); // this rtrim function will remove the trailing comma at the end of the previous foreach loop
	$sqlValues .= ");"; //adds the closing parentheses to the value section of the sql statement
	
$sql .= $sqlValues; //concatenates the insert and values section of the statement
	

//echo $sql;







//the param_value array will be used when using the call_user_func_array 
//function. It will be populated with the reference addresses of the parameters
//we need for the call_user_func_array
$param_value=array(); 



$i=0;
$i++;
foreach($fields as $key => $value)
{
        $fields[$key] = $conn->real_escape_string($fields[$key]); // escapes user input of certain characters by adding a "/"
	$param_value[$i]=&$fields[$key]; //passes a reference to the data in the fields array to the indexed param_value array
	
	$i++;
}

//echo "I IS:" .$types;

array_unshift($param_value,$types); //inserts the parameter needed for the prepared statement at the top of the param_value array



////



/*
 * 
 * from the $dynamic sql statement, create a prepared statement. This will assist us in not allowing
unclean values being sent to the database which may cause an SQL injection
The $mysqli->prepare object oriented function returns either false of an object
as such we put it in an if statement to test if it will return false with the prepared
statement, if not it will continue to bind the values to the sql statement, if false
it will write an ERROR to a log file, and cordially inform the user of an error.
*/

 
 $stmt = $conn->stmt_init();
if($stmt){ 
    
//   print_r($param_value);
   
        if(!$stmt->prepare($sql)){
            echo "Please contact system administrator.";
        }

        //this function will call the bind parameters function and pass the
        //$param_value array as parameters
	call_user_func_array(array($stmt,'bind_param'), $param_value); 
	if($stmt->execute()) { //execute prepared statement
	return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            
        return $stmt->error;
        }
}

	
	
	

/*
if(mysqli_query($conn,$sql)==true)
{
 echo "success";
}
else
{
	echo "error";
	//echo $sql;
}
*/      
}





///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
function select($table,$selectColumns,$whereColumns,$customSql){

    //$table: name of database table, string
    //$selectColumns: comma seperated columns to be selected, string
    //$whereColumns:     //$whereColumns: name of columns in where critera 
    //name of columns in where criterion: array
    //$cleanList: name of list of selectable columns
global $conn;


if ($customSql===NULL){
$sql = "SELECT ". implode(",",$selectColumns) ." FROM " .$table ." "; // top of SELECT sql command
	

foreach ($whereColumns as $name => $value ){
  if ($name !=NULL){
       $sql .= $name ." " .$value["conditionTableName"] ." " .$value["symbol"]  ." ? " .$value["connector"] ." ";
  }
   
  }

	
        //$sql .=")";


//echo $sql;










//the param_value array will be used when using the call_user_func_array 
//function. It will be populated with the reference addresses of the parameters
//we need for the call_user_func_array
$param_value=array(); 
$i=0;
$types=NULL; //types is the types of variable which will be used in the bind_param function

$keys = array_keys($whereColumns); // used to index an associative array ;)
foreach($whereColumns as $key =>  $value)
{
        $param_value[$keys[$i]]=&$whereColumns[$keys[$i]]["data"]; //passes a reference to the data in the fields array to the indexed param_value array	
	$i++;
        $types .= "s";
}

/*
 * 
 * from the $dynamic sql statement, create a prepared statement. This will assist us in not allowing
unclean values being sent to the database which may cause an SQL injection
The $mysqli->prepare object oriented function returns either false of an object
as such we put it in an if statement to test if it will return false with the prepared
statement, if not it will continue to bind the values to the sql statement, if false
it will write an ERROR to a log file, and cordially inform the user of an error.
*/

$stmt = $conn->stmt_init();
if($stmt){
  
  
    
    $stmt->prepare($sql);
    
		

   //inserts the types types variable to the top ofthe array
   array_unshift($param_value,$types);

   //this function will call the bind parameters function and pass the
   //$param_value array as parameters
    call_user_func_array(array($stmt,'bind_param'), $param_value); 
    
    $stmt->execute(); //execute prepared statement      
    $result=$stmt->get_result(); // gets a result set
    
    /* free results */
   $stmt->free_result();
   /* close statement */
   $stmt->close();
    
   return $result; 

    
    }else{
        die($conn->error);
    }
	

}else{
    
    $result=$conn->query($customSql) or die($conn->error);
            
    return $result;
}
}




///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
function delete($table,$whereColumns,$cleanList){

    //$table: name of database table, string
    //$selectColumns: comma seperated columns to be selected, string
    //$whereColumns:     //$whereColumns: name of columns in where critera 
    //name of columns in where criterion: array
    //$cleanList: name of list of selectable columns
global $conn;

$sql = "DELETE FROM  ".$table ." "; // top of DELETE sql command
	

foreach ($whereColumns as $name => $value ){
  if ($name !=NULL){
       $sql .= $name ." " .$value["conditionColumnName"] ." " .$value["symbol"]  ." ? " .$value["connector"] ." ";
  }
   
  }


//echo $sql;


//the param_value array will be used when using the call_user_func_array 
//function. It will be populated with the reference addresses of the parameters
//we need for the call_user_func_array
$param_value=array(); 

$i=0;
$types=NULL; //types is the types of variable which will be used in the bind_param function

$keys = array_keys($whereColumns); // used to index an associative array ;)
foreach($whereColumns as $key =>  $value)
{
        $param_value[$keys[$i]]=&$whereColumns[$keys[$i]]["data"]; //passes a reference to the data in the fields array to the indexed param_value array	
	$i++;
        $types .= "i";
}
echo $sql;
/*
 * 
 * from the $dynamic sql statement, create a prepared statement. This will assist us in not allowing
unclean values being sent to the database which may cause an SQL injection
The $mysqli->prepare object oriented function returns either false of an object
as such we put it in an if statement to test if it will return false with the prepared
statement, if not it will continue to bind the values to the sql statement, if false
it will write an ERROR to a log file, and cordially inform the user of an error.
*/


$stmt = $conn->stmt_init();
if($stmt){
   $stmt->prepare($sql);
    
		

   //inserts the types types variable to the top ofthe array
   array_unshift($param_value,$types);

   //this function will call the bind parameters function and pass the
   //$param_value array as parameters
    call_user_func_array(array($stmt,'bind_param'), $param_value); 
       
    if($stmt->execute()){ //execute prepared statement      
    
    /* free results */
   $stmt->free_result();
   /* close statement */
   $stmt->close();
    
   return true; 

    
    }
    return false;
}

}





///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
function update($table,$setColumns,$whereColumns,$customSql){

    //$table: name of database table, string
    //$selectColumns: comma seperated columns to be selected, string
    //$whereColumns:     //$whereColumns: name of columns in where critera 
    //name of columns in where criterion: array
    //$cleanList: name of list of selectable columns
global $conn;

$sql = "UPDATE ".$table ."  SET "; // top of DELETE sql command
	


foreach ($setColumns as $name => $value ){
  $sql .= $name ." = " ." ? " ." , ";
  }

$sql = rtrim($sql,' , '); // this rtrim function will remove the trailing comma at the end of the previous foreach loop	
  



foreach ($whereColumns as $name => $value ){
  if ($name !=NULL){
       $sql .= " " .$name ." " .$value["conditionColumnName"] ." " .$value["symbol"]  ." ? " ;
  }
   
  }

  
  
  
        
$sql = rtrim($sql,','); // this rtrim function will remove the trailing comma at the end of the previous foreach loop	        
$sql .=" ;";        

//echo $sql;


//the param_value array will be used when using the call_user_func_array 
//function. It will be populated with the reference addresses of the parameters
//we need for the call_user_func_array
$param_value=array(); 

$i=0;
$types=NULL; //types is the types of variable which will be used in the bind_param function

$keys = array_keys($setColumns); // used to index an associative array ;)
foreach($setColumns as $key =>  $value)
{
        //$param_value[$keys[$i]]=&$setColumns[$keys[$i]]["data"]; //passes a reference to the data in the fields array to the indexed param_value array	
    $param_value[$i]=&$setColumns[$key]; //passes a reference to the data in the fields array to the indexed param_value array	
	$i++;
        $types .= "s";
}


$keys = array_keys($whereColumns); // used to index an associative array ;)
foreach($whereColumns as $key =>  $value)
{
//        $param_value[$keys[$i]]=&$whereColumns[$keys[$i]]["data"]; //passes a reference to the data in the fields array to the indexed param_value array	
    
    
    $param_value[$i]=&$whereColumns[$key]["data"]; //passes a reference to the data in the fields array to the indexed param_value array	
    $i++;
        $types .= "s";
}
/*
 * 
 * from the $dynamic sql statement, create a prepared statement. This will assist us in not allowing
unclean values being sent to the database which may cause an SQL injection
The $mysqli->prepare object oriented function returns either false of an object
as such we put it in an if statement to test if it will return false with the prepared
statement, if not it will continue to bind the values to the sql statement, if false
it will write an ERROR to a log file, and cordially inform the user of an error.
*/


$stmt = $conn->stmt_init();
if($stmt){
   $stmt->prepare($sql);
    
		

   //inserts the types types variable to the top ofthe array
   array_unshift($param_value,$types);

   //this function will call the bind parameters function and pass the
   //$param_value array as parameters
    call_user_func_array(array($stmt,'bind_param'), $param_value); 
       
   if( $stmt->execute()){ //execute prepared statement      
    
    /* free results */
   $stmt->free_result();
   /* close statement */
   $stmt->close();
    
   
return true;
   }
   return false; 
    }
	

}





//function generateForm($formName,$method,$action,$inputElements){
//    
//    echo "<form name='" .$formName ."' " ." method = '" .$method ."' " ."action = '" .$action ."' " .">";
//    
//    foreach($inputElements as $key => $value ){
//        
//        //////////////////////////////////
//        
//       
//        
//        switch($key){
//            
//            case 'input':
//                
//                echo "<label for = '";
//                if(array_key_exists('id',$inputElements[$key]))
//                { echo $inputElements[$key]["id"];}
//                echo "' > ";
//                
//                if(array_key_exists('label',$inputElements[$key]))
//                { echo $inputElements[$key]["label"];}
//                
//                echo "</label>";
//                
//                
//                echo "<input ";
//                
//                if(array_key_exists('type',$inputElements[$key]))
//                    {echo "type ='" .$inputElements[$key]["type"] ."'";}
//                                 
//                if(array_key_exists('name',$inputElements[$key]))  
//                    { echo "name ='" .$inputElements[$key]["name"] ."'";}
//                    
//                if(array_key_exists('class',$inputElements[$key])) 
//                    { echo"class ='" .$inputElements[$key]["class"] ."'";}
//                
//                 if(array_key_exists('id',$inputElements[$key]))                   
//                    { echo "id ='" .$inputElements[$key]["id"] ."'";}
//                    
//                if(array_key_exists('placeholder',$inputElements[$key]))                   
//                    { echo "placeholder ='" .$inputElements[$key]["placeholder"] ."'";}
//                    
//                    echo " >";
//            ;
//            
//            
//        } //closes switch
//        
//        
//        
//        
//        
//        
//        
//        
//        
//    }//closes foreach
//    
//    
//    echo "<input type = 'submit' vaule='Submit' > <input type = 'reset' value = 'Reset'>";
//    echo "</form>";
//    
//
//}



function formInput($type, $name, $placeholder, $id,$class,$label, $value,$title, $additionalAttributes){

    echo "<label for = '";
                if($id!=NULL)
                { echo $id;}
                echo "' > ";
                
                if($label!=NULL)
                { echo $label;}
                              
                echo " </label> ";
                
                
                echo " <input required=\"required\"";
                
                if($type!=NULL)
                { echo " type = '" .$type ."' ";}
                                                     
                if($name!=NULL)
                { echo " name = '" .$name  ."' ";}  
                
                if($placeholder!=NULL)
                { echo " placeholder = '" .$placeholder  ."' ";}
                
                if($id!=NULL)
                { echo " id = '" .$id  ."' ";}
                
                if($class!=NULL)
                { echo " class = '" .$class  ."' ";}
                
                if($label!=NULL)
                { echo " label = '" .$label  ."' ";}
                
                 if($value!=NULL)
                { echo " value = '" .$value  ."' ";}
                
                 if($title!=NULL)
                { echo " title = '" .$title  ."' ";}
                
                if(isset($additionalAttributes)){
                foreach($additionalAttributes as $value)
                {
                    if ($value!==NULL){
                    echo $value;
                    }
                }
                }
                
                echo " > ";
                
                
    
}




function writeLog($service,$data){
    
$file = 'log.txt';
// open file 
$fh = fopen($file, 'a') or die('Could not open file!');
// write to file 
fwrite($fh, $service .": " .$data ."\n") or die('Could not write to file');
// close file
fclose($fh);
}

//function firstRunTest($service,$data){
//    
////checks if the file start exists or not and return the true or false
//$file = 'start';
//return (file_exists($file));
//
//}


function newSession(){
//    if(isset($_SESSION['email'])){
//       if($_SESSION['email']=="UNAUTH"){
////        echo "Please Login Again!";
//          header('Location:index.html');
//        
//       }
//}
session_start();
 if (isset($_SESSION['closed'])) {
       if ($_SESSION['closed'] < time()-900) {
           //if the 'closed' key of $_SESSION is less than the current time minus 
           //15 minutes then end the session as this could be an attacker
           //using an old session ID to gain access to the current session
           //it could also be an unstable network or the user has not had any activity 
           //for the past 15 minutes. The system will then log out the user
       
           //$_SESSION['email']="UNAUTH"; //UNAUTH indicates that the user is not authenticated
           //return;
       
        header('Location:logout.php?timeout=true');
       }else{


 
$_SESSION['closed'] = time(); // create a approximate time stamp of when session id was destroyed 
session_regenerate_id();
ini_set('session.use_strict_mode', 1);
 //unset($_SESSION['closed']);
}

}
}



function csvReader($file){
    $row = 1;
if(($handle = fopen($file,"r"))!==FALSE){
    
    
//    while(($data = fgetcsv($handle,1000,"#"))!==FALSE){
//        $num = count ($data);
//       echo "<p> $num fields in line $row: <br/></p>\n";
//        $row++;
//        
//        for($c=0;$c<$num;$c++){
//            echo $data[$c] . "<br/> \n";
//        }
//    }
            
if(($data = fgetcsv($handle,1000,"#"))!==FALSE)
{
    $num =  count ($data); //get number of fields in csv
    $quote=$data[rand(0,$num-1)]; 
    fclose($handle);
    return $quote;
}else{
//echo "NUM: " .$num;

fclose($handle);
return "Smart";
    
}

}
}


function submenu(){
    echo 
 "<div class = \"submenubar\">";
            
    echo "<div class=\"submenuitem\" id=\"userwelcome\">";
    
    if($_SESSION["usertype"]==1){ 
            echo "<a href = \"canvas.php?site=business\">HOME</a>";
    }
    
    if($_SESSION["usertype"]==2){ 
            echo "<a href = \"canvas.php?site=customer\">HOME</a>";
    }
    
    if($_SESSION["usertype"]==3){ 
            echo "<a href = \"canvas.php?site=admin\">HOME</a>";
    }
    
    echo "</div>";
 
    
    echo "<div class=\"submenuitem\" id=\"userwelcome\">"
                ."Welcome " .$_SESSION["email"] .", <a href=\"logout.php\">Logout</a>"
            ."</div>"
            
            ."<div class=\"submenuitem\" id=\"userwelcome\">"
            ."<a href = \"functions/QRcode.php\">Scan QR Code for today's quote</a>"
            ."</div>"
    
            ."<div class=\"submenuitem\" id=\"userwelcome\">"
            ."<img src= \"upload/" .$_SESSION["userid"] .".jpg\" width = \"50px\" height = \"50px\">";
            echo "</div>";
            

    if($_SESSION["usertype"]==3){
            echo "<div class = \"submenuitem\"><a href = \"canvas.php?site=admin\">ADMIN SECTION</a></div>";
            echo "<div class = \"submenuitem\"><a href = \"canvas.php?site=addgame\">Add Game</a></div>";
           
            }

echo "</div>";


echo "<div class = \"container\"> <p></p>";

}

function thumbnail($path){
    
    $pic = new \Imagick(realpath($path));
    $pic->setbackgroundcolor('rgb(64,64,64)');
    $pic->thumbnailimage(100,100,true,true);
    header("Content-Type:image/");
    echo $pic->getimageblob();
}

}