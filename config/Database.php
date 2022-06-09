<?php

class Database{

    //Database information

    private $hostname="localhost";
    private $username="root";
    private $password="";
    private $database_name="blog";
    private $connection;
    private $opts = [
        PDO::ATTR_ERRMODE                  => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE       => PDO::FETCH_BOTH,
        PDO::ATTR_EMULATE_PREPARES         => false,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
      ];

    public function connect()
    {
        $this->connection = null;


        try
        {
            $this->connection = new PDO('mysql:host='.$this->hostname.';dbname='.$this->database_name, 
                $this->username, 
                $this->password,
               
            );
           
            
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }

        return $this->connection;
        
    }

}

