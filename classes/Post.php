<?php

class Post{
    private $db;

    public function __construct(Database $db){
        $this->db = $db;
    }

    public function createPost($title,$content,$categoryId,$authorId){
        $sql ="INSERT INTO posts(title, content,category_id,author_id,created_at) VALUES
        ('{$title}','{$content}','{$categoryId}',{$authorId},NOW())";
        return $this->db->query($sql);
    }

    public function getPaginatedPosts($limit,$offset){
        $sql = "SELECT posts.*, users.full_name, categories.name AS category 
                FROM posts 
                JOIN users ON posts.author_id = users.id
                JOIN categories ON posts.category_id = categories.id
                LIMIT {$limit} OFFSET {$offset}";
        return $this->db->query($sql);
    }
    public function getPostById($postId, $userId) {
        $sql = "SELECT * FROM posts WHERE id = {$postId} AND author_id = {$userId}";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    
    public function getTotalPostCount(){
        $sql = "SELECT COUNT(*) as total FROM posts";
        $result = $this->db->query($sql)->fetch_assoc();
        return $result['total'];
    }

    public function getUserPosts($userId) {
        $sql = "SELECT * FROM posts WHERE author_id = {$userId} ORDER BY created_at DESC";
        return $this->db->query($sql);
    }
    public function deletePost($postId, $userId) {
        $sql = "DELETE FROM posts WHERE id = {$postId} AND author_id = {$userId}";
        return $this->db->query($sql);
    }
    public function updatePost($postId, $title, $content, $categoryId, $userId) {
        $sql = "UPDATE posts SET 
                    title = '{$title}', 
                    content = '{$content}', 
                    category_id = {$categoryId} 
                WHERE id = {$postId} AND author_id = {$userId}";
        return $this->db->query($sql);
    }

}