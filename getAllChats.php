<?php
include 'connection.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$sender_id = $data["sender_id"];
//$receiver_id = $_POST['receiver_id'];
//$chat_room=generateAlphanumericString($sender_id,$receiver_id);

/*$sql=" SELECT *
FROM bd_chat
WHERE (chat_room_id, id) IN (
    SELECT chat_room_id, MAX(id) AS max_id
    FROM bd_chat
    WHERE chat_room_id = '".$chat_room."'
    GROUP BY chat_room_id
)
 "; */

 $sql=" SELECT *
FROM bd_chat
WHERE (chat_room_id, id) IN (
    SELECT chat_room_id, MAX(id) AS max_id
    FROM bd_chat
    WHERE sender = '".$sender_id."' OR receiver = '".$sender_id." '
    GROUP BY chat_room_id
)
 ";
//echo $sql;
//error_log($sql);
$responseBody= array();
$result=mysqli_query($connection, $sql);
if ($result->num_rows>0) 
{
	
	 $arr = array();
	 
		
	 while($r=$result->fetch_assoc())
	 {
		 
		
		$productData= array("title"=>$r["title"], "id"=>$r["id"], "message"=>$r["message"],"chat_room_id"=>$r["chat_room_id"],"sender"=>$r["sender"],"receiver"=>$r["receiver"],"created_on"=>$r["created_on"],"device_token"=>$r["device_token"],"sender_name"=>$r["sender_name"],"sender_img"=>$r["sender_img"],"receiver_name"=>$r["receiver_name"],"receiver_img"=>$r["receiver_img"]);



	 

	 	array_push($arr, $productData);
	 //	$responseBody->statusCode = 1;
	 //	$responseBody->data = $arr;
	 }
	 
	 	$responseBody= array("statusCode"=>1, "data"=>$arr);
	 	echo json_encode($responseBody);
	 	
}
else
{
	//$responseBody->statusCode = 0;
	//$responseBody->cause = "No data is there";
	$responseBody= array("statusCode"=>0, "data"=>Array());
	 	echo json_encode($responseBody);
  
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


$connection->close();
 

?>