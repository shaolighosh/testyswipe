<?php
include 'connection.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$sender_id = $data["sender_id"];
 

//$sql="SELECT bd_user_registration.*, bd_usercompany_mapping.company_liked_by_user FROM bd_user_registration LEFT JOIN bd_usercompany_mapping ON bd_user_registration.ID=bd_usercompany_mapping.user_id";

$result_c=mysqli_query($connection, "SELECT * FROM bd_usercompany_mapping WHERE bd_usercompany_mapping.company_id= ".$sender_id);
if ($result_c->num_rows>0) 
{
    // print_r('yes');
    // die;
    $sql="SELECT * FROM bd_user_registration WHERE bd_user_registration.ID NOT IN (SELECT bd_usercompany_mapping.user_id FROM bd_usercompany_mapping WHERE bd_usercompany_mapping.company_id=".$sender_id.")";

}else{
   // print_r('no');
   // die;
    $sql="SELECT
    *
   FROM
   bd_user_registration";

}

  
 //echo $sql;
//error_log($sql);
$responseBody= array();
$result=mysqli_query($connection, $sql);
if ($result->num_rows>0) 
{
	
	 $arr = array();
	 
    

	 while($r=$result->fetch_assoc())
	 {
		 
        $med = array(
            array("path" => $r["video"], "type" => $r["video_type"]),
            array("path" => $r["video2"], "type" => $r["video2_type"]),

            array("path" => $r["fileToUpload"], "type" => $r["fileToUpload_type"]),
            array("path" => $r["fileToUpload2"], "type" => $r["fileToUpload2_type"]),
            array("path" => $r["fileToUpload3"], "type" => $r["fileToUpload3_type"]),
            array("path" => $r["cv"], "type" => "image")
          
        );

		$productData= array("name"=>$r["name"], "ID"=>$r["ID"], "location"=>$r["location"],
        "email"=>$r["email"],"device_token"=>$r["device_token"],"password"=>$r["password"],
        "job_posting"=>$r["job_posting"],"about"=>$r["about"],
        "bio"=>$r["bio"],
        "profession"=>$r["profession"],"age"=>$r["age"],
        "type"=>$r["type"],
        "profile_img"=>$r["profile_img"],
        "media"=>$med,
        "flag"=>$r["company_liked_by_user"]
        
       );

	 	array_push($arr, $productData);
	 //	$responseBody->statusCode = 1;
	 //	$responseBody->data = $arr;
	 }
	 
	 	$responseBody= array("status"=>1, "data"=>$arr);
	 	echo json_encode($responseBody);
	 	
}
else
{
	//$responseBody->statusCode = 0;
	//$responseBody->cause = "No data is there";
	$responseBody= array("status"=>0, "data"=>Array());
	 	echo json_encode($responseBody);
  
}

 

$connection->close();
 

?>