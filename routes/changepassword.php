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
    $newpassword=$_POST['newpassword'];
    $checkpassword = $connect->prepare("SELECT * FROM users WHERE id=?");
    //execute the statement
    $checkpassword->execute([$id]); 

    if($checkpassword->rowCount())

    {
        $row = $checkpassword->fetch(PDO::FETCH_OBJ);

        $userpassword=$row->password;

        if(password_verify($_POST['oldpassword'], $userpassword))
        {
            $user->changeUserpassword($newpassword,$id);
            $_SESSION['success']="Your Password Changed";
            header('location:../administrator/profile.php');

        }else{

            $_SESSION['oldpassworderror']="Your Old Password Doesn't Match Our Database Password";
            header('location:../administrator/profile.php');

        }
    }
   
   
}
