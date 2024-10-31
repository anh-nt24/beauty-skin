<?php

class Customer {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($name, $phone, $address, $accountId) {
        $stmt = $this->db->prepare("INSERT INTO customers (name, phone, address, account_id) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([$name, $phone, $address, $accountId]);
        
        if (!$success) {
            return false;
        } else {
            $customerId = $this->db->lastInsertId();
            return $customerId;
        }
    }   
    
    public function getCustomerByAccountId($accountId) {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE account_id = ?");
        $stmt->execute([$accountId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
