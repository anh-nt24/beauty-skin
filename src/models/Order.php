<?php

class Order {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function save($customerId, $shippingId, $shippingAddress, $totalAmount, $orderStatus) {
        $stmt = $this->db->prepare("
            INSERT INTO orders (customer_id, shipping_id, order_date, shipping_address, total_amount, order_status)
            VALUES (?, ?, NOW(), ?, ?, ?)
        ");
        $stmt->execute([$customerId, $shippingId, $shippingAddress, $totalAmount, $orderStatus]);
        
        return $this->db->lastInsertId();
    }

    public function findByStatus($state = 'all') {
        $query = "SELECT * FROM orders";
        
        if ($state !== 'all') {
            $query .= " WHERE order_status = ?";
        }
        
        $query .= " ORDER BY id DESC";
        $stmt = $this->db->prepare($query);

        if ($state === 'all') {
            $stmt->execute();
        } else {
            $stmt->execute([strtoupper($state)]);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByCustomerIdAndStatus($customerId, $state) {
        $query = "SELECT * FROM orders WHERE";


        
        if ($state !== 'all' && $state !== strtolower(STATE_5)) {
            $query .= " order_status = ? AND";
        } elseif ($state === strtolower(STATE_5)) {
            $query .= " order_status IN (?, ?, ?) AND";
        }
        
        $query .= " customer_id = ? ORDER BY id DESC";
        $stmt = $this->db->prepare($query);


        if ($state === 'all') {
            $stmt->execute([$customerId]);
        } elseif ($state === strtolower(STATE_5)) {
            $stmt->execute([STATE_5, STATE_5_0, STATE_5_1, $customerId]);
        } else {
            $stmt->execute([strtoupper($state), $customerId]);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($orderId, $status, $note = null) {
        if (in_array($status, [STATE_0, STATE_4, STATE_5]) && $note) {
            $stmt = $this->db->prepare("
                UPDATE orders 
                SET order_status = ?, note = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$status, (string)$note, $orderId]);
        } 
        else {
            $stmt = $this->db->prepare("
                UPDATE orders 
                SET order_status = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$status, $orderId]);
        }
    }

    public function getOrderDetails($orderId) {
        $stmt = $this->db->prepare("
            SELECT product_id, quantity 
            FROM order_details
            WHERE order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}