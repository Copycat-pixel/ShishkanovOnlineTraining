<?php
require_once __DIR__ . '/../config/Database.php';

class User {
    private $conn;
    private $table = "users";

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function create($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (username, email, password, created_at)
             VALUES (:username, :email, :password, NOW())"
        );
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
    }

    public function getAll() {
        return $this->conn->query("SELECT id, username, email, created_at FROM {$this->table} ORDER BY id DESC")->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT id, username, email, created_at FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function update($id, $username, $email, $password = null) {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare(
                "UPDATE {$this->table}
                 SET username = :username, email = :email, password = :password
                 WHERE id = :id"
            );
            return $stmt->execute([
                ':id' => $id,
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);
        } else {
            $stmt = $this->conn->prepare(
                "UPDATE {$this->table}
                 SET username = :username, email = :email
                 WHERE id = :id"
            );
            return $stmt->execute([
                ':id' => $id,
                ':username' => $username,
                ':email' => $email
            ]);
        }
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function checkLogin($email, $password) {
        $user = $this->getByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
