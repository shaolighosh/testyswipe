<?php

include 'connection.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$name = $data["name"];
$email = $data['email'];

$device_token = $data["device_token"];
$password = $data['password'];
$job_posting = $data["job_posting"];
$upload1 = $data['upload1'];
$upload2 = $data['upload2'];
$upload3=$data['upload3'];

$upload4 = $data["upload4"];
$upload5 = $data['upload5'];
$upload6 = $data['upload6'];
$about = $data["about"];
//$type = $data['type'];
$upload2_type = $data['upload2_type'];
$upload3_type=$data['upload3_type'];
$upload4_type = $data["upload4_type"];
$upload5_type = $data['upload5_type'];
$upload6_type = $data['upload6_type'];
$location = $data["location"];



$skill = $data["skill"];
$industry = $data['industry'];
$sector = $data['sector'];
$cv = $data["cv"];
$employee_number = $data['employee_number'];
$jobdescription = $data['jobdescription'];
$type="company";




//echo $deviceToken;

$psql = "INSERT INTO bd_company_profile (name, email,device_token,password,job_posting,upload1,upload2,upload3,upload4,upload5,about,type,upload2_type,upload3_type,upload4_type,upload5_type,location,upload6,upload6_type,skill,sector,industry,employee_number,cv_upload,jobdescription) VALUES 
('".$name."','".$email."','".$device_token."','".$password."','".$job_posting."','".$upload1."','".$upload2."','".$upload3."','".$upload4."','".$upload5."',
'".$about."','".$type."','".$upload2_type."','".$upload3_type."','".$upload4_type."','".$upload5_type."','".$location."','".$upload6."','".$upload6_type."',
'".$skill."','".$sector."','".$industry."','".$employee_number."','".$cv."','".$jobdescription."')";

//echo $psql;
//error_log($psql);

$resB = new stdClass();

if ($connection->query($psql) === TRUE) 
{
    $lastInsertId = $connection->insert_id;
    //$resB->data = Array();
    $resB->data = (object) array("ID" => $lastInsertId);
    $resB->status = 200;
} 
else
{
    $resB->cause = "Failed to register" . mysqli_error($connection);
    $resB->status = 0;
}

echo json_encode($resB);

$connection->close();

 

 
//echo $response;
?>
