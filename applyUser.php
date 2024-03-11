<?php

include 'connection.php';

$headers = [
    'Authorization: key=' . $serverKey,
    'Content-Type: application/json',
];

$companyid = $_POST["id"];
//$userid = $_POST['userid'];

$psql = "UPDATE bd_user_registration SET flag_like = 1 WHERE ID = '".$companyid."'";

// Replace 'your_value' with the actual value you want to set for the 'flag_like' column
// Make sure to sanitize and validate user input to prevent SQL injection
//echo $psql;
//error_log($psql);

$resB = new stdClass();

if ($connection->query($psql) === TRUE) {
    $resB->data = Array();
    $resB->statusCode = 200;
} else {
    $resB->cause = "Failed to update data: " . mysqli_error($connection);
    $resB->statusCode = 0;
}

echo json_encode($resB);
?>
