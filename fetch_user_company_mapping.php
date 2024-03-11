<?php

include 'connection.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$userid = $data["userid"];
$type = $data['type'];

if($type=="company")
{
   // $sql="SELECT bd_usercompany_mapping.*, bd_user_registration.name,bd_user_registration.ID FROM bd_usercompany_mapping INNER JOIN bd_user_registration ON bd_usercompany_mapping.user_id = bd_user_registration.ID WHERE bd_usercompany_mapping.company_id = '".$userid."' ";
 //  $sql="SELECT bd_usercompany_mapping.*, bd_user_registration.name,bd_user_registration.ID FROM bd_usercompany_mapping INNER JOIN bd_user_registration ON bd_usercompany_mapping.user_id = bd_user_registration.ID WHERE bd_usercompany_mapping.user_id = 55 AND company_liked_by_user=1 AND user_liked_by_company=1";
   $sql="SELECT bd_usercompany_mapping.*, bd_user_registration.name,bd_user_registration.ID FROM bd_usercompany_mapping INNER JOIN bd_user_registration ON bd_usercompany_mapping.user_id = bd_user_registration.ID WHERE bd_usercompany_mapping.company_id = '".$userid."' AND company_liked_by_user=1 AND user_liked_by_company=1";

 

    $responseBody= array();
    $result=mysqli_query($connection, $sql);
    if ($result->num_rows>0) 
    {
        $arr = array();
        while($r=$result->fetch_assoc())
        {
            $productData= array("name"=>$r["name"], "ID"=>$r["ID"]);
            array_push($arr, $productData);
        }
            $responseBody= array("status"=>"1", "data"=>$arr);
            echo json_encode($responseBody);
    }
    else
    {
            $responseBody= array("status"=>"0", "data"=>Array());
            echo json_encode($responseBody); 
    }

}
else
{
 
    $sql="SELECT bd_usercompany_mapping.*, bd_company_profile.name,bd_company_profile.ID FROM bd_usercompany_mapping INNER JOIN bd_company_profile ON bd_usercompany_mapping.user_id = bd_company_profile.ID WHERE bd_usercompany_mapping.user_id = '".$userid."' AND company_liked_by_user=1 AND user_liked_by_company=1";


    $responseBody= array();
    $result=mysqli_query($connection, $sql);
    if ($result->num_rows>0) 
    {
        $arr = array();
        while($r=$result->fetch_assoc())
        {
            $productData= array("name"=>$r["name"], "ID"=>$r["ID"], "user_id"=>$r["user_id"]);
            array_push($arr, $productData);
        }
            $responseBody= array("status"=>"1", "data"=>$arr);
            echo json_encode($responseBody);
    }
    else
    {
            $responseBody= array("status"=>"0", "data"=>Array());
            echo json_encode($responseBody); 
    }

}
//echo $sql;



 
$connection->close();


?>
