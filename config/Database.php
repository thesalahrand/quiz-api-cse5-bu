<?php 
  namespace config;

  class Database {
    private $dbHost, $dbName, $dbUser, $dbPas, $conn;

    public function __construct() {
      $this->dbHost = $_ENV['DB_HOST'];
      $this->dbUser = $_ENV['DB_USER'];
      $this->dbPass = $_ENV['DB_PASS'];
      $this->dbName = $_ENV['DB_NAME'];
    }

    public function connect() {
      $this->conn = null;

      try { 
        $this->conn = new \PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPass);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }
?>