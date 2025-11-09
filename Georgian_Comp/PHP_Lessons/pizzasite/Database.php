<?php
class Database
{
    // These properties pull values from config.php
    private $host = DB_HOST;
    private $db   = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;

    // This property will hold the PDO object
    private $pdo;

    // Method to return a database connection
    public function getConnection()
    {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
                $this->pdo = new PDO($dsn, $this->user, $this->pass);

                // Throw exceptions on error
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                die("Could not connect to the database: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}
