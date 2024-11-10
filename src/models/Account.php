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

    public function generatePasswordResetToken($accountId) {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+2 minutes'));

        $stmt = $this->db->prepare("INSERT INTO password_reset_tokens (account_id, token, expires_at) VALUES (:account_id, :token, :expires_at)");
        $stmt->bindParam(':account_id', $accountId);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires_at', $expiresAt);
        $stmt->execute();

        return $token;
    }

    public function findByToken($token) {
        $expiresAt = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("SELECT * FROM password_reset_tokens WHERE token = :token AND expires_at > :current_time");
        $stmt->execute([':token' => $token, ':current_time' => $expiresAt]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($accountId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE accounts SET password = :password WHERE id = :account_id");
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':account_id', $accountId);
        $stmt->execute();
    }

    public function expireToken($id) {
        $expiresAt = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("UPDATE password_reset_tokens SET expires_at = :expires_at WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':expires_at', $expiresAt);
        $stmt->execute();
    }
}
