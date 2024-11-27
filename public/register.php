<?php
include '../classes/Database.php';
include '../classes/User.php';


$db = new Database();
$user = new User($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $fullName = $db->escape($_POST['full_name']);
    $username = $db->escape($_POST['username']);
    $email = $db->escape($_POST['email']);
    $password = $_POST['password'];

    if($user->register($fullName,$username,$email,$password)){
        header('Location: login.php');
        exit();
    } else{
        $error = "Registration Failed. Please try again...";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
    </head>
    <body>
        <h1> Register</h1>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" action="">
            <label> Full Name: </label>
            <input type="text" name="full_name" required><br>
            <label> Username: </label>
            <input type="text" name="username" required><br>
            <label> Email: </label>
            <input type="email" name="email" required><br>
            <label> Password: </label>
            <input type="password" name="password" required><br>
            <button type="submit"> Register</button>
        </form>
    </body>
</html>