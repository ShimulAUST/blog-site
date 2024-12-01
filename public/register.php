<?php
include '../public/init.php';
include '../classes/Database.php';
include '../classes/User.php';
include '../templates/header.php';

$db = new Database();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $db->escape($_POST['full_name']);
    $username = $db->escape($_POST['username']);
    $email = $db->escape($_POST['email']);
    $password = $_POST['password'];

    if ($user->register($fullName, $username, $email, $password)) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Registration Failed. Please try again...";
    }
}
?>

<link rel="stylesheet" href="../assets/css/register.css"></link>

<div id="register-page">
    <div class="container">
        <h1>Register</h1>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </div>
</div>
<?php
include '../templates/footer.php';
?>
