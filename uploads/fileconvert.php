<?php

$video = $_FILES["fileToUpload"]["tmp_name"];
//$resolution = $_POST["resolution"];
$resolution="720x1280";
$newFileName = generateRandomName() . "." . pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);

$command = "/usr/bin/ffmpeg -i " . escapeshellarg($video) . " -s " . escapeshellarg($resolution) . " " . escapeshellarg($newFileName) . " 2>&1";

exec($command, $output, $returnCode);

if ($returnCode !== 0) {
    // An error occurred during conversion
    $response = [
        "statusCode" => 0,
        "message" => "File upload failed",
        "file_name" => $newFileName
    ];
} else {
    // Conversion successful
    $response = [
        "statusCode" => 1,
        "message" => "File has been uploaded",
        "file_name" => $newFileName
    ];
}

echo json_encode($response);

function generateRandomName($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
