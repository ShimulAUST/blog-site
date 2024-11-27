<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
<title>Blog Site</title>
</head>

<body>
    <header>
        <nav>
        
            <?php if(isset($_SESSION['user_id'])): ?>
                Welcome, <?php echo $_SESSION['full_name']; ?> |
                <a href="logout.php">Logout</a>

            <?php else: ?>
                <a href="login.php"> Login </a> | <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>

