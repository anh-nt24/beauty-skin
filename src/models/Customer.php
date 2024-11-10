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
    
    public function update($name, $phone, $address, $email, $customerId) {
        $stmt = $this->db->prepare(
            "UPDATE customers c 
             INNER JOIN accounts a ON c.account_id = a.id
             SET c.name = ?, c.address = ?, c.phone = ?, a.email = ? 
             WHERE c.id = ?"
        );
        return $stmt->execute([$name, $address, $phone, $email, $customerId]);
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

    public function findAll() {
        // customers data
        $stmt = $this->db->prepare("SELECT c.*, a.id AS account_id, a.email, a.registration_date AS reg_date
                          FROM customers c
                          JOIN accounts a ON c.account_id = a.id");
        $stmt->execute();
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // order_status data
        foreach ($customers as &$customer) {
            $stmt = $this->db->prepare(
                "SELECT COUNT(*) AS total_orders, 
                SUM(CASE WHEN o.order_status = '". STATE_4 . "' THEN 1 ELSE 0 END) AS successful_orders
                FROM orders o WHERE o.customer_id = :customer_id");
            $stmt->bindParam(':customer_id', $customer['id']);
            $stmt->execute();
            $orderStats = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $customer['total_orders'] = $orderStats['total_orders'];
            $customer['success_rate'] = $orderStats['total_orders'] > 0 ? round(($orderStats['successful_orders'] / $orderStats['total_orders']) * 100, 2) : 0;
        }

        return $customers;
    }

    public function getCustomerStats() {   
        $stats = [
            'totalCustomers' => $this->getTotalCustomers(),
            'averageOrderValue' => $this->getAverageOrderValue(),
            'customerGrowth' => $this->getCustomerGrowth(),
            'topCustomers' => $this->getTopCustomers(),
            'customerRetention' => $this->getCustomerRetention()
        ];
        return $stats;
    }

    private function getTotalCustomers() {
        $query = "SELECT COUNT(*) as total FROM customers";
        return $this->db->query($query)->fetch()['total'];
    }

    private function getAverageOrderValue() {
        $query = "SELECT 
                    AVG(total_amount) as avg_order_value 
                 FROM orders 
                 WHERE order_status = '" . STATE_4 . "'";
        return round($this->db->query($query)->fetch()['avg_order_value'], 2);
    }

    private function getCustomerGrowth() {
        // calculate the number of new customers each month over the last 6 months
        $query = "SELECT 
                    DATE_FORMAT(a.registration_date, '%Y-%m') AS month,
                    COUNT(DISTINCT c.account_id) AS new_customers
                  FROM accounts a
                  JOIN customers c ON a.id = c.account_id
                  WHERE a.registration_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                  GROUP BY month
                  ORDER BY month ASC";
        
        return $this->db->query($query)->fetchAll();
    }    

    private function getTopCustomers() {
        // get top 5 customers by total spend
        $query = "SELECT 
                    c.id,
                    c.name,
                    COUNT(o.id) as total_orders,
                    SUM(o.total_amount) as total_spent,
                    MAX(o.order_date) as last_order_date
                 FROM customers c
                 JOIN orders o ON o.customer_id = c.id
                 WHERE o.order_status = 'completed'
                 GROUP BY c.id, c.name
                 ORDER BY total_spent DESC
                 LIMIT 5";
        return $this->db->query($query)->fetchAll();
    }

    private function getCustomerRetention() {
        $query = "SELECT 
                    (COUNT(DISTINCT repeat_customers.customer_id) / COUNT(DISTINCT all_customers.customer_id)) * 100 AS retention_rate
                  FROM orders AS all_customers
                  LEFT JOIN (
                      SELECT customer_id 
                      FROM orders 
                      GROUP BY customer_id 
                      HAVING COUNT(*) > 1
                  ) AS repeat_customers 
                  ON all_customers.customer_id = repeat_customers.customer_id";
        
        return round($this->db->query($query)->fetch()['retention_rate'], 2);
    }
    
    
}
