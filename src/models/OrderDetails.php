<?php

class OrderDetails {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function save($orderId, $productId, $quantity) {
        $stmt = $this->db->prepare("
            INSERT INTO order_details (order_id, product_id, quantity)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$orderId, $productId, $quantity]);
    }

    public function findByOrderId($orderId) {
        $query = "
            SELECT p.*, od.*
            FROM order_details od
            JOIN products p ON od.product_id = p.id
            WHERE od.order_id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}