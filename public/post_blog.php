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

$message = '';
$title = '';
$content = '';
$categoryId = '';
$postId = isset($_GET['post_id']) ? (int)$_GET['post_id'] : null;

// If post_id exists, fetch the existing post details
if ($postId) {
    $existingPost = $post->getPostById($postId, $_SESSION['user_id']);
    if (!$existingPost) {
        $message = "Post not found or you don't have permission to edit it.";
    } else {
        $title = $existingPost['title'];
        $content = $existingPost['content'];
        $categoryId = $existingPost['category_id'];
    }
}

// Handle form submission for both create and update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $db->escape($_POST['title']);
    $content = $db->escape($_POST['content']);
    $categoryId = (int)$_POST['category'];
    $authorId = $_SESSION['user_id'];

    if (empty($title) || empty($content) || empty($categoryId)) {
        $message = "All fields are required!";
    } else {
        if ($postId) {
            // Update post
            if ($post->updatePost($postId, $title, $content, $categoryId, $authorId)) {
                $message = "Blog post updated successfully!";
            } else {
                $message = "Error updating blog post: " . $db->error;
            }
        } else {
            // Create new post
            if ($post->createPost($title, $content, $categoryId, $authorId)) {
                $message = "Blog post created successfully!";
            } else {
                $message = "Error creating blog post: " . $db->error;
            }
        }
    }
}

// Fetch categories for the dropdown
$categories = $db->query("SELECT id, name FROM categories");
?>

<link rel="stylesheet" href="../assets/css/postblog.css"></link>
<div id="post-blog-page">
    <div class="container">
        <h1><?php echo $postId ? "Edit Blog Post" : "Create a Blog Post"; ?></h1>
        <?php if ($message): ?>
            <p class="<?php echo strpos($message, 'Error') === false ? 'message' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

            <label for="content">Content</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($content); ?></textarea>

            <label for="category">Category</label>
            <select id="category" name="category" required>
                <option value="">--Select Category--</option>
                <?php while ($category = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo $categoryId == $category['id'] ? 'selected' : ''; ?>>
                        <?php echo $category['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit"><?php echo $postId ? "Update Post" : "Post Blog"; ?></button>
        </form>
    </div>
</div>

<?php
include '../templates/footer.php';
?>
