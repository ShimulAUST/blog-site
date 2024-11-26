<?php

class Comment{
private $db;

public function __construct(Database $db){
    $this->db = $db;
}

public function addComment($postId, $userId, $comment){
    $sql = "INSERT INTO comments(post_id, user_id, comment, created_at) VALUES 
            ({$postId},{$userId}, '{$comment}', NOW())";
    return $this->db->query($sql);
}
public function getCommentsByPost($postId){
    $sql = "SELECT comments.*, users.full_name 
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE post_id = {$postId}";
    return $this->db->query($sql);
}

}