<?php
include 'connection.php';


$sender_id = $_POST["sender_id"];
$receiver_id = $_POST['receiver_id'];
$chat_room = $_POST['chat_room'];

$sql="SELECT * FROM bd_chat WHERE chat_room_id = '$chat_room' ORDER BY id DESC";
//error_log($sql);
$responseBody= array();
$result=mysqli_query($connection, $sql);
if ($result->num_rows>0) 
{
	
	 $arr = array();
	 
		
	 while($r=$result->fetch_assoc())
	 {
		 
		
		$productData= array("title"=>$r["title"], "id"=>$r["id"], "message"=>$r["message"],"chat_room_id"=>$r["chat_room_id"],"sender"=>$r["sender"],"receiver"=>$r["receiver"],"created_on"=>$r["created_on"],"file"=>$r["file"]);



	 

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
$connection->close();
 

?>