<?php



include 'connection.php';




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000000) { // Adjust the maximum file size as needed
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedExtensions = array("pdf", "jpg", "jpeg", "mp4", "mov", "wmv", "avi", "png","mp3", "wav");
    if (!in_array($fileType, $allowedExtensions)) 
    {
        echo "Sorry, only PDF, JPG, JPEG, MP4, MOV, WMV, AVI, MP3, WAV and PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }




$sender_id = $_POST["sender_id"];
$receiver_id = $_POST['receiver_id'];
$messa = $_POST['message'];


$chat_room=generateAlphanumericString($sender_id,$receiver_id);

$psql = "INSERT INTO bd_chat (chat_room_id, message,sender,receiver,file) VALUES ('".$chat_room."','".$messa."','".$sender_id."','".$receiver_id."', '".$_FILES["fileToUpload"]["name"]."')";

//error_log($psql);

 
$resB = new stdClass();

if ($connection->query($psql) === TRUE) {
    
    $resB->data = Array();
    
    $resB->statusCode = 200;
} else {
    $resB->cause = "Failed to add chat" . mysqli_error($connection);
    $resB->statusCode = 0;
}

}



function generateAlphanumericString($senderId, $receiverId) {
    // Sort the input values
    $sortedValues = [$senderId, $receiverId];
    sort($sortedValues);

    // Concatenate sorted values
    $inputString = implode('', $sortedValues);

    // Use md5 hash function to generate a fixed-length hexadecimal string
    $hash = md5($inputString);

    // Convert hexadecimal string to alphanumeric string
    $alphanumericString = base_convert($hash, 16, 36);

    return $alphanumericString;
}

echo json_encode($resB);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload" accept=".pdf, .jpg, .jpeg, .mp4, .mov, .wmv, .avi, .png, .mp3, .wav">
       
       
        Sender ID: <input type="text" name="sender_id" id="sender_id">
    Receiver ID: <input type="text" name="receiver_id" id="receiver_id">
    Message: <textarea name="message" id="message"></textarea>

        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>
