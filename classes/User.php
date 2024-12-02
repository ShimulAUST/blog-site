<?php
include '../public/init.php';

class User{
private $db;

public function __construct(Database $db){
    $this->db = $db;
}

public function register($fullName, $username, $email, $password) {
    // Check if email already exists
    $emailCheckSql = "SELECT id FROM users WHERE email = '{$email}' LIMIT 1";
    $result = $this->db->query($emailCheckSql);

    if ($result->num_rows > 0) {
        // Email already exists
        return false;
    }

    // If email does not exist, proceed with insertion
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (full_name, username, email, password) VALUES 
            ('{$fullName}', '{$username}', '{$email}', '{$hashedPassword}')";
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

// Fetch user details by ID
public function getUserById($userId) {
    $sql = "SELECT full_name, email FROM users WHERE id = {$userId}";
    $result = $this->db->query($sql);
    return $result ? $result->fetch_assoc() : null;
}

// Update user profile
public function updateUserProfile($userId, $fullName, $password = null) {
    $fullName = $this->db->escape($fullName);
    $updateSql = "UPDATE users SET full_name = '{$fullName}'";

    if ($password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $updateSql .= ", password = '{$hashedPassword}'";
    }

    $updateSql .= " WHERE id = {$userId}";
    return $this->db->query($updateSql);
}


public function isLoggedIn(){
    return isset($_SESSION['user_id']);
}

public function logout(){
    session_unset();
    session_destroy();
}

}




