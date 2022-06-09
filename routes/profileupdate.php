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
$user=new User($connect);

if(count($_POST))
{
    $id=$_SESSION['userid'];
    $params=[
        'name'=>$_POST['name'],
        'email'=>$_POST['email'],
        'phonenumber'=>$_POST['phonenumber'],
    ];

    if($user->updateUser($params,$id))
    {
        $_SESSION['success']="Profile Update Successfully";
        header('location:../administrator/profile.php');
    }

}