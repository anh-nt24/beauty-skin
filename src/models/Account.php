<?php

class Account {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function save($email, $hashedPassword, $role = 'client') {
        $stmt = $this->db->prepare("INSERT INTO accounts (email, password, role) VALUES (?, ?, ?)");
        return $stmt->execute([$email, $hashedPassword, $role]);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM accounts WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}
