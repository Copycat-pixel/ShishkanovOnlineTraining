<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment {
    private $conn;
    private $table = "enrollments";

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function create($student_id, $course_id) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (student_id, course_id, enrolled_at)
             VALUES (:student_id, :course_id, NOW())"
        );
        return $stmt->execute([
            ':student_id' => $student_id,
            ':course_id' => $course_id
        ]);
    }

    public function getByStudent($student_id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE student_id = :student_id"
        );
        $stmt->execute([':student_id' => $student_id]);
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
