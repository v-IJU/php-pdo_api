<?php

error_reporting(E_ALL);
ini_set('display_error',1);
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;
use \Carbon\Carbon;

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/Database.php";
include_once "../model/Blog.php";

//variables declate
$key = "finance__site";
$jwt = null;
//connect database

$database=new Database;
$connect=$database->connect();

//getting jwt token from header
$authHeader = substr(getallheaders()["Authorization"], 7);

//$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$arr = explode(" ", isset($authHeader));

//set jwt token 
$jwt =$authHeader;



$blog=new Blog($connect);



if(isset($jwt)){

    try {

        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        // Access is granted. Add code of the operation here 
        $blog_data=$blog->readData();
        if($blog_data->rowCount())

        {
            $blogs=[];
            while($row = $blog_data->fetch(PDO::FETCH_OBJ))
            {
                $blogs[$row->id]=[
                    'id'=>$row->id,
                    'title'=>$row->title,
                    'category'=>$row->categoryname,
                    'created_at'=>$row->created_at
        
                ];
            }
            echo json_encode(array('message' => 'Post Is there','data'=>$blogs));
            }else{
                echo json_encode(array('message' => 'No post Found'));
            }

    }catch (Exception $e){

            http_response_code(401);

            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ));
}

}



