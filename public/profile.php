<?php
include '../public/init.php';
include '../templates/header.php';
include '../classes/Database.php';
include '../classes/User.php';

$db = new Database();
$user = new User($db);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$message = '';

// Fetch user details
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $userDetails = $user->getUserById($userId);
    if (!$userDetails) {
        echo "User not found!";
        exit();
    }
} else {
    // Handle form submission
    $fullName = $_POST['full_name'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    if (empty($fullName)) {
        $message = "Full Name is required!";
    } else {
        if ($user->updateUserProfile($userId, $fullName, $password)) {
            $message = "Profile updated successfully!";
        } else {
            $message = "Error updating profile.";
        }
    }

    // Fetch updated details to reflect changes
    $userDetails = $user->getUserById($userId);
}
?>


<link rel="stylesheet" href="../assets/css/profile.css"></link>
</main>
<div class="container">
    <h1>Update Profile</h1>
    <?php if ($message): ?>
        <p class="<?php echo strpos($message, 'Error') === false ? 'message' : 'error'; ?>">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>
    <form method="POST">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo $userDetails['full_name'] ?? ''; ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $userDetails['email'] ?? ''; ?>" readonly>

        <label for="password">Password (Leave blank to keep the current password)</label>
        <input type="password" id="password" name="password">

        <button type="submit">Update Profile</button>
    </form>
</div>
</main>
<?php
include "../templates/footer.php";
?>
