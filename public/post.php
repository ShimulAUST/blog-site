<?php
include '../classes/Database.php';
include '../classes/Post.php';

$db = new Database();
$post = new Post($db);

$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$blogPost = $post->getPostById($postId);
$comments = $post->getComments($postId);

include '../templates/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .blog-post {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 800px;
            background: #fff;
        }

        .comments-section {
            margin: 20px auto;
            max-width: 800px;
        }

        .comment {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .comment h4 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .comment p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .comment-form textarea {
            width: 100%;
            height: 100px;
            margin: 10px 0;
        }

        .comment-form button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .comment-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="blog-post">
        <h1><?php echo $blogPost['title']; ?></h1>
        <p><?php echo $blogPost['content']; ?></p>
        <p><strong>By <?php echo $blogPost['full_name']; ?> in <?php echo $blogPost['category']; ?></strong></p>
    </div>

    <div class="comments-section">
        <h2>Comments</h2>
        <?php while ($comment = $comments->fetch_assoc()): ?>
            <div class="comment">
                <h4><?php echo $comment['full_name']; ?></h4>
                <p><?php echo $comment['comment']; ?></p>
                <small>Posted on <?php echo $comment['created_at']; ?></small>
            </div>
        <?php endwhile; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <h3>Leave a Comment</h3>
            <form method="POST" class="comment-form">
                <textarea name="comment" placeholder="Write your comment..." required></textarea>
                <button type="submit">Post Comment</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Log in</a> to leave a comment.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $comment = $_POST['comment'];
    $userId = $_SESSION['user_id'];
    if ($post->addComment($postId, $userId, $comment)) {
        header("Location: post.php?id={$postId}"); // Refresh page to show new comment
        exit();
    } else {
        echo "<p style='color:red;'>Failed to post comment. Please try again.</p>";
    }
}
?>

<?php 
include '../templates/footer.php';
?>
