<?php

/*

$servername = "sql9.freesqldatabase.com";
$username = "sql9197975";
$password = "ntSXEkEaVA";
$dbname = "sql9197975";
$conn = mysqli_connect($servername, $username, $password,$dbname);
*/

/*$servername = "sql111.byethost16.com";
$username = "ja_mobilepp";
$password = "ja_mobilepp";
$dbname = "ja_mobilepp";
$conn = mysqli_connect($servername, $username, $password,$dbname);
*/

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "b16_20204216_game";
$conn = mysqli_connect($servername, $username, $password,$dbname);

if ($conn->connect_errno) {
die("<br />Could not connect to MySQLi Database: " . $conn->connect_error);
}


//ja_mobilepp  
header("Access-Control-Allow-Origin: *");


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

function schoolGenerator(){
	echo "
<select name='school_id' id='school'>
<option value = '-1'>Parish</option>
<option value = '1'>Manchester High School</option>
<option value = '2'>STETHS</option>
<option value = '3'>Albert Town High School</option>
<option value = '4'>Spanish Town Primary</option>
<option value = '5'>Mandeville Infant School</option>
<option value = '6'>Pembroke Hall High School</option>
<option value = '7'>Cornwall College</option>
<option value = '8'>Wolmers Girl</option>
<option value = '9'>Clarendon College</option>
<option value = '10'>Marcus Garvey High School</option>
<option value = '11'>Manchester Evening Institute</option>
<option value = '12'>St.Thomas Technical High School</option>
<option value = '13'>St. Jago High School</option>
</select>	
	";
}


function schoolLevel(){
	echo "
<select name='schoollevel' id='schoollevel'>
<option value = '-1'>School Level</option>
<option value = '1'>Infant</option>
<option value = '2'>Primary/Preparatory</option>
<option value = '3'>High School</option>

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
    //echo $sql;
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
//             printf("Error: %s.\n", $stmt->error);
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
function select($table,$selectColumns,$whereColumns,$cleanList){

    //$table: name of database table, string
    //$selectColumns: comma seperated columns to be selected, string
    //$whereColumns:     //$whereColumns: name of columns in where critera 
    //name of columns in where criterion: array
    //$cleanList: name of list of selectable columns
global $conn;

$sql = "SELECT ". implode(",",$selectColumns) ." FROM " .$table ." "; // top of SELECT sql command
	

foreach ($whereColumns as $name => $value ){
  $sql .= $name ." " .$value["conditionTableName"] ." " .$value["symbol"]  ." ? " .$value["connector"] ." ";
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

if(strpos($sql,"?")!==FALSE){
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

    
    }
	
}
else{
    $result=mysql_query($sql);
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

$sql = "DELETE FROM  ".$table ."  WHERE ("; // top of DELETE sql command
	

foreach ($whereColumns as $name => $value ){
  $sql .= $name ." " .$value["symbol"] ." ? " .$value["connector"] ." ";
  }

	
        $sql .=")";


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
function update($table,$setColumns,$whereColumns,$cleanList){

    //$table: name of database table, string
    //$selectColumns: comma seperated columns to be selected, string
    //$whereColumns:     //$whereColumns: name of columns in where critera 
    //name of columns in where criterion: array
    //$cleanList: name of list of selectable columns
global $conn;

$sql = "UPDATE ".$table ."  SET "; // top of DELETE sql command
	


foreach ($setColumns as $name => $value ){
  $sql .= $name ." " .$value["symbol"] ." ? " ." , ";
  }

$sql = rtrim($sql,','); // this rtrim function will remove the trailing comma at the end of the previous foreach loop	
        $sql .=" WHERE ";


foreach ($whereColumns as $name => $value ){
  $sql .= $name ." " .$value["symbol"] ." ? " ." , ";
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
        $param_value[$keys[$i]]=&$setColumns[$keys[$i]]["data"]; //passes a reference to the data in the fields array to the indexed param_value array	
	$i++;
        $types .= "s";
}


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
                
                
                echo " <input ";
                
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
$fh = fopen($file, 'w') or die('Could not open file!');
// write to file 
fwrite($fh, $service .": " .$data ."\n") or die('Could not write to file');
// close file
fclose($fh);
}




?>
