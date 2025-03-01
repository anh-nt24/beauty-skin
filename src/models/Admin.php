<?php

class Admin {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function save($name, $accountId) {
        $stmt = $this->db->prepare("INSERT INTO admin (name, account_id) VALUES (?, ?)");
        return $stmt->execute([$name, $accountId]);
    }

    public function findByAccountId($accountId) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE account_id = ?");
        $stmt->execute([$accountId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
