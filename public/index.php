<?php
include '../classes/Database.php';
include '../classes/Post.php';

$db = new Database();
$post = new Post($db);


$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page -1) * $limit;

$posts = $post->getPaginatedPosts($limit, $offset);
$totalPosts = $post->getTotalPostCount();
$totalPages = ceil($totalPosts/$limit);

include '../templates/header.php';
?>





<?php 
include '../templates/footer.php';
?>

