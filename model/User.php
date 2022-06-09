<?php

error_reporting(E_ALL);
ini_set('display_error',1);

require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class User{
    private $connection;
    private $table="users";

    //fillable properties from table blog

    public $id;
    public $name;
    public $email;
    public $password;
    public $phonenumber;
    public $created_at;

    public function __construct($database)
    {
        $this->connection=$database;
    }

    public function register($params)
    {
        try{
             //value assign in params

        $this->name=$params['name'];
        $this->email=$params['email'];
        $this->password=$params['password'];

        //insert query
        $query = "INSERT INTO " . $this->table . "
        SET name = :name,
        email = :email,
        password = :password";

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':email', $this->email);

        //password encrypt
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindValue(':password', $password_hash);
        if($stmt->execute())
        {
            return true;
        }

        return false;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
       


    }

    public function login($params)
    {   
        try
        {
            $this->email=$params['email'];
            $this->password=$params['password'];
            $this->id=$params['id'];
            $this->name=$params['name'];
            if($params['web']=='weblogin')
            {
                $key = "finance__site";
                $issuedat_claim = time(); // issued at
                $notbefore_claim = $issuedat_claim; //not before in seconds
                //$expire_claim = time() + (2.592e+6*2.592e+6); // expire time in seconds 30 days
                $expire_claim = time() + 60;
                $payload = array(
                    "iss" => "http://localhost",
                    "aud" => "http://localhost",
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $this->id,
                        "name" => $this->name,
                        "email" => $this->email
                )
                );
    
                $jwt = JWT::encode($payload, $key, 'HS256');
                $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    
              
              
                $data=[
                    "message" => "Successful login.",
                    "jwt" => $jwt,
                    "email" => $this->email,
                    "exp"=> $expire_claim,
                   
    
                ];
                    return $data;

            }else{
                return true;

            }
           

            //jwt process
           
   
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
      
    }

    public function getUser($id)
    {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE id=? LIMIT 1"); 
            $stmt->execute([$id]); 
            $row = $stmt->fetch();
            
    
            return $row;

        }
        catch(PDOException $e)
            {
                var_dump($e->getCode());
                var_dump($e->getMessage());
                var_dump($e->errorInfo);
            }

    }

    public function updateUser($params,$id)
    {
        try{
            $this->name=$params['name'];
            $this->email=$params['email'];
            $this->phonenumber=$params['phonenumber'];
            $query = "UPDATE " . $this->table . "
                SET name = :name,
                email = :email,
                phonenumber=:phonenumber
                WHERE id=:userid";

                $stmt = $this->connection->prepare($query);
                $stmt->bindValue(':name', $this->name);
                $stmt->bindValue(':email', $this->email);
                $stmt->bindValue(':phonenumber', $this->phonenumber);
                $stmt->bindValue(':userid', $id);

            
    
                if($stmt->execute())
                {
                    return true;
                }
                return false;

        }
        catch(PDOException $e)
            {
                var_dump($e->getCode());
                var_dump($e->getMessage());
                var_dump($e->errorInfo);
            }
    }

    public function changeUserpassword($newpassword,$id)

    {
        try{
            $this->password=$newpassword;
          
            $query = "UPDATE " . $this->table . "
                SET 
                password=:password
                WHERE id=:userid";

                $stmt = $this->connection->prepare($query);
                $password_hash = password_hash( $this->password, PASSWORD_BCRYPT);
                $stmt->bindValue(':password',$password_hash);
                $stmt->bindValue(':userid', $id);

            
    
                if($stmt->execute())
                {
                    return true;
                }
                return false;

        }
        catch(PDOException $e)
            {
                var_dump($e->getCode());
                var_dump($e->getMessage());
                var_dump($e->errorInfo);
            }

    }
}