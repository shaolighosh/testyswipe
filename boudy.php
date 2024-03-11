
<?php
ob_start();

include 'config.php';

$event_encoded = json_decode(file_get_contents('php://input'), true);


if ($event_encoded == null || $event_encoded == '') {
  $event_encoded = $HTTP_RAW_POST_DATA;
}

if ($event_encoded == null || $event_encoded == '') {
  $event_encoded = $_REQUEST;
}
file_put_contents('post.txt', json_encode($event_encoded), FILE_APPEND);

if ($event_encoded['actiontype'] == "add_user_registration") {
	
	$ongoing_query = "Insert into `bd_user_registration` set `name`=:name,`location`=:location,`email`=:email,`device_token`=:device_token,`password`=:password,`job_posting`=:job_posting,`about`=:about,`bio`=:bio,`video`=:video,`video2`=:video2,`fileToUpload`=:fileToUpload,`fileToUpload2`=:fileToUpload2,`fileToUpload3`=:fileToUpload3,`profession`=:profession,`age`=:age,`cv`=:cv,`type`=:type,`video_type`=:video_type,`video2_type`=:video2_type,`fileToUpload_type`=:fileToUpload_type,`fileToUpload2_type`=:fileToUpload2_type,`fileToUpload3_type`=:fileToUpload3_type";
	
	//$target_dir = "https://developer.marketingplatform.ca/Boudy/uploads/";
	
	//$target_file = $target_dir . basename(($_FILES["fileToUpload"]["name"]));
	//move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_file);

	$statement = $pdo->prepare($ongoing_query);

  $statement->execute(
    array(


      "name" => $event_encoded["name"],
      "location" =>  $event_encoded["location"],
      "email" =>  $event_encoded["email"],
      "device_token" =>  $event_encoded["device_token"],
      "password" => $event_encoded["password"],
	  "job_posting" => $event_encoded["job_posting"],
      "about" =>  $event_encoded["about"],
      "bio" =>  $event_encoded["bio"],
      "video" => $event_encoded["video"],
	  "video2" =>  $event_encoded["video2"],
      "fileToUpload" =>  $event_encoded["fileToUpload"],
      "fileToUpload2" => $event_encoded["fileToUpload2"],
	  "fileToUpload3" => $event_encoded["fileToUpload3"],
      "profession" =>  $event_encoded["profession"],
      "age" =>  $event_encoded["age"],
      "cv" => $event_encoded["cv"],
	  "type" =>  'user',
      "video_type" => $event_encoded["video_type"],
	  "video2_type" =>  $event_encoded["video2_type"],
      "fileToUpload_type" =>  $event_encoded["fileToUpload_type"],
      "fileToUpload2_type" => $event_encoded["fileToUpload2_type"],
	  "fileToUpload3_type" => $event_encoded["fileToUpload3_type"]
    )
  );
  
  $ongoing_query_new = "Insert into `bd_job_posting_user` set `name`=:name,`location`=:location,`email`=:email,`job_posting`=:job_posting,`about`=:about,`bio`=:bio,`video`=:video,`video2`=:video2,`fileToUpload`=:fileToUpload,`fileToUpload2`=:fileToUpload2,`fileToUpload3`=:fileToUpload3,`profession`=:profession,`age`=:age,`cv`=:cv,`type`=:type,`video_type`=:video_type,`video2_type`=:video2_type,`fileToUpload_type`=:fileToUpload_type,`fileToUpload2_type`=:fileToUpload2_type,`fileToUpload3_type`=:fileToUpload3_type";


  $statement_new = $pdo->prepare($ongoing_query_new);

  $statement_new->execute(
    array(
"name" => $event_encoded["name"],
      "location" =>  $event_encoded["location"],
      "email" =>  $event_encoded["email"],
	  "job_posting" => $event_encoded["job_posting"],
      "about" =>  $event_encoded["about"],
      "bio" =>  $event_encoded["bio"],
      "video" => $event_encoded["video"],
	  "video2" =>  $event_encoded["video2"],
      "fileToUpload" =>  $event_encoded["fileToUpload"],
      "fileToUpload2" => $event_encoded["fileToUpload2"],
	  "fileToUpload3" => $event_encoded["fileToUpload3"],
      "profession" =>  $event_encoded["profession"],
      "age" =>  $event_encoded["age"],
      "cv" => $event_encoded["cv"],
	  "type" =>  'user',
      "video_type" => $event_encoded["video_type"],
	  "video2_type" =>  $event_encoded["video2_type"],
      "fileToUpload_type" =>  $event_encoded["fileToUpload_type"],
      "fileToUpload2_type" => $event_encoded["fileToUpload2_type"],
	  "fileToUpload3_type" => $event_encoded["fileToUpload3_type"]
    )
  );
  
  
  
	
	$meal['name'] = $event_encoded["name"];
    $meal['location'] = $event_encoded["location"];
    $meal['email'] = $event_encoded["email"];
    $meal['password'] = $event_encoded["password"];
    $meal['jobdescription'] = $event_encoded["jobdescription"];
    $meal['about'] = $event_encoded["about"];
    $meal['bio'] = $event_encoded["bio"];
    $meal['video'] = $event_encoded["video"];
    $meal['video2'] = $event_encoded["video2"];
    $meal['fileToUpload'] = $event_encoded["fileToUpload"];
    $meal['fileToUpload2'] = $event_encoded["fileToUpload2"];
    $meal['fileToUpload3'] = $event_encoded["fileToUpload3"];
    $meal['profession'] = $event_encoded["profession"];
    $meal['age'] = $event_encoded["age"];
	$meal['cv'] = $event_encoded["cv"];
    $meal['type'] = 'user';
	
	
	$num_rows = $statement->rowCount();

  if ($num_rows > 0) {

 $parent["status"] = "200";
    $parent['data'] = $meal;
    echo json_encode($parent);
	
    //echo json_encode(array('message' => "Success", 'Status' => "200"));


  }
}  else if ($event_encoded['actiontype'] == "login") {
	
   $ongoing_query = "select * from bd_user_registration where email=:email and password=:password";


    $statement = $pdo->prepare($ongoing_query);

    $statement->execute(array(

    "email" => $event_encoded["email"],
	"password" => $event_encoded["password"]
	
  ));
	
  $num_rows = $statement->rowCount();
   if ($num_rows > 0) {
	   
$results = $statement->fetchAll();
    $parent["status"] = "200";
    $parent['data'] = $results;
    echo json_encode($parent);
    //echo json_encode(array('message' => "Success", 'Status' => "200"));


  } else{
	  
	     $ongoing_query_cmp = "select * from bd_company_profile where email=:email and password=:password";


    $statement = $pdo->prepare($ongoing_query_cmp);

    $statement->execute(array(

    "email" => $event_encoded["email"],
	"password" => $event_encoded["password"]
	
  ));
	
  $num_rows_cmp = $statement->rowCount();
   if ($num_rows_cmp > 0) {

    $results = $statement->fetchAll();
    $parent["status"] = "200";
    $parent['data'] = $results;
    echo json_encode($parent);


  } else{
	  
  echo json_encode(array('message' => "No data found", 'status' => "0"));}
} }  else if ($event_encoded['actiontype'] == "forget_password") {
	
   $ongoing_query = "update bd_user_registration set password=:password where email=:email";


    $statement = $pdo->prepare($ongoing_query);

    $statement->execute(array(

    "email" => $event_encoded["email"],
	"password" => $event_encoded["password"]
	
  ));
	
  $num_rows = $statement->rowCount();
   if ($num_rows > 0) {

    echo json_encode(array('message' => "Success", 'status' => "200"));


  } else{
	  $ongoing_query = "update bd_company_profile set password=:password where email=:email";


    $statement = $pdo->prepare($ongoing_query);

    $statement->execute(array(

    "email" => $event_encoded["email"],
	"password" => $event_encoded["password"]
	
  ));
	
  $num_rows = $statement->rowCount();
   if ($num_rows > 0) {

    echo json_encode(array('message' => "Success", 'status' => "200"));


  } else{
	  echo json_encode(array('message' => "No changes made", 'status' => "0"));
 }
}}   else if ($event_encoded['actiontype'] == "company_profile") {
	
	$ongoing_query = "Insert into `bd_company_profile` set `name`=:name,`email`=:email,`device_token`=:device_token,`password`=:password,`job_posting`=:job_posting,`upload1`=:upload1,`upload2`=:upload2,`upload3`=:upload3,`upload4`=:upload4,`upload5`=:upload5,`about`=:about,`sector`=:sector,`skill`=:skill,`industry`=:industry,`employee_number`=:employee_number,`cv_upload`=:cv_upload,`jobdescription`=:jobdescription,`type`=:type,`upload1_type`=:upload1_type,`upload2_type`=:upload2_type,`upload3_type`=:upload3_type,`upload4_type`=:upload4_type,`upload5_type`=:upload5_type,`upload6`=:upload6,`upload6_type`=:upload6_type,`location`=:location";
	//echo $ongoing_query;
	/*$target_file = "";
	$target_file2 = "";
	$target_file3 = "";
	$target_file4 = "";
	$target_file5 = "";
	$cv = "";
	$target_dir = "https://developer.marketingplatform.ca/Boudy/uploads/";
	
	$target_file = $target_dir . basename(($_FILES["fileToUpload"]["name"]));
	$target_file2 = $target_dir . basename(($_FILES["fileToUpload2"]["name"]));
	$target_file3 = $target_dir . basename(($_FILES["fileToUpload3"]["name"]));
	$target_file4 = $target_dir . basename(($_FILES["fileToUpload4"]["name"]));
	$target_file5 = $target_dir . basename(($_FILES["fileToUpload5"]["name"]));
	$cv = $target_dir . basename(($_FILES["cv"]["name"]));*/
	//move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_file);

	$statement = $pdo->prepare($ongoing_query);

  $statement->execute(
    array(


      "name" => $event_encoded["name"],
      "email" =>  $event_encoded["email"],
      "device_token" =>  $event_encoded["device_token"],
      "password" => $event_encoded["password"],
	  "job_posting" => $event_encoded["job_posting"],
	  "upload1" => $event_encoded["upload1"],
	  "upload2" => $event_encoded["upload2"],
	  "upload3" => $event_encoded["upload3"],
	  "upload4" => $event_encoded["upload4"],
	  "upload5" => $event_encoded["upload5"],
   
      "about" =>  $event_encoded["about"],"sector" => $event_encoded["sector"],"skill" => $event_encoded["skill"],"industry" => $event_encoded["industry"],"employee_number" => $event_encoded["employee_number"],"cv_upload" => $event_encoded["cv_upload"],"jobdescription" => $event_encoded["jobdescription"],
	  "type" =>  'company',"upload1_type" => $event_encoded["upload1_type"],
	  "upload2_type" => $event_encoded["upload2_type"],
	  "upload3_type" => $event_encoded["upload3_type"],
	  "upload4_type" => $event_encoded["upload4_type"],
	  "upload5_type" => $event_encoded["upload5_type"],
    "upload6" => $event_encoded["upload6"],
    "upload6_type" => $event_encoded["upload6_type"],
    "location" => $event_encoded["location"]
    )
  );
  $lastInsertedId = $pdo->lastInsertId();

	
	$ongoing_query_new = "Insert into `bd_job_posting_company` set `name`=:name,`email`=:email,`job_posting`=:job_posting,`upload1`=:upload1,`upload2`=:upload2,`upload3`=:upload3,`upload4`=:upload4,`upload5`=:upload5,`about`=:about,`sector`=:sector,`skill`=:skill,`industry`=:industry,`employee_number`=:employee_number,`cv_upload`=:cv_upload,`jobdescription`=:jobdescription,`type`=:type,`upload1_type`=:upload1_type,`upload2_type`=:upload2_type,`upload3_type`=:upload3_type,`upload4_type`=:upload4_type,`upload5_type`=:upload5_type,`upload1_type`=:upload1_type,`upload2_type`=:upload2_type,`upload3_type`=:upload3_type,`upload4_type`=:upload4_type,`upload5_type`=:upload5_type";


  $statement_new = $pdo->prepare($ongoing_query_new);

  $statement_new->execute(
    array(
"name" => $event_encoded["name"],
      "email" =>  $event_encoded["email"],
	  "job_posting" => $event_encoded["job_posting"],
	  "upload1" => $event_encoded["upload1"],
	  "upload2" => $event_encoded["upload2"],
	  "upload3" => $event_encoded["upload3"],
	  "upload4" => $event_encoded["upload4"],
	  "upload5" => $event_encoded["upload5"],
      "about" =>  $event_encoded["about"],"sector" => $event_encoded["sector"],"skill" => $event_encoded["skill"],"industry" => $event_encoded["industry"],"employee_number" => $event_encoded["employee_number"],"cv_upload" => $event_encoded["cv_upload"],"jobdescription" => $event_encoded["jobdescription"],
	  "type" =>  'company',
	  "upload1_type" => $event_encoded["upload1_type"],
	  "upload2_type" => $event_encoded["upload2_type"],
	  "upload3_type" => $event_encoded["upload3_type"],
	  "upload4_type" => $event_encoded["upload4_type"],
	  "upload5_type" => $event_encoded["upload5_type"]
    )
  );
	
	$meal['ID'] = $lastInsertedId; 
	$meal['name'] = $event_encoded["name"];
    $meal['email'] = $event_encoded["email"];
    $meal['password'] = $event_encoded["password"];
    $meal['jobposting'] = $event_encoded["jobposting"];
    $meal['upload1'] = $event_encoded["upload1"];
    $meal['upload2'] = $event_encoded["upload2"];
    $meal['upload3'] = $event_encoded["upload3"];
    $meal['upload4'] = $event_encoded["upload4"];
    $meal['upload5'] = $event_encoded["upload5"];
    $meal['about'] = $event_encoded["about"];
    $meal['sector'] = $event_encoded["sector"];
    $meal['skill'] = $event_encoded["skill"];
    $meal['age'] = $event_encoded["age"];
	$meal['industry'] = $event_encoded["industry"];
	$meal['employee_number'] = $event_encoded["employee_number"];
    $meal['cv_upload'] = $event_encoded["cv_upload"];
	$meal['jobdescription'] = $event_encoded["jobdescription"];
    $meal['type'] = 'company';
	
	
	$num_rows = $statement->rowCount();
  $parent = array();
  if ($num_rows > 0) {
    $parent["status"] = "200";
    $parent['data'] = $meal;
} else {
    
    $parent["status"] = "500";  
    $parent['error_message'] = "Failed to insert data";  
}

 

echo json_encode($parent);
  /*if ($num_rows > 0) {

	$parent["status"] = "200";
    $parent['data'] = $meal;
    echo json_encode($parent);
	
    


  }*/
	
	
}  else if ($event_encoded['actiontype'] == "fetch_all_user") {
	
	 $ongoing_query = "select * from bd_user_registration";
$statement = $pdo->prepare($ongoing_query);
$statement->execute(array());

$num_user_token = $statement->rowCount();

if ($num_user_token > 0) {
    $results = $statement->fetchAll();

    $data = array();
    foreach ($results as $res) {
        $user = array(
            "ID" => $res->ID,
            "name" => $res->name,
            "location" => $res->location,
            "email" => $res->email,
            "password" => $res->password,
            "job_posting" => $res->job_posting,
            "device_token" => $res->device_token,
            "about" => $res->about,
            "bio" => $res->bio,
            "media" => array(
              array("path" => $res->video, "type" => $res->video_type),
              array("path" => $res->video2, "type" => $res->video2_type),
              array("path" => $res->fileToUpload, "type" => $res->fileToUpload_type),
              array("path" => $res->fileToUpload2, "type" => $res->fileToUpload2_type),
              array("path" => $res->fileToUpload3, "type" => $res->fileToUpload3_type),
            ),
            "profession" => $res->profession,
            "age" => $res->age,
            "cv" => $res->cv,
            "location" => $res->location,
            "type" => $res->type,
            "profile_img" => $res->profile_img
        );

        // Handle video and file uploads
        /*

        $uploadPath = $res->{'video'};
        $uploadType = $res->{'video_type'};
            
            if ($uploadPath !== null) 
            {
                $user['media'][] = array(
                    "path" => "https://developer.marketingplatform.ca/Boudy/uploads/{$uploadPath}",
                    "type" => $uploadType
                );
            }


        $uploadPath2 = $res->{'video2'};
        $uploadType2 = $res->{'video2_type'};
            
            if ($uploadPath2 !== null) 
            {
                $user['media'][] = array(
                    "path" => "https://developer.marketingplatform.ca/Boudy/uploads/{$uploadPath2}",
                    "type" => $uploadType2
                );
            }


            

            $uploadPath3 = $res->{'fileToUpload'};
        $uploadType3 = $res->{'fileToUpload_type'};
            
            if ($uploadPath3 !== null) 
            {
                $user['media'][] = array(
                    "path" => "https://developer.marketingplatform.ca/Boudy/uploads/{$uploadPath3}",
                    "type" => $uploadType3
                );
            }

            $uploadPath4 = $res->{'fileToUpload2'};
        $uploadType4 = $res->{'fileToUpload2_type'};
            
            if ($uploadPath4 !== null) 
            {
                $user['media'][] = array(
                    "path" => "https://developer.marketingplatform.ca/Boudy/uploads/{$uploadPath4}",
                    "type" => $uploadType4
                );
            }

            $uploadPath5 = $res->{'fileToUpload3'};
        $uploadType5 = $res->{'fileToUpload3_type'};
            
            if ($uploadPath5 !== null) 
            {
                $user['media'][] = array(
                    "path" => "https://developer.marketingplatform.ca/Boudy/uploads/{$uploadPath5}",
                    "type" => $uploadType5
                );
            } */

        // user

        $data[] = $user;
    }

    $response = array(
        "status" => "200",
        "data" => $data
    );

    echo json_encode($response);
}

	
}  else if ($event_encoded['actiontype'] == "fetch_all_company") {
	
  $ongoing_query = "SELECT * FROM bd_company_profile";
  $statement = $pdo->prepare($ongoing_query);
  $statement->execute(array());
  
  $num_user_token = $statement->rowCount();
  
  if ($num_user_token > 0)
   {
      $results = $statement->fetchAll();
  
      $meal = array();
      foreach ($results as $res) {
          $entry = array(
              "ID" => $res->ID,
              "name" => $res->name,
              "email" => $res->email,
              "password" => $res->password,
              "job_posting" => $res->job_posting,
              "device_token" => $res->device_token,
              "media" => array(
                  array("path" => $res->upload1, "type" => $res->upload1_type),
                  array("path" => $res->upload2, "type" => $res->upload2_type),
                  array("path" => $res->upload3, "type" => $res->upload3_type),
                  array("path" => $res->upload4, "type" => $res->upload4_type),
                  array("path" => $res->upload5, "type" => $res->upload5_type),
              ),
              "about" => $res->about,
              "sector" => $res->sector,
              "skill" => $res->skill,
              "industry" => $res->industry,
              "employee_number" => $res->employee_number,
              "cv_upload" => $res->cv_upload,
              "location" => $res->location,
              "jobdescription" => $res->jobdescription,
              "type" => $res->type,
              "profile_img" => $res->profile_img
          );
  
          $meal[] = $entry;
      }
  
      $parent["status"] = "200";
      $parent['data'] = $meal;
      echo json_encode($parent);
  }
  
	
}  else if ($event_encoded['actiontype'] == "fetch_user_ID") {
	
	   $ongoing_query = "select * from bd_user_registration where ID=:ID";


    $statement = $pdo->prepare($ongoing_query);

    $statement->execute(array(
	
	"ID" => $event_encoded["ID"]
	
	));
	
  $num_user_token = $statement->rowCount();

  if ($num_user_token > 0) {

    $results = $statement->fetchAll();
    $parent["status"] = "200";
    $parent['data'] = $results;
    echo json_encode($parent);
    /* echo json_encode(array('Status' => "200"));
   echo json_encode($results);*/


  }
	
}  else if ($event_encoded['actiontype'] == "fetch_company_ID") {
	
	   $ongoing_query = "select * from bd_company_profile where ID=:ID";


    $statement = $pdo->prepare($ongoing_query);

    $statement->execute(array("ID" => $event_encoded["ID"]));
	
  $num_user_token = $statement->rowCount();

  if ($num_user_token > 0) {

    $results = $statement->fetchAll();
    $parent["status"] = "200";
    $parent['data'] = $results;
    echo json_encode($parent);
    /* echo json_encode(array('Status' => "200"));
   echo json_encode($results);*/


  }
	
}  else if ($event_encoded['actiontype'] == "user_company") {
	
	$ongoing_query = "update `bd_user_registration` set `flag_like`=1 where `ID`=:userid";


   $statement = $pdo->prepare($ongoing_query);

  $statement->execute(
    array(


      "userid" => $event_encoded["userid"]
    )
  );
	
	
		$ongoing_query = "update `bd_user_registration` set `flag_like`=1 where `ID`=:companyid";


   $statement = $pdo->prepare($ongoing_query);

  $statement->execute(
    array(


      "userid" => $event_encoded["companyid"]
    )
  );
	
	   $ongoing_query = "Insert into `bd_user_company` set `userid`=:userid,`companyid`=:companyid";


   $statement = $pdo->prepare($ongoing_query);

  $statement->execute(
    array(


      "userid" => $event_encoded["userid"],
      "companyid" =>  $event_encoded["companyid"]
    )
  );
	
	
	
	$num_rows = $statement->rowCount();

  if ($num_rows > 0) {

 /*$parent["status"] = "200";
    $parent['data'] = $meal;
    echo json_encode($parent);*/
	
    echo json_encode(array('message' => "Success", 'status' => "200"));


  }
	
}  else if ($event_encoded['actiontype'] == "insert_posting_company") {
	
$ongoing_query_new = "Insert into `bd_job_posting_company` set `name`=:name,`email`=:email,`job_posting`=:job_posting,`upload1`=:upload1,`upload2`=:upload2,`upload3`=:upload3,`upload4`=:upload4,`upload5`=:upload5,`about`=:about,`sector`=:sector,`skill`=:skill,`industry`=:industry,`employee_number`=:employee_number,`cv_upload`=:cv_upload,`jobdescription`=:jobdescription,`type`=:type,`upload1_type`=:upload1_type,`upload2_type`=:upload2_type,`upload3_type`=:upload3_type,`upload4_type`=:upload4_type,`upload5_type`=:upload5_type";


  $statement_new = $pdo->prepare($ongoing_query_new);

  $statement_new->execute(
    array(
"name" => $event_encoded["name"],
      "email" =>  $event_encoded["email"],
	  "job_posting" => $event_encoded["job_posting"],
	  "upload1" => $event_encoded["upload1"],
	  "upload2" => $event_encoded["upload2"],
	  "upload3" => $event_encoded["upload3"],
	  "upload4" => $event_encoded["upload4"],
	  "upload5" => $event_encoded["upload5"],
      "about" =>  $event_encoded["about"],"sector" => $event_encoded["sector"],"skill" => $event_encoded["skill"],"industry" => $event_encoded["industry"],"employee_number" => $event_encoded["employee_number"],"cv_upload" => $event_encoded["cv_upload"],"jobdescription" => $event_encoded["jobdescription"],
	  "type" =>  'company',"upload1_type" => $event_encoded["upload1_type"],
	  "upload2_type" => $event_encoded["upload2_type"],
	  "upload3_type" => $event_encoded["upload3_type"],
	  "upload4_type" => $event_encoded["upload4_type"],
	  "upload5_type" => $event_encoded["upload5_type"]
    )
  );
	

  $num_rows = $statement_new->rowCount();

  if ($num_rows > 0) {

    echo json_encode(array('message' => "Success", 'Status' => "200"));


  }
	
	
}  else if ($event_encoded['actiontype'] == "insert_posting_user") {
	
		$ongoing_query = "Insert into `bd_job_posting_user` set `name`=:name,`location`=:location,`email`=:email,`job_posting`=:job_posting,`about`=:about,`bio`=:bio,`video`=:video,`video2`=:video2,`fileToUpload`=:fileToUpload,`fileToUpload2`=:fileToUpload2,`fileToUpload3`=:fileToUpload3,`profession`=:profession,`age`=:age,`cv`=:cv,`type`=:type,`video_type`=:video_type,`video2_type`=:video2_type,`fileToUpload_type`=:fileToUpload_type,`fileToUpload2_type`=:fileToUpload2_type,`fileToUpload3_type`=:fileToUpload3_type";


  $statement = $pdo->prepare($ongoing_query);

  $statement->execute(
    array(
"name" => $event_encoded["name"],
      "location" =>  $event_encoded["location"],
      "email" =>  $event_encoded["email"],
	  "job_posting" => $event_encoded["job_posting"],
      "about" =>  $event_encoded["about"],
      "bio" =>  $event_encoded["bio"],
      "video" => $event_encoded["video"],
	  "video2" =>  $event_encoded["video2"],
      "fileToUpload" =>  $event_encoded["fileToUpload"],
      "fileToUpload2" => $event_encoded["fileToUpload2"],
	  "fileToUpload3" => $event_encoded["fileToUpload3"],
      "profession" =>  $event_encoded["profession"],
      "age" =>  $event_encoded["age"],
      "cv" => $event_encoded["cv"],
	  "type" =>  'user',
      "video_type" => $event_encoded["video_type"],
	  "video2_type" =>  $event_encoded["video2_type"],
      "fileToUpload_type" =>  $event_encoded["fileToUpload_type"],
      "fileToUpload2_type" => $event_encoded["fileToUpload2_type"],
	  "fileToUpload3_type" => $event_encoded["fileToUpload3_type"]
    )
  );

  $num_rows = $statement->rowCount();

  if ($num_rows > 0) {

    echo json_encode(array('message' => "Success", 'Status' => "200"));


  }
	
	
}  else if ($event_encoded['actiontype'] == "fetch_posting_user") {
	$ongoing_query = "select * from bd_job_posting_user where email=:email order by ID desc limit 1";


    $statement = $pdo->prepare($ongoing_query);

    $statement->execute(array(

    "email" => $event_encoded["email"]
	
  ));
  
  $num_rows = $statement->rowCount();
   if ($num_rows > 0) {
	   
$results = $statement->fetchAll();
    $parent["status"] = "200";
    $parent['data'] = $results;
    echo json_encode($parent);
    //echo json_encode(array('message' => "Success", 'Status' => "200"));


  } else{
	  
	     $ongoing_query_cmp = "select * from bd_user_registration where email=:email";


    $statement = $pdo->prepare($ongoing_query_cmp);

    $statement->execute(array(

    "email" => $event_encoded["email"]
	
  ));
	
  $num_rows_cmp = $statement->rowCount();
   if ($num_rows_cmp > 0) {

    $results = $statement->fetchAll();
    $parent["status"] = "200";
    $parent['data'] = $results;
    echo json_encode($parent);


  } else{
	  
  echo json_encode(array('message' => "No data found", 'status' => "0"));}
}
  
}
  else if ($event_encoded['actiontype'] == "fetch_posting_company") {
	$ongoing_query = "select * from bd_job_posting_company where email=:email order by ID desc limit 1";


    $statement = $pdo->prepare($ongoing_query);

    $statement->execute(array(

    "email" => $event_encoded["email"]
	
  ));
  
  $num_rows = $statement->rowCount();
   if ($num_rows > 0) {
	   
$results = $statement->fetchAll();
    $parent["status"] = "200";
    $parent['data'] = $results;
    echo json_encode($parent);
    //echo json_encode(array('message' => "Success", 'Status' => "200"));


  } else{
	  
	     $ongoing_query_cmp = "select * from bd_company_profile where email=:email";


    $statement = $pdo->prepare($ongoing_query_cmp);

    $statement->execute(array(

    "email" => $event_encoded["email"]
	
  ));
	
  $num_rows_cmp = $statement->rowCount();
   if ($num_rows_cmp > 0) {

    $results = $statement->fetchAll();
    $parent["status"] = "200";
    $parent['data'] = $results;
    echo json_encode($parent);


  } else{
	  
  echo json_encode(array('message' => "No data found", 'status' => "0"));}
}
  
}
else if ($event_encoded['actiontype'] == "fetch_all_posting_company") {
	$ongoing_query = "select * from bd_job_posting_company where email=:email";


    $statement = $pdo->prepare($ongoing_query);

    $statement->execute(array(

    "email" => $event_encoded["email"]
	
  ));
  
  $num_rows = $statement->rowCount();
   if ($num_rows > 0) {
	   
$results = $statement->fetchAll();
//-------------------
$i = 0;
      foreach ($results as $res) {
        $meal[$i]["ID"] = $res->ID;
		$meal[$i]["name"] = $res->name;
		$meal[$i]["email"] = $res->email;
		$meal[$i]["password"] = $res->password;
		$meal[$i]["job_posting"] = $res->job_posting;

	  

    $meal[$i]["media"] = array(
      array("path" => $res->upload1, "type" => $res->upload1_type),
      array("path" => $res->upload2, "type" => $res->upload2_type),
      array("path" => $res->upload3, "type" => $res->upload3_type),
      array("path" => $res->upload4, "type" => $res->upload4_type),
      array("path" => $res->upload5, "type" => $res->upload5_type),
  );


		$meal[$i]["about"] = $res->about;
		$meal[$i]["sector"] = $res->sector;
		$meal[$i]["skill"] = $res->skill;
		$meal[$i]["industry"] = $res->industry;
		$meal[$i]["employee_number"] = $res->employee_number;
		$meal[$i]["cv_upload"] = $res->cv_upload;
        $meal[$i]["jobdescription"] = $res->jobdescription;
		$meal[$i]["type"] = $res->type;
        $i++;
	  }
    //--------------------
    $parent["status"] = "200";
    //$parent['data'] = $results;
	$parent['data'] = $meal;
    echo json_encode($parent);
    //echo json_encode(array('message' => "Success", 'Status' => "200"));


  } else{
	  
	     $ongoing_query_cmp = "select * from bd_company_profile where email=:email";


    $statement = $pdo->prepare($ongoing_query_cmp);

    $statement->execute(array(

    "email" => $event_encoded["email"]
	
  ));
	
  $num_rows_cmp = $statement->rowCount();
   if ($num_rows_cmp > 0) {

    $results = $statement->fetchAll();
    $parent["status"] = "200";
    $parent['data'] = $results;
    echo json_encode($parent);


  } else{
	  
  echo json_encode(array('message' => "No data found", 'status' => "0"));}
}
  
}  else if ($event_encoded['actiontype'] == "fetch_all_posting_user") {
	$ongoing_query = "select * from bd_job_posting_user where email=:email";


    $statement = $pdo->prepare($ongoing_query);

    $statement->execute(array(

    "email" => $event_encoded["email"]
	
  ));
  
  $num_rows = $statement->rowCount();
   if ($num_rows > 0) {
	   
$results = $statement->fetchAll();
//-------------------
$i = 0;
      foreach ($results as $res) {
        $meal[$i]["ID"] = $res->ID;
		$meal[$i]["name"] = $res->name;
		$meal[$i]["location"] = $res->location;
		$meal[$i]["email"] = $res->email;
		$meal[$i]["password"] = $res->password;
		$meal[$i]["job_posting"] = $res->job_posting;
		$meal[$i]["about"] = $res->about;
		$meal[$i]["bio"] = $res->bio;

    $meal[$i]["media"] = array(
      array("path" => $res->video, "type" => $res->video_type),
      array("path" => $res->video2, "type" => $res->video2_type),
      array("path" => $res->fileToUpload, "type" => $res->fileToUpload_type),
      array("path" => $res->fileToUpload2, "type" => $res->fileToUpload2_type),
      array("path" => $res->fileToUpload3, "type" => $res->fileToUpload3_type),
  );

		$meal[$i]["profession"] = $res->profession;
		$meal[$i]["age"] = $res->age;
		$meal[$i]["cv"] = $res->cv;
		$meal[$i]["type"] = $res->type;
        $i++;
	  }
    //--------------------
    $parent["status"] = "200";
    $parent['data'] = $meal;
    echo json_encode($parent);
    //echo json_encode(array('message' => "Success", 'Status' => "200"));


  } else{
	  
	     $ongoing_query_cmp = "select * from bd_user_registration where email=:email";


    $statement = $pdo->prepare($ongoing_query_cmp);

    $statement->execute(array(

    "email" => $event_encoded["email"]
	
  ));
	
  $num_rows_cmp = $statement->rowCount();
   if ($num_rows_cmp > 0) {

    $results = $statement->fetchAll();
    $parent["status"] = "200";
    $parent['data'] = $results;
    echo json_encode($parent);


  } else{
	  
  echo json_encode(array('message' => "No data found", 'status' => "0"));}
}
  
}
 else if ($event_encoded['actiontype'] == "fetch_all_company_for_user") {
	 
	 $sel_user_query1 = "SELECT bd_company_profile.* FROM bd_user_company 
INNER JOIN bd_company_profile 
ON bd_company_profile.ID = bd_user_company.companyid where userid=:userid";
//$userResult = mysqli_query($conn, $sel_user_query1) or die("SQL Query Failed");
  $statement1 = $pdo->prepare($sel_user_query1);
  $statement1->execute(array(
"userid" => $event_encoded["userid"]
));
$num_user_token = $statement1->rowCount();

if ($num_user_token > 0) {
    
    $results = $statement1->fetchAll();
	 $parent["status"] = "200";
	$parent['data'] = $results;
echo json_encode($parent);
}
 }
 else if ($event_encoded['actiontype'] == "fetch_all_user_for_company") {
	 
	 $sel_user_query1 = "SELECT bd_user_registration.* FROM bd_user_company 
INNER JOIN bd_user_registration 
ON bd_user_registration.ID = bd_user_company.userid where companyid=:companyid";
//$userResult = mysqli_query($conn, $sel_user_query1) or die("SQL Query Failed");
  $statement1 = $pdo->prepare($sel_user_query1);
  $statement1->execute(array(
"companyid" => $event_encoded["companyid"]
));
$num_user_token = $statement1->rowCount();

if ($num_user_token > 0) {
    
    $results = $statement1->fetchAll();
	 $parent["status"] = "200";
	$parent['data'] = $results;
echo json_encode($parent);
}
 }
?>