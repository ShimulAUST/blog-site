<?php

class Category{
private $db;

public function __construct(Database $db){
    $this->db = $db;
}

public function addCategory($name){
    $sql = "INSERT INTO categories(name) VALUES ('{$name}')";
    return $this->db->query($sql);
}
public function getAllCategories(){
    $sql = "SELECT * FROM categories";
    return $this->db->query($sql);
}

}