<?php

error_reporting(E_ALL);
ini_set('display_error',1);
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Blog{

    //database data

    private $connection;
    private $table="blog";

    //fillable properties from table blog

    public $id;
    public $category_id;
    public $title;
    public $created_at;
    protected $key="finance__site";

    public function __construct($database)
    {
        $this->connection=$database;
    }

   
    public function readData()
    {
        $query='SELECT cat.categoryname as categoryname,
        blog.id as id,
        blog.title as title, 
        blog.created_at as created_at 
        FROM '.$this->table.' blog LEFT JOIN category cat ON blog.category_id = cat.id ORDER BY blog.created_at DESC' ;

        $blogs=$this->connection->prepare($query);

        $blogs->execute();

        

        return $blogs;
    }
}