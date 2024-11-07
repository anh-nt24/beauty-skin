<?php

class Customer {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function save($name, $phone, $address, $accountId) {
        $stmt = $this->db->prepare("INSERT INTO customers (name, phone, address, account_id) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([$name, $phone, $address, $accountId]);
        
        if (!$success) {
            return false;
        } else {
            $customerId = $this->db->lastInsertId();
            return $customerId;
        }
    }   
    
    public function findByAccountId($accountId) {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE account_id = ?");
        $stmt->execute([$accountId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
