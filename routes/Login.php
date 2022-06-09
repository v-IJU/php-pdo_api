<?php
session_start();
error_reporting(E_ALL);
ini_set('display_error',1);

include_once "../config/Database.php";
include_once "../model/User.php";

//db connection
$database=new Database;
$connect=$database->connect();

//post attributes

$email='';
$password='';
$table_name="users";



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

            $_SESSION['loggedin']=true;
            $_SESSION['username']=$row->name;
            $_SESSION['userid']= $row->id;
            
            header('location: ../administrator/dashboard.php');
        
            

        }else{
            $_SESSION['msg'] = "Please Provide Valid Password !!"; 
            header('location: ../administrator/login.php');
            }
    }
    else{
        $_SESSION['msg'] = "We can't Find Information or credentials Not Match"; 
        header('location: ../administrator/login.php');

    }
}