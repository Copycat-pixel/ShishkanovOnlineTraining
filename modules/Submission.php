<?php
require_once __DIR__ . '/../config/Database.php';

class Submission {
    private $conn;
    private $table = "submissions";

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function create($assignment_id, $student_id, $content) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table}
             (assignment_id, student_id, content, submitted_at)
             VALUES (:assignment_id, :student_id, :content, NOW())"
        );
        return $stmt->execute([
            ':assignment_id' => $assignment_id,
            ':student_id' => $student_id,
            ':content' => $content
        ]);
    }

    public function setGrade($id, $grade) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table} SET grade = :grade WHERE id = :id"
        );
        return $stmt->execute([
            ':id' => $id,
            ':grade' => $grade
        ]);
    }

    public function getByAssignment($assignment_id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE assignment_id = :assignment_id"
        );
        $stmt->execute([':assignment_id' => $assignment_id]);
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
