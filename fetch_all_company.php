<?php
include 'connection.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$sender_id = $data["sender_id"];
$result_c=mysqli_query($connection, "SELECT bd_usercompany_mapping.company_id FROM bd_usercompany_mapping WHERE bd_usercompany_mapping.user_id= ".$sender_id);
if ($result_c->num_rows>0) 
{
    // print_r('yes');
    // die;
    $sql="SELECT
    *
   FROM
    bd_company_profile
   WHERE
    bd_company_profile.ID NOT IN(
    SELECT
        bd_usercompany_mapping.company_id
    FROM
        bd_usercompany_mapping
    WHERE
        bd_usercompany_mapping.user_id =  ".$sender_id.")";
}else{
    // print_r('no');
    // die;
    $sql="SELECT
    *
   FROM
    bd_company_profile";

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
            array("path" => $r["upload4"], "type" => $r["upload4_type"]),
            array("path" => $r["upload5"], "type" => $r["upload5_type"]),

            array("path" => $r["upload2"], "type" => $r["upload2_type"]),
            array("path" => $r["upload3"], "type" => $r["upload3_type"]),
            array("path" => $r["upload6"], "type" => $r["upload6_type"]),
            array("path" => $r["upload1"], "type" => $r["upload1_type"])
           
        );
		
		$productData= array("name"=>$r["name"], "ID"=>$r["ID"], "location"=>$r["location"],
        "email"=>$r["email"],"device_token"=>$r["device_token"],"password"=>$r["password"],
        "job_posting"=>$r["job_posting"],
        "media"=>$med,
        "about"=>$r["about"],"sector"=>$r["sector"],
        "skill"=>$r["skill"],
        "industry"=>$r["industry"],
        "jobdescription"=>$r["jobdescription"],"type"=>$r["type"],
        "flag_like"=>$r["flag_like"],"location"=>$r["location"],
        "profile_img"=>$r["profile_img"],
        "flag"=>$r["user_liked_by_company"],
        "employee_number"=>$r["employee_number"],"cv_upload"=>$r["cv_upload"]);

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