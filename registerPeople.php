<?php

include 'connection.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$name = $data["name"];
$email = $data['email'];
$device_token = $data["device_token"];
$password = $data['password'];
$job_posting = $data["job_posting"];
$about = $data['about'];
$bio = $data['bio'];
$video=$data['video'];
$video2 = $data["video2"];
$fileToUpload = $data['fileToUpload'];
$fileToUpload2 = $data["fileToUpload2"];
$fileToUpload3 = $data['fileToUpload3'];
$profession = $data['profession'];
$age=$data['age'];
$cv = $data["cv"];
$type = "user";
$location = $data["location"];

$video_type = $data['video_type'];
$video2_type = $data['video2_type'];
$fileToUpload_type=$data['fileToUpload_type'];
$fileToUpload2_type = $data["fileToUpload2_type"];
$fileToUpload3_type = $data['fileToUpload3_type'];


//echo $deviceToken;

$psql = "INSERT INTO bd_user_registration (name, email,device_token,password,job_posting,about,bio,video,video2,fileToUpload,fileToUpload2,fileToUpload3,profession,age,cv,type,location,video_type,video2_type,fileToUpload_type,fileToUpload2_type,fileToUpload3_type) VALUES 
('".$name."','".$email."','".$device_token."','".$password."','".$job_posting."','".$about."','".$bio."','".$video."','".$video2."','".$fileToUpload."',
'".$fileToUpload2."','".$fileToUpload3."','".$profession."','".$age."','".$cv."','".$type."','".$location."' ,'".$video_type."','".$video2_type."','".$fileToUpload_type."','".$fileToUpload2_type."','".$fileToUpload3_type."' )";

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
