<?php
declare(strict_types=1);

class Database {
    private string $host;
    private string $db_name;
    private string $username;
    private string $password;
    private ?PDO $conn = null;

    public function __construct(
        string $host = "localhost:3306",
        string $db_name = "crud",
        string $username = "root",
        string $password = ""
    ) {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
    }

    public function getConnection(): ?PDO {
        if ($this->conn === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
                $this->conn = new PDO($dsn, $this->username, $this->password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_PERSISTENT => true,
                ]);
            } catch (PDOException $exception) {
                error_log("Database connection error: " . $exception->getMessage());
                return null;
            }
        }

        return $this->conn;
    }
}
