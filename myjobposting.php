<?php

include 'connection.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$userid = $data["userid"];
$type = $data['type'];

$sql=" SELECT * FROM bd_user_registration WHERE ID='".$userid."' ";


$responseBody= array();
$result=mysqli_query($connection, $sql);
if ($result->num_rows>0) 
{
	 $arr = array();
	 while($r=$result->fetch_assoc())
	 {
		$productData= array("name"=>$r["name"], "ID"=>$r["ID"], "location"=>$r["location"],"email"=>$r["email"],"device_token"=>$r["device_token"],"password"=>$r["password"],"job_posting"=>$r["job_posting"],"about"=>$r["about"],"bio"=>$r["bio"],"video"=>$r["video"],"video2"=>$r["video2"],"fileToUpload"=>$r["fileToUpload"]
        ,"fileToUpload2"=>$r["fileToUpload2"],"fileToUpload3"=>$r["fileToUpload3"],"profession"=>$r["profession"],"age"=>$r["age"],"cv"=>$r["cv"],"type"=>$r["type"],"video_type"=>$r["video_type"],"video2_type"=>$r["video2_type"],"fileToUpload_type"=>$r["fileToUpload_type"] ,"fileToUpload2_type"=>$r["fileToUpload2_type"],"fileToUpload3_type"=>$r["fileToUpload3_type"],"flag_like"=>$r["flag_like"],"profile_img"=>$r["profile_img"]);
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
