<?php

include 'connection.php';
$serverKey = 'AAAAsoOzLtE:APA91bEDbi3vhRdItTxuFle_jA2Fs_v7Z24CvjHWSCB5Is-mopJzde3FgR8z-VY-dm7uDFvNtb3mzumnN3RjHT9styFRs1juLVvP9aYZ4gOg0vF61ney1FxSN38GGSeoDIrzSn4xDdz5';


$headers = [
    'Authorization: key=' . $serverKey,
    'Content-Type: application/json',
];
$sender_id = $_POST["sender_id"];
$receiver_id = $_POST['receiver_id'];

$sender_name = $_POST["sender_name"];
$receiver_name = $_POST['receiver_name'];
$sender_img = $_POST["sender_img"];
$receiver_img = $_POST['receiver_img'];

$messa = $_POST['message'];
$deviceToken=$_POST['device_token'];
//echo $deviceToken;
$chat_room=generateAlphanumericString($sender_id,$receiver_id);

$psql = "INSERT INTO bd_chat (chat_room_id, message,sender,receiver,device_token,sender_name,receiver_name,sender_img,receiver_img) VALUES ('".$chat_room."','".$messa."','".$sender_id."','".$receiver_id."','".$deviceToken."','".$sender_name."','".$receiver_name."','".$sender_img."','".$receiver_img."')";

//error_log($psql);

$resB = new stdClass();

if ($connection->query($psql) === TRUE) {
    $resB->data = Array();
    $resB->statusCode = 200;
} else {
    $resB->cause = "Failed to add chat" . mysqli_error($connection);
    $resB->statusCode = 0;
}

echo json_encode($resB);

//$connection->close();

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
$total_message_from = $messa . "\nMessage from " . $sender_name;

//insert into notifications table
$mkosql = "INSERT INTO bd_notifications (userid, title,body) VALUES ('".$receiver_id."','".$messa."','".$total_message_from."')";
//echo $mkosql;
//$resB = new stdClass();

if ($connection->query($mkosql) === TRUE) {
   // $resB->data = Array();
   // $resB->statusCode = 200;
  // echo"inside if";
} else {
   // $resB->cause = "Failed to add notification" . mysqli_error($connection);
    //$resB->statusCode = 0;
   // echo"inside else";
}


$message = [
    'title' => $receiver_name,
    'body' => $messa,
];

$fields = [
    'to' => $deviceToken,
    'notification' => $message,
];



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Use this only for testing purposes, do not use in production without proper SSL certificate verification
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

$response = curl_exec($ch);

if ($response === false) 
{
    die('Curl failed: ' . curl_error($ch));
}

curl_close($ch);
//echo $response;
?>
