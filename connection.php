<?php
$myObj=new \stdClass();
$DBNAME="yswipe";
$connection = mysqli_connect("database-1.chg26u24qmmz.us-east-1.rds.amazonaws.com","admin","Asesino1!697106",$DBNAME);
if (!$connection) {
	    $myObj->statusCode = 101;
        $myObj->progress = "Failed to connect";
        $myJSON = json_encode($myObj);
    
     //echo $myJSON;
}

else{
	    $myObj->statusCode = 100;
        $myObj->progress = "Connection Successfull";
        
        $myJSON = json_encode($myObj);
    
    // echo $myJSON;
}

?>