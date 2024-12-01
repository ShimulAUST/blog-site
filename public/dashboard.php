<?php
include '../public/init.php';
include '../classes/Database.php';
include '../classes/Post.php';
include '../templates/header.php';

$db = new Database();
$post = new Post($db);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$message = '';

// Handle blog deletion
if (isset($_GET['delete']) && isset($_GET['post_id'])) {
    $postId = (int)$_GET['post_id'];
    if ($post->deletePost($postId, $userId)) {
        $message = "Post deleted successfully!";
    } else {
        $message = "Failed to delete the post.";
    }
}

// Fetch user's posts
$userPosts = $post->getUserPosts($userId);
?>

<link rel="stylesheet" href="../assets/css/dashboard.css"></link>
    <script>
        function confirmDelete(postId) {
            if (confirm("Are you sure you want to delete this post?")) {
                window.location.href = `dashboard.php?delete=1&post_id=${postId}`;
            }
        }
    </script>
<div id="dashboard-page">
<div class="container">
    <h1>Your Dashboard</h1>
    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Content Snippet</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $userPosts->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo substr($row['content'], 0, 50) . '...'; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td class="actions">
                    <a href="post_blog.php?post_id=<?php echo $row['id']; ?>">Edit</a>
                    <button onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div>


<?php
include '../templates/footer.php';

?>
