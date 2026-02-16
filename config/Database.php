<?php
class Database {
    private $host = "localhost";
    private $db_name = "online learning platform";
    private $username = "root";
    private $password = "";
    private $charset = "utf8mb4";
    public $conn;

    public function connect() {
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("DB Error: " . $e->getMessage());
        }

        return $this->conn;
    }
}
