<?php

include 'connection.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$userid = $data["userid"];
$type = $data['type'];

$sql=" SELECT * FROM bd_company_profile WHERE ID='".$userid."' ";


$responseBody= array();
$result=mysqli_query($connection, $sql);
if ($result->num_rows>0) 
{
	 $arr = array();
	 while($r=$result->fetch_assoc())
	 {
        $med = array(
            array("path" => $r["upload1"], "type" => $r["upload1_type"]),
            array("path" => $r["upload2"], "type" => $r["upload2_type"]),
            array("path" => $r["upload3"], "type" => $r["upload3_type"]),
            array("path" => $r["upload4"], "type" => $r["upload4_type"]),
            array("path" => $r["upload5"], "type" => $r["upload5_type"])
        );
        $productData = array(
            "name" => $r["name"],
            "ID" => $r["ID"],
            "location" => $r["location"],
            "email" => $r["email"],
            "device_token" => $r["device_token"],
            "password" => $r["password"],
            "job_posting" => $r["job_posting"],
            "about" => $r["about"],
            "sector" => $r["sector"],
            "skill" => $r["skill"],
            "industry" => $r["industry"],
            "employee_number" => $r["employee_number"],
            "cv" => $r["cv_upload"],
            "jobdescription" => $r["jobdescription"],
            "type" => $r["type"],
            "flag_like" => $r["flag_like"],
            "profile_img" => $r["profile_img"],

           
            
            "media"=>$med
        );

	 	array_push($arr, $productData);
	 }
	 	$responseBody= array("status"=>"1", "data"=>$arr);
	 	echo json_encode($responseBody);
}
else
{
	    $responseBody= array("status"=>"0", "data"=>Array());
	 	echo json_encode($responseBody); 
}

 
$connection->close();


?>
