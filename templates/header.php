<?php
include '../public/init.php';
?>

<!DOCTYPE html>
<html>

<head>
<title>Blog Site</title>
<link rel="stylesheet" href="../assets/css/styles.css"></link>
</head>
<body>
    <header>
        <nav>
            <!-- Logo or Blog Name -->
            <div class="nav-left">
                <a href="index.php" style="color: white; text-decoration: none;">My Blog</a>
            </div>

            <!-- Navigation Links -->
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Profile Update</a></li>
                    <li><a href="post_blog.php">Post Blog</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                <?php endif; ?>
            </ul>

            <!-- Login/Logout Button -->
            <div class="nav-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>