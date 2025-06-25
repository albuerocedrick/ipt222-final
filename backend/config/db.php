<?php 

class Database {
    private $host = "localhost";
    private $db_name = "aqxqbdif_act-track";
    private $username = "aqxqbdif_act-track";
    private $password = "gG4jnQJ8qdVfvXmB5ZZX";

    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}

?>