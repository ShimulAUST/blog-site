<?php
include '../public/init.php';
include '../classes/Database.php';
include '../classes/User.php';
include '../templates/header.php';
$db = new Database();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $db->escape($_POST['email']);
    $password = $_POST['password'];

    if ($user->login($email, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<link rel="stylesheet" href="../assets/css/login.css"></link>

<div id="login-page">
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</div>
<?php
include '../templates/footer.php';

?>
