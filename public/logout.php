<?php
include '../public/init.php';
include '../classes/Database.php';
include '../classes/User.php';

$db = new Database();
$user = new User($db);

// Call the logout method
$user->logout();

// Redirect to the login page
header('Location: login.php');
exit();
?>
