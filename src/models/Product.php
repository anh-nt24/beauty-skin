<?php

class Product {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save($data) {
        $sql = "INSERT INTO products (product_name, description, price, category, stock, image)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['product_name'], 
            $data['description'], 
            $data['price'], 
            $data['category'], 
            $data['stock'], 
            $data['image']
        ]);
    }

    public function findNewest($limit, $offset) {
        $stmt = $this->db->prepare("
            SELECT 
                p.id, p.product_name, p.description, p.price, p.category, p.stock, p.image,
                IFNULL(AVG(r.rating), 0) AS average_rating
            FROM products p
            LEFT JOIN product_reviews r ON p.id = r.product_id
            GROUP BY p.id
            ORDER BY p.id DESC
            LIMIT :limit OFFSET :offset
        ");
        
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findBestSeller($limit, $offset) {
        $stmt = $this->db->prepare("
            SELECT 
                p.id, p.product_name, p.description, p.price, p.category, p.stock, p.image,
                IFNULL(AVG(r.rating), 0) AS average_rating,
                SUM(od.quantity) AS total_quantity_sold
            FROM products p
            LEFT JOIN order_details od ON p.id = od.product_id
            LEFT JOIN product_reviews r ON p.id = r.product_id
            GROUP BY p.id
            ORDER BY total_quantity_sold DESC
            LIMIT :limit OFFSET :offset
        ");
    
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>
