<?php

session_start();
error_reporting(E_ALL);
ini_set('display_error',1);

include_once "../config/Database.php";
include_once "../model/Employee.php";

//db connection
$database=new Database;
$connect=$database->connect();


$table_name="employees";

//getting raw data from post
$data = json_decode(file_get_contents("php://input"));

$employee=new Employee($connect);

if(isset($_GET['status']))
{
    $params=[
        'status'=>$_GET['status'],
        'empid'=>$_GET['userid'],
    ];

    if($employee->statuschange($params))
    {
        http_response_code(200);
        echo json_encode(array("message" => "Status Changed"));
    }else{
        http_response_code(400);
    
        echo json_encode(array("message" => "Unable to change"));

    }
}