<?php
include '../public/init.php';
include '../classes/Database.php';
include '../classes/Post.php';
include '../classes/Comment.php';

$db = new Database();
$post = new Post($db);
$comment = new Comment($db);

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$posts = $post->getPaginatedPosts($limit, $offset);
$totalPosts = $post->getTotalPostCount();
$totalPages = ceil($totalPosts / $limit);

include '../templates/header.php';
?>



<link rel="stylesheet" href="../assets/css/index.css">
<h1 style="text-align: center;">Blog Posts</h1>
<main>
<div class="blog-container">
    <?php while ($row = $posts->fetch_assoc()): ?>
        <div class="blog-card">
            <h2><?php echo $row['title']; ?></h2>
            <p><?php echo substr($row['content'], 0, 100) . '...'; ?></p>
            <p class="author">By <?php echo $row['full_name']; ?> in <?php echo $row['category']; ?></p>

            <!-- Display Comments -->
            <div class="comments" id="comments-<?php echo $row['id']; ?>">
                <?php
                $commentsResult = $comment->getCommentsByPost($row['id']);
                $commentCount = 0;
                while ($commentRow = $commentsResult->fetch_assoc()):
                    $commentCount++;
                    if ($commentCount > 3) break;
                ?>
                    <div class="comment">
                        <strong><?php echo $commentRow['full_name']; ?>:</strong>
                        <?php echo $commentRow['comment']; ?>
                        <small><?php echo $commentRow['created_at']; ?></small>
                    </div>
                <?php endwhile; ?>
                <?php if ($commentCount > 3): ?>
                    <a class="see-more" href="post.php?id=<?php echo $row['id']; ?>">See more comments</a>
                <?php endif; ?>
            </div>

            <!-- Comment Form -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <form method="POST" class="comment-form" data-post-id="<?php echo $row['id']; ?>">
                    <textarea name="comment" placeholder="Write a comment..." required></textarea>
                    <button type="button" class="submit-comment">Post</button>
                </form>
            <?php else: ?>
                <p><a href="login.php">Log in</a> to comment.</p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>
            
<!-- Pagination -->
<nav class="pagination">
    <ul>
        <?php if ($page > 1): ?>
            <li><a href="?page=<?php echo $page - 1; ?>">Previous</a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li><a href="?page=<?php echo $i; ?>" <?php echo $i == $page ? 'style="font-weight:bold;"' : ''; ?>><?php echo $i; ?></a></li>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
            <li><a href="?page=<?php echo $page + 1; ?>">Next</a></li>
        <?php endif; ?>
    </ul>
</nav>
</main>
<script src="../assets/js/index.js"></script>

<?php include '../templates/footer.php'; ?>
