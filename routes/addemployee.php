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

if(count($_POST))
{

    
    $exist_user_email = $connect->prepare("SELECT * FROM users WHERE email=?");
    //execute the statement
    $exist_user_email->execute([$_POST['email']]); 
    //fetch result
    $emp = $exist_user_email->fetch();
    if ($emp) {
        
        $_SESSION['emailerror']="This Email Already Taken";
        $_SESSION['oldname']=$_POST['name'];
        $_SESSION['oldemail']=$_POST['email'];
        $_SESSION['oldaddress']=$_POST['address'];
        $_SESSION['oldgender']=$_POST['gender'];
        $_SESSION['olddob']=$_POST['dob'];
        $_SESSION['oldphone']=$_POST['phonenumber'];
        header('location:../administrator/employeeadd.php');
        
    } else {

        $username="FIN".date("Y").strtoupper($_POST['name']);
        //password encrypt
        $password_hash = password_hash($username, PASSWORD_BCRYPT);

        $params = [
            'name' => $_POST['name'],
            'username'=>$username,
            'email' => $_POST['email'],
            'password' => $password_hash,
            'phonenumber'=>$_POST['phonenumber'],
            'gender'=>$_POST['gender'],
            'address'=>$_POST['address'],
            'dob'=>$_POST['dob'],
        ];
       if($employee->Addemployee($params))
       {

        $_SESSION['employeeadded'] ="Employee Added Successfully";
        header('location:../administrator/employeelist.php');
        
       }
       else{
        http_response_code(400);
    
        echo json_encode(array("message" => "Unable to register the user."));

    }

    } 
}
