<?php

error_reporting(E_ALL);
ini_set('display_error',1);


class Employee
{

     //database data

     private $connection;
     private $table="employees";
 
     //fillable properties from table blog
 
     public $id;
     public $name;
     public $username;
     public $email;
     public $phonenumber;
     public $dob;
     public $gender;
     public $address;
     public $status;
     public $created_at;
     public $updated_at;
    
    public function __construct($database)

    {
        $this->connection=$database;
    }

    public function Addemployee($params)

    {
            try{

                $this->name=$params['name'];
                $this->username=$params['username'];
                $this->email=$params['email'];
                $this->phonenumber=$params['phonenumber'];
                $this->dob=$params['dob'];
                $this->gender=$params['gender'];
                $this->address=$params['address'];
                $this->password=$params['password'];
        
                //insert query
                $query = "INSERT INTO " . $this->table . "
                SET name = :name,
                username=:username,
                email = :email,
                dob = :dob,
                gender=:gender,
                address=:address,
                phonenumber=:phonenumber,

                password = :password";
        
                $stmt = $this->connection->prepare($query);
                $stmt->bindValue(':name', $this->name);
                $stmt->bindValue(':username', $this->username);
                $stmt->bindValue(':dob', $this->dob);
                $stmt->bindValue(':email', $this->email);
                $stmt->bindValue(':phonenumber', $this->phonenumber);
                $stmt->bindValue(':gender', $this->gender);
                $stmt->bindValue(':address', $this->address);
                $stmt->bindValue(':password', $this->password);

              if($stmt->execute())
              {
                  return true;
              }
              return false;

              
                   

            } catch(PDOException $e)
            {
                var_dump($e->getCode());
                var_dump($e->getMessage());
                var_dump($e->errorInfo);
            }
    }


    public function readData()
    {
        try{

            $query='SELECT *  
            FROM '.$this->table.' ORDER BY created_at DESC' ;
    
            $empdata=$this->connection->prepare($query);
    
            $empdata->execute();
    
            
    
            return $empdata;

        }
        catch(PDOException $e)
            {
                var_dump($e->getCode());
                var_dump($e->getMessage());
                var_dump($e->errorInfo);
            }
    }

    public function getEmployee($id)
    {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM employees WHERE id=? LIMIT 1"); 
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

    public function Updateemployee($params,$id)

    {
            try{

                $this->name=$params['name'];
                $this->username=$params['username'];
                $this->email=$params['email'];
                $this->phonenumber=$params['phonenumber'];
                $this->dob=$params['dob'];
                $this->gender=$params['gender'];
                $this->address=$params['address'];
                $this->password=$params['password'];
        
                //insert query
                $query = "UPDATE " . $this->table . "
                SET name = :name,
                username=:username,
                email = :email,
                dob = :dob,
                gender=:gender,
                address=:address,
                phonenumber=:phonenumber,

                password = :password WHERE id=:empid";
        
                $stmt = $this->connection->prepare($query);
                $stmt->bindValue(':name', $this->name);
                $stmt->bindValue(':username', $this->username);
                $stmt->bindValue(':dob', $this->dob);
                $stmt->bindValue(':email', $this->email);
                $stmt->bindValue(':phonenumber', $this->phonenumber);
                $stmt->bindValue(':gender', $this->gender);
                $stmt->bindValue(':address', $this->address);
                $stmt->bindValue(':password', $this->password);
                $stmt->bindValue(':empid', $id);

              if($stmt->execute())
              {
                  return true;
              }
              return false;

              
                   

            } catch(PDOException $e)
            {
                var_dump($e->getCode());
                var_dump($e->getMessage());
                var_dump($e->errorInfo);
            }
    }

    public function statuschange($params)
    {
        try{
            $this->status=$params['status'];
            $this->id=$params['empid'];

            $query = "UPDATE " . $this->table . "
            SET status = :status 
            WHERE id=:empid";

            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':status', $this->status);
            $stmt->bindValue(':empid', $this->id);

            if($stmt->execute())
              {
                  return true;
              }
              return false;

        }catch(PDOException $e)
            {
                var_dump($e->getCode());
                var_dump($e->getMessage());
                var_dump($e->errorInfo);
            }
    }

    public function deleteemployee($empid)
    {
        try{
            $query = "DELETE FROM " . $this->table . "
           
            WHERE id=:empid";

            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(':empid', $empid);

            if($stmt->execute())
              {
                  return true;
              }
              return false;

        }catch(PDOException $e)
            {
                var_dump($e->getCode());
                var_dump($e->getMessage());
                var_dump($e->errorInfo);
            }
    }

}