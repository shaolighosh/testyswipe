<?php

include 'connection.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$name = $data["name"];
 

 
$password = $data['password'];
$job_posting = $data["job_posting"];
$upload1 = $data['upload1'];
$upload2 = $data['upload2'];
$upload3=$data['upload3'];

$upload4 = $data["upload4"];
$upload5 = $data['upload5'];
$about = $data["about"];

$upload2_type = $data['upload2_type'];
$upload3_type=$data['upload3_type'];
$upload4_type = $data["upload4_type"];
$upload5_type = $data['upload5_type'];
$upload6 = $data['upload6'];
$upload6_type = $data['upload6_type'];
$location = $data["location"];
$userId = $data["userID"];

$employee_number = $data["employee_number"];
$skill = $data["skill"];
$industry = $data["industry"];
$jobdescription = $data["jobdescription"];


//echo $deviceToken;

$psql = "UPDATE bd_company_profile SET name='".$name."', password='".$password."',job_posting='".$job_posting."',upload1='".$upload1."', upload2='".$upload2."',upload3='".$upload3."',upload4='".$upload4."',upload5='".$upload5."',upload6='".$upload6."',about='".$about."',upload2_type='".$upload2_type."',upload3_type='".$upload3_type."',upload4_type='".$upload4_type."',upload5_type='".$upload5_type."',upload6_type='".$upload6_type."',location='".$location."',jobdescription='".$jobdescription."',industry='".$industry."',employee_number='".$employee_number."',skill='".$skill."' WHERE ID='" . $userId . "' ";
//echo $psql;
//error_log($psql);

$resB = new stdClass();

if ($connection->query($psql) === TRUE) {
    $resB->data = (object) array("ID" => $userId); // Assuming the updated record ID
    $resB->status = 1;
} else {
    $resB->cause = "Failed to update: " . mysqli_error($connection);
    $resB->status = 0;
}

echo json_encode($resB);

$connection->close();

 

 
//echo $response;
?>
