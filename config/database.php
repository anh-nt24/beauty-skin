<?php

class Database {
    private static $instance = null;
    private $connection;

    private $host = 'localhost';
    private $dbName = 'BeautySkin';
    private $username = 'root';
    private $password = '';

    private function __construct() {
        try {
            $this->connection = new PDO("mysql:host=$this->host", $this->username, $this->password);
            $this->createDatabaseIfNotExists();
            $this->connection->exec("USE $this->dbName");
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // ensure the class cannot be cloned
    private function __clone() {}
    private function __wakeup() {}

    // singleton
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }


    private function createDatabaseIfNotExists() {
        $this->connection->exec("CREATE DATABASE IF NOT EXISTS $this->dbName");
        $this->connection->exec("USE $this->dbName");

        // create table users
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS users (
                user_id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                role ENUM('client', 'admin') DEFAULT 'client',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }
}
