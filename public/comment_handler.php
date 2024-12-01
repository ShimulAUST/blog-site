<?php

// Include necessary class files
include '../public/init.php';
include '../classes/Database.php';
include '../classes/Comment.php';

header('Content-Type: application/json'); // Ensure the response is JSON

$db = new Database();
$comment = new Comment($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $postId = isset($_POST['submit_comment']) ? intval($_POST['submit_comment']) : 0;
    $commentText = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    if (empty($commentText)) {
        echo json_encode(["success" => false, "message" => "Comment cannot be empty."]);
        exit;
    }

    if ($postId <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid post ID."]);
        exit;
    }

    $userId = $_SESSION['user_id'];

    if ($comment->addComment($postId, $userId, $commentText)) {
        echo json_encode([
            "success" => true,
            "full_name" => $_SESSION['full_name'], // Ensure 'user_name' is set in session
            "comment" => htmlspecialchars($commentText),
            "created_at" => date("Y-m-d H:i:s")
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to post comment."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request or unauthorized access."]);
}
