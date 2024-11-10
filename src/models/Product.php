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
                IFNULL(AVG(r.rating), 0) AS average_rating,
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
        
        $product['average_rating'] = $ratingData['average_rating'] ?? 0;
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

    // search and filter
    public function search(array $params): array {
        $query = "SELECT p.* FROM products p WHERE 1=1 AND p.stock > 0";
        $parameters = [];
        
        // search query
        if (!empty($params['query'])) {
            $query .= " AND (p.product_name LIKE ? OR p.description LIKE ?)";
            $parameters[] = '%' . $params['query'] . '%';
            $parameters[] = '%' . $params['query'] . '%';
        }
        
        // category filter
        if (!empty($params['categories'])) {
            $placeholders = str_repeat('?,', count($params['categories']) - 1) . '?';
            $query .= " AND p.category IN ($placeholders)";
            $parameters = array_merge($parameters, $params['categories']);
        }
        
        // price level filter
        if (!empty($params['priceLevels'])) {
            $priceConditions = [];
            foreach ($params['priceLevels'] as $levelId) {
                $level = PRICE_LEVELS[$levelId];
                if ($level['max'] === null) {
                    $priceConditions[] = "p.price >= " . $level['min'];
                } else {
                    $priceConditions[] = "(p.price >= " . $level['min'] . " AND p.price < " . $level['max'] . ")";
                }
            }
            $query .= " AND (" . implode(" OR ", $priceConditions) . ")";
        }
        
        // sorting
        switch ($params['sort']) {
            case 'price_asc':
                $query .= " ORDER BY p.price ASC";
                break;
            case 'price_desc':
                $query .= " ORDER BY p.price DESC";
                break;
            case 'newest':
            default:
                $query .= " ORDER BY p.id DESC";
                break;
        }

        try {
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($parameters);
            
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("SQL error: " . $errorInfo[2]);
            }
            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as &$product) {
                $images = explode(';', $product['image']);
                $product['image'] = $images;
                $ratingStmt = $this->db->prepare("
                    SELECT AVG(rating) AS average_rating, COUNT(*) AS rating_count
                    FROM product_reviews
                    WHERE product_id = ?
                ");
                $ratingStmt->execute([$product['id']]);
                $ratingData = $ratingStmt->fetch(PDO::FETCH_ASSOC);
                
                $product['average_rating'] = $ratingData['average_rating'] ?? 0;
            }

            return $products;
        } catch (Exception $e) {
            print_r($e->getMessage());
            error_log("Search error: " . $e->getMessage());
            return [];
        }
    }
    
    public function findCategoryCounts(string $searchQuery = ''): array {
        $query = "SELECT p.category, COUNT(*) as count 
                 FROM products p 
                 WHERE 1=1 AND p.stock > 0";
        $parameters = [];
        
        if (!empty($searchQuery)) {
            $query .= " AND (p.product_name LIKE :query OR p.description LIKE :query)";
            $parameters[':query'] = '%' . $searchQuery . '%';
        }
        
        $query .= " GROUP BY p.category";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($parameters);
        
        $counts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $counts[$row['category']] = $row['count'];
        }
        
        return $counts;
    }
    
    public function findPriceLevelCounts(string $searchQuery = ''): array {
        $counts = [];
        foreach (PRICE_LEVELS as $levelId => $level) {
            $query = "SELECT COUNT(*) as count FROM products p WHERE 1=1 AND p.stock > 0";
            $parameters = [];
            
            if (!empty($searchQuery)) {
                $query .= " AND (p.product_name LIKE :query OR p.description LIKE :query)";
                $parameters[':query'] = '%' . $searchQuery . '%';
            }
            
            if ($level['max'] === null) {
                $query .= " AND p.price >= :min";
                $parameters[':min'] = $level['min'];
            } else {
                $query .= " AND p.price >= :min AND p.price < :max";
                $parameters[':min'] = $level['min'];
                $parameters[':max'] = $level['max'];
            }
            
            $stmt = $this->db->prepare($query);
            $stmt->execute($parameters);
            
            $counts[$levelId] = $stmt->fetchColumn();
        }
        
        return $counts;
    }
    
}

?>
