<?php

class Product {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function findAll() {
        $stmt = $this->db->prepare("
            SELECT * FROM products ORDER BY 
                CASE WHEN stock = 0 THEN 1 ELSE 0 END, 
                id DESC
        ");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);        

        foreach ($products as &$product) {
            $purchasesStmt = $this->db->prepare("
                SELECT SUM(quantity) AS purchases
                FROM order_details
                WHERE product_id = ?
            ");
            
            $purchasesStmt->execute([$product['id']]);
            
            $purchasesData = $purchasesStmt->fetch(PDO::FETCH_ASSOC);
            $product['purchases'] = $purchasesData['purchases'] ?? 0;
        }
        return $products;
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

    public function update($data) {
        $sql = "UPDATE products SET product_name = ?, description = ?, price = ?, category = ?, stock = ?, image = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['product_name'], 
            $data['description'], 
            $data['price'], 
            $data['category'], 
            $data['stock'], 
            $data['image'],
            $data['id']
        ]);
    }

    public function delete($id) {
        $sql = "UPDATE products SET stock = 0 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function findNewest($limit, $offset) {
        $stmt = $this->db->prepare("
            SELECT 
                p.id, p.product_name, p.description, p.price, p.category, p.stock, p.image,
                IFNULL(AVG(r.rating), 0) AS average_rating
            FROM products p
            LEFT JOIN product_reviews r ON p.id = r.product_id
            WHERE p.stock > 0
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
                IFNULL(AVG(r.rating), 5) AS average_rating,
                SUM(od.quantity) AS total_quantity_sold
            FROM products p
            LEFT JOIN order_details od ON p.id = od.product_id
            LEFT JOIN product_reviews r ON p.id = r.product_id
            WHERE p.stock > 0
            GROUP BY p.id
            ORDER BY total_quantity_sold DESC
            LIMIT :limit OFFSET :offset
        ");
    
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findProductDetailsById($productId) {
        // query product
        $stmt = $this->db->prepare("
            SELECT *
            FROM products
            WHERE id = ?
        ");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$product) {
            return null;
        }
        $product['image'] = explode(';', $product['image']);
    
        // query rating
        $ratingStmt = $this->db->prepare("
            SELECT AVG(rating) AS average_rating, COUNT(*) AS rating_count
            FROM product_reviews
            WHERE product_id = ?
        ");
        $ratingStmt->execute([$productId]);
        $ratingData = $ratingStmt->fetch(PDO::FETCH_ASSOC);
        
        $product['average_rating'] = $ratingData['average_rating'] ?? 5;
        $product['rating_count'] = $ratingData['rating_count'] ?? 0;
    
        // query purchases
        $purchasesStmt = $this->db->prepare("
            SELECT SUM(quantity) AS purchases
            FROM order_details
            WHERE product_id = ?
        ");
        $purchasesStmt->execute([$productId]);
        $purchasesData = $purchasesStmt->fetch(PDO::FETCH_ASSOC);
    
        $product['purchases'] = $purchasesData['purchases'] ?? 0;
    
        return $product;
    }
    
    public function decreaseStock($productId, $quantity) {
        $stmt = $this->db->prepare("
            UPDATE products
            SET stock = stock - ?
            WHERE id = ? AND stock >= ?
        ");
        return $stmt->execute([$quantity, $productId, $quantity]);
    }

    public function increaseStock($productId, $quantity) {
        $stmt = $this->db->prepare("
            UPDATE products
            SET stock = stock + ?
            WHERE id = ?
        ");
        return $stmt->execute([$quantity, $productId]);
    }
    
}

?>
