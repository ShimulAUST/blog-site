<?php

class Database{

    private $host = "localhost";
    private $username ="";
    private $password ="";
    private $dbName ="blog";
    private $conn;

    public function __construct(){
        
        $this->conn = new mysqli($this->host,$this->username,$this->password,$this->dbName);
        if($this->conn->connect_error){
            die("Connection failed: ". $this->conn->connect_error);
        }
    }

    public function query($sql){
    
        return $this->conn->query($sql);
    }

    public function escape($string){
        return $this->conn->real_escape_string($string);
    }

    public function close(){
        $this->conn->close();
    }


}

