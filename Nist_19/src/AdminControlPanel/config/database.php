<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    private $pdo;

    public function __construct() {
        // Use environment variables for PostgreSQL connection
        $this->host = $_ENV['PGHOST'] ?? 'localhost';
        $this->db_name = $_ENV['PGDATABASE'] ?? 'nist19_admin';
        $this->username = $_ENV['PGUSER'] ?? 'postgres';
        $this->password = $_ENV['PGPASSWORD'] ?? '';
        $this->port = $_ENV['PGPORT'] ?? '5432';
    }

    public function connect() {
        $this->pdo = null;
        
        try {
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
            die();
        }
        
        return $this->pdo;
    }
}

// Global database connection function
function getDB() {
    static $database = null;
    if ($database === null) {
        $database = new Database();
    }
    return $database->connect();
}
?>
