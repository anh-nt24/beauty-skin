<?php

require_once __DIR__ . "/../src/models/Account.php";
require_once __DIR__ . "/../src/models/Admin.php";
require_once __DIR__ . "/constants.php";

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
            $this->initAdminAccount();
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // ensure the class cannot be cloned or serialized for singleton
    private function __clone() {}
    public function __wakeup() {}

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

        $sql = "
            CREATE TABLE IF NOT EXISTS accounts (
                id INT PRIMARY KEY AUTO_INCREMENT,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role ENUM('" . ROLE_CLIENT . "', '" . ROLE_ADMIN . "') DEFAULT '" . ROLE_CLIENT . "',
                registration_date DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS customers (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                phone VARCHAR(20) NOT NULL UNIQUE,
                address VARCHAR(255) NOT NULL,
                account_id INT NOT NULL,
                FOREIGN KEY (account_id) REFERENCES accounts(id)
            );

            CREATE TABLE IF NOT EXISTS admin (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL UNIQUE,
                account_id INT NOT NULL,
                FOREIGN KEY (account_id) REFERENCES accounts(id)
            );

            CREATE TABLE IF NOT EXISTS products (
                id INT PRIMARY KEY AUTO_INCREMENT,
                product_name VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                category VARCHAR(20) NOT NULL,
                stock INT DEFAULT 0,
                image VARCHAR(2048)
            );

            CREATE TABLE IF NOT EXISTS orders (
                id INT PRIMARY KEY AUTO_INCREMENT,
                customer_id INT NOT NULL,
                order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                shipping_address TEXT NOT NULL,
                total_amount DECIMAL(10, 2) NOT NULL,
                order_status ENUM('" . STATE_1 . "', '" . STATE_2 . "', '" . STATE_3 . "', '" . STATE_4 . "') DEFAULT '" . STATE_1 . "',
                FOREIGN KEY (customer_id) REFERENCES customers(id)
            );

            CREATE TABLE IF NOT EXISTS order_details (
                id INT PRIMARY KEY AUTO_INCREMENT,
                order_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT DEFAULT 1,
                FOREIGN KEY (order_id) REFERENCES orders(id),
                FOREIGN KEY (product_id) REFERENCES products(id)
            );

            CREATE TABLE IF NOT EXISTS product_reviews (
                id INT PRIMARY KEY AUTO_INCREMENT,
                customer_id INT NOT NULL,
                product_id INT NOT NULL,
                rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
                review TEXT,
                review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (customer_id) REFERENCES customers(id),
                FOREIGN KEY (product_id) REFERENCES products(id)
            );

            CREATE TABLE IF NOT EXISTS faq (
                id INT PRIMARY KEY AUTO_INCREMENT,
                question VARCHAR(255) NOT NULL,
                answer VARCHAR(255) NOT NULL
            );

        ";

        $this->connection->exec($sql);
    }

    private function initAdminAccount() {
        $email = 'admin@beauty-skin.com';
        $password = password_hash('123456', PASSWORD_BCRYPT);
        $role = 'admin';


        $stmt = $this->connection->prepare("SELECT * FROM accounts WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $account = new Account($this->connection);

        if (!$account->findByEmail($email)) {
            $result = $account->create($email, $password, $role);
                
            if ($result) {
                $accountId = $account->findByEmail($email)["id"];

                // insert into customers table
                $admin = new Admin($this->connection);
                $admin->create("Admin", $accountId);
            }
        }
    }
}
