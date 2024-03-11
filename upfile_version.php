<?php
$resB = new stdClass();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDirectory = "uploads/";
    
    // Check if fileToUpload is set in POST data
    if(isset($_FILES["fileToUpload"])) {
        $newFileName = generateRandomName() . "." . pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
        $targetFile = $targetDirectory . $newFileName;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file already exists
        if (file_exists($targetFile)) {
            $resB->message = "File already exists";
            $resB->file_name = $newFileName;
            $resB->statusCode = 0;
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000000) { // Adjust the maximum file size as needed
            $resB->message = "File too large";
            $resB->file_name = $newFileName;
            $resB->statusCode = 0;
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedExtensions = array("pdf", "jpg", "jpeg", "mp4", "mov", "wmv", "avi", "png");
        if (!in_array($fileType, $allowedExtensions)) {
            $resB->message = "Sorry, only PDF, JPG, JPEG, MP4, MOV, WMV, AVI, and PNG files are allowed.";
            $resB->file_name = $newFileName;
            $resB->statusCode = 0;
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $resB->message = "Your file was not uploaded";
            $resB->file_name = $newFileName;
            $resB->statusCode = 0;
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                $resB->message = "File uploaded Successfully";
                $resB->file_name = $newFileName;
                $resB->statusCode = 1;
            } else {
                $resB->message = "Failed to upload file";
                $resB->file_name = $newFileName;
                $resB->statusCode = 0;
            }
        }

        echo json_encode($resB);
    } else {
        $resB->message = "No file uploaded";
        $resB->file_name = null;
        $resB->statusCode = 0;
        echo json_encode($resB);
    }
}

function generateRandomName($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
