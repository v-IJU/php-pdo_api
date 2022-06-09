<?php

error_reporting(E_ALL);
ini_set('display_error',1);

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/Database.php";
include_once "../model/User.php";
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

//connect database

$database=new Database;
$connect=$database->connect();

//post attributes

$email='';
$password='';
$table_name="users";

//getting raw data from post
$data = json_decode(file_get_contents("php://input"));

$user=new User($connect);

if(count($_POST))

{
           
           
            $exist_user_email = $connect->prepare("SELECT * FROM users WHERE email=?");
            //execute the statement
            $exist_user_email->execute([$_POST['email']]); 
            //fetch result
            if($exist_user_email->rowCount())

            {
                $row = $exist_user_email->fetch(PDO::FETCH_OBJ);

                $params = [
                    'id'=>$row->id,
                    'email' => $row->email,
                    'password' => $row->password,
                    'name'=>$row->name,
                ];

                $userid=$row->id;
                $username=$row->name;
                $useremail=$row->email;
                $userpassword=$row->password;

                if(password_verify($_POST['password'], $userpassword))
                {
                    $userlogin=$user->login($params);

                    if($userlogin)
                    {
                        http_response_code(200);
                            
                        echo json_encode(array("data" => $userlogin));
                        
                
                    }

                }else{
                    http_response_code(400);
            
                    echo json_encode(array("error" => "Password Not Match"));

                }
            }
            else{
                http_response_code(400);
        
                echo json_encode(array("error" => "we can't find information about this email"));

            }
   

    

}else if(isset($data))

{

}

