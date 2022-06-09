<?php

error_reporting(E_ALL);
ini_set('display_error',1);

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once "../config/Database.php";
include_once "../model/User.php";

//connect database

$database=new Database;
$connect=$database->connect();

//post attributes

$name='';
$email='';
$password='';
$table_name="users";

//getting raw data from post
$data = json_decode(file_get_contents("php://input"));

$user=new User($connect);

if(count($_POST))
{
    $params = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];

        $exist_user_email = $connect->prepare("SELECT * FROM users WHERE email=?");
        //execute the statement
        $exist_user_email->execute([$_POST['email']]); 
        //fetch result
        $user = $exist_user_email->fetch();
        if ($user) {
            http_response_code(400);
            
            echo json_encode(array("email" => "This Email already Taken"));
        } else {
            if($user->register($params))
            {
                http_response_code(200);
                echo json_encode(array("message" => "User was successfully registered."));
            }else{
                http_response_code(400);
            
                echo json_encode(array("message" => "Unable to register the user."));

            }
        } 

   
    
   
}else if(isset($data))
{
    $params = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];

    if($user->register($params))
    {
        http_response_code(200);
        echo json_encode(array("message" => "User was successfully registered."));
    }else{
        http_response_code(400);
    
        echo json_encode(array("message" => "Unable to register the user."));

    }
}

