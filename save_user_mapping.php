<?php

include 'connection.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$user_id = $data["userid"];
$company_id = $data['companyid'];
$type = $data['type'];



if($type=="user")
{
    $user_liked_by_company = 1;
    $company_liked_by_user = 0;


    $check_sql = "SELECT * FROM `bd_usercompany_mapping` WHERE user_id='".$user_id."' AND company_id='".$company_id."'";
    $result=mysqli_query($connection, $check_sql);
    if ($result->num_rows>0) 
    {
        $psql = "UPDATE bd_usercompany_mapping 
         SET company_liked_by_user = 1, 
             user_liked_by_company = 1 
         WHERE user_id = '".$user_id."' AND company_id = '".$company_id."'";

            // error_log($psql);

            $resB = new stdClass();

            if ($connection->query($psql) === TRUE) 
            {
                $lastUpdatedId = $connection->insert_id;
                $resB->data = (object) array("ID" => $lastUpdatedId);
                $resB->status = 200;
                
            } 
            else
            {
                $resB->cause = "Failed to update data: " . mysqli_error($connection);
                $resB->status = 0;
            }

    }
    else
    {
        $psql = "INSERT INTO bd_usercompany_mapping (user_id, company_id,company_liked_by_user,user_liked_by_company) VALUES 
        ('".$user_id."','".$company_id."','".$company_liked_by_user."','".$user_liked_by_company."' )";
    
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
                $resB->cause = "Failed to add data" . mysqli_error($connection);
                $resB->status = 0;
            }
    }


   

}
else
{
    $user_liked_by_company = 0;
    $company_liked_by_user = 1;


    $psql = "INSERT INTO bd_usercompany_mapping (company_id,user_id,company_liked_by_user,user_liked_by_company) VALUES 
    ('".$user_id."','".$company_id."','".$company_liked_by_user."','".$user_liked_by_company."' )";

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
        $resB->cause = "Failed to add data" . mysqli_error($connection);
        $resB->status = 0;
    }


}


 


//echo $deviceToken;



echo json_encode($resB);

$connection->close();

 

 
//echo $response;
?>
