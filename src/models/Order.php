<?php

class Order {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    private function generateOrderNumber() {
        $letters = strtoupper(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3));
        $numbers = substr(str_shuffle("0123456789"), 0, 3);
        $orderNumber = str_shuffle($letters . $numbers);
        return $orderNumber;
    }

    public function save($customerId, $shippingId, $shippingAddress, $totalAmount, $orderStatus) {
        $orderNumber = $this->generateOrderNumber();
        $stmt = $this->db->prepare("
            INSERT INTO orders (customer_id, shipping_id, order_number, order_date, shipping_address, total_amount, order_status)
            VALUES (?, ?, ?, NOW(), ?, ?, ?)
        ");
        $stmt->execute([$customerId, $shippingId, $orderNumber, $shippingAddress, $totalAmount, $orderStatus]);
        
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

    public function getTotalRevenue() {
        $query = "SELECT SUM(total_amount) as total FROM orders WHERE order_status = '" . STATE_4 . "'";
        return $this->db->query($query)->fetch()['total'];
    }

    public function getMonthlyRevenue() {
        $query = "SELECT 
                    DATE_FORMAT(order_date, '%Y-%m') as month,
                    SUM(total_amount) as revenue
                 FROM orders 
                 WHERE order_status = 'completed'
                 GROUP BY DATE_FORMAT(order_date, '%Y-%m')
                 ORDER BY month DESC
                 LIMIT 12";
        return $this->db->query($query)->fetchAll();
    }

    public function getTopSellingProducts() {
        $query = "SELECT 
                    p.product_name,
                    SUM(od.quantity) as total_quantity,
                    SUM(od.quantity * p.price) as total_revenue
                 FROM order_details od
                 JOIN products p ON p.id = od.product_id
                 JOIN orders o ON o.id = od.order_id
                 WHERE o.order_status = '" . STATE_4 . "'
                 GROUP BY p.id
                 ORDER BY total_revenue DESC
                 LIMIT 5";
        return $this->db->query($query)->fetchAll();
    }

    public function getOrderStatusStats() {
        $query = "SELECT 
                    order_status,
                    COUNT(*) as count
                 FROM orders
                 GROUP BY order_status";
        return $this->db->query($query)->fetchAll();
    }

    public function getAllOrdersForExport() {
        $query = "SELECT 
                    o.id, c.name, o.order_number, 
                    o.order_date, o.total_amount, o.order_status
                 FROM orders o
                 JOIN customers c ON c.id = o.customer_id
                 ORDER BY o.order_date DESC";
        return $this->db->query($query)->fetchAll();
    }

    public function getInvoiceData($orderId) {
        $sql = "SELECT o.id, o.order_number, o.order_date, o.total_amount, o.order_status,
                       c.name as customer_name,
                       od.quantity,
                       p.product_name, p.price
                FROM orders o
                JOIN customers c ON o.customer_id = c.id
                JOIN order_details od ON o.id = od.order_id
                JOIN products p ON od.product_id = p.id
                WHERE o.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($orderDetails)) {
            return null;
        }

        // group the data
        $invoice = [
            'order_info' => [
                'order_number' => $orderDetails[0]['order_number'],
                'order_date' => $orderDetails[0]['order_date'],
                'total_amount' => $orderDetails[0]['total_amount'],
                'order_status' => $orderDetails[0]['order_status']
            ],
            'customer_info' => [
                'name' => $orderDetails[0]['customer_name']
            ],
            'items' => array_map(function($detail) {
                return [
                    'product_name' => $detail['product_name'],
                    'price' => $detail['price'],
                    'quantity' => $detail['quantity'],
                    'subtotal' => $detail['price'] * $detail['quantity']
                ];
            }, $orderDetails)
        ];

        return $invoice;
    }
    
}