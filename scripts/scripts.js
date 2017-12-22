/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function welcomeUser(user){
    //document.getElementById("welcome").innerHTML("Welcome " + user);
    alert();
}



function ajax(fields,method,webService){
    
    
    
    var ajaxObject;
    
    try{
        //FIREFOX, CHROME OPERA BROWSERS
        
        var ajaxObject = new XMLHttpRequest();
        
        
    }catch(e){
        
        try{
            //INTERNET EXPLORER
            ajaxObject = new ActiveXObject("Msxml12.XMLHTTP");
        
        }
        catch(e){
            try{
                //INTERNET EXPLORER
                ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
        
                
            }catch(e){
                console.log("NO AJAX SUPPORT");
                return false;
            }
        }
    }
    
    ajaxObject.onreadystatechange = function(){
    
        if(ajaxObject.readyState===4){
         //    alert(ajaxObject.responseText);
        }
    }
        
        

        if(method ==="GET"){
        queryString = "?";
    }else{queryString ="";}
        
        var x = 0;
    for(var key in fields){
        x++;
        if(x===1){
            queryString +=  key + "=" + fields[key];
        }else
        {
            queryString += "&" + key + "=" + fields[key];
        }
            
            
        }
        
       //alert( queryString);
       
       
       
       if(method==="GET"){
        ajaxObject.open(method,"services/" + webService + queryString, true);
        ajaxObject.send(null);
    }else if(method==="POST"){
        ajaxObject.open(method,"services/" + webService, true);
        ajaxObject.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        ajaxObject.send(queryString);
    }
        
    
}//closes createAjax