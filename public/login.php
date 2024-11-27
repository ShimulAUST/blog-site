<?php

include '../classes/Database.php';
include '../classes/User.php';

$db = new Database();
$user = new User($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $db->escape($_POST['email']);
    $password = $_POST['password'];

    if($user->login($email,$password)){
        header('Location: dashboard.php');
        exit();
    } else{
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>    
    </head>
<body>
    <h1>Login</h1>
    <?php if(isset($error)) echo "<p style='color:red;'> $error </p>"; ?>
    <form method="POST" action="">
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
    </form>
</body>
</html>
