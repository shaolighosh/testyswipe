<?php
include 'connection.php';

$userid = $_POST['userid'];
$type = $_POST['type'];
$filename = $_POST['filename'];

 

$resB = new stdClass();




if($type=="company")
{
    $psql = "UPDATE bd_company_profile SET profile_img = '".$filename."' WHERE ID = '".$userid."'";
   // echo $psql;
    if ($connection->query($psql) === TRUE) 
    {
        $resB->message = "Saved";
        
        $resB->statusCode = 1;
    } 
    else 
    {
        $resB->message = "failed";
        $resB->statusCode = 0;
    }
}
else
{
    $psql = "UPDATE bd_user_registration SET profile_img = '".$filename."' WHERE ID = '".$userid."'";
   // echo $psql;
    if ($connection->query($psql) === TRUE) 
    {
        $resB->message = "saved";
        $resB->statusCode = 1;
    } 
    else 
    {
        $resB->message = "failed";
        $resB->statusCode = 0;
    }
}

echo json_encode($resB);
  
?>
