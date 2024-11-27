<?php
session_start();

class User{
private $db;

public function __construct(Database $db){
    $this->db = $db;
}

public function register($fullName,$username,$email,$password){

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql ="INSERT INTO users (full_name,username,email,password) VALUES 
            ('{$fullName}','{$username}','{$email}','{$hashedPassword}')";
    return $this->db->query($sql);
}

public function login($email,$password){
    $sql = "SELECT  * FROM users WHERE email = '{$email}'";
    $result = $this->db->query($sql);

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(password_verify($password,$user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
    }
    return false;
}

public function isLoggedIn(){
    return isset($_SESSION['user_id']);
}

public function logout(){
    session_unset();
    session_destroy();
}

}




