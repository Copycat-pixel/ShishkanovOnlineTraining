<?php
require_once __DIR__ . '/../config/Database.php';

class Assignment {
    private $conn;
    private $table = "assignments";

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function create($lesson_id, $title, $description, $due_date) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (lesson_id, title, description, due_date)
             VALUES (:lesson_id, :title, :description, :due_date)"
        );
        return $stmt->execute([
            ':lesson_id' => $lesson_id,
            ':title' => $title,
            ':description' => $description,
            ':due_date' => $due_date
        ]);
    }

    public function getByLesson($lesson_id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE lesson_id = :lesson_id"
        );
        $stmt->execute([':lesson_id' => $lesson_id]);
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
