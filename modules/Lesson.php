<?php
require_once __DIR__ . '/../config/Database.php';

class Lesson {
    private $conn;
    private $table = "lessons";

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function create($course_id, $title, $content) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (course_id, title, content, created_at)
             VALUES (:course_id, :title, :content, NOW())"
        );
        return $stmt->execute([
            ':course_id' => $course_id,
            ':title' => $title,
            ':content' => $content
        ]);
    }

    public function getByCourse($course_id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE course_id = :course_id"
        );
        $stmt->execute([':course_id' => $course_id]);
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
