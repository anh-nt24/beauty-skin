<?php

class Review {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function save($customerId, $productId, $orderId, $rating, $review) {
        $stmt = $this->db->prepare("INSERT INTO product_reviews (customer_id, product_id, order_id, rating, review, review_date) VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$customerId, $productId, $orderId, $rating, $review]);
    }

    public function getStatistics() {
        // total reviews
        $totalReviews = $this->db->query("SELECT COUNT(*) FROM product_reviews")->fetchColumn();
        
        // average rating
        $avgRating = $this->db->query("SELECT ROUND(AVG(rating), 1) FROM product_reviews")->fetchColumn();
        
        // recent reviews (7 days)
        $recentReviews = $this->db->query("
            SELECT COUNT(*) 
            FROM product_reviews 
            WHERE review_date >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
        ")->fetchColumn();
        
        // total products reviewed
        $totalProducts = $this->db->query("
            SELECT COUNT(DISTINCT product_id) 
            FROM product_reviews
        ")->fetchColumn();

        return [
            'totalReviews' => $totalReviews,
            'averageRating' => $avgRating,
            'recentReviews' => $recentReviews,
            'totalProducts' => $totalProducts
        ];
    }

    public function getReviews($filters) {
        $params = [];
        $whereConditions = ["1 = 1"];

        $sql = "
            SELECT 
                pr.*,
                c.name as customer_name,
                p.product_name as product_name,
                o.order_number
            FROM product_reviews pr
            JOIN customers c ON pr.customer_id = c.id
            JOIN products p ON pr.product_id = p.id
            JOIN orders o ON pr.order_id = o.id
        ";

        // product name filter
        if (!empty($filters['product'])) {
            $whereConditions[] = "p.product_name LIKE :product";
            $params['product'] = "%" . $filters['product'] . "%";
        }

        // rating filter
        if (!empty($filters['rating'])) {
            $whereConditions[] = "pr.rating = :rating";
            $params['rating'] = $filters['rating'];
        }

        // date range filter
        if (!empty($filters['dateRange']) && $filters['dateRange'] !== 'all') {
            $whereConditions[] = "pr.review_date >= DATE_SUB(CURRENT_DATE, INTERVAL :days DAY)";
            $params['days'] = $filters['dateRange'];
        }

        if (!empty($whereConditions)) {
            $sql .= " WHERE " . implode(" AND ", $whereConditions);
        }

        $sql .= " ORDER BY pr.review_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByProductId($productId) {
        $stmt = $this->db->prepare("
            SELECT pr.*, c.name as customer_name, p.product_name as product_name 
            FROM product_reviews pr 
            INNER JOIN products p ON pr.product_id = p.id
            INNER JOIN customers c ON pr.customer_id = c.id
            WHERE pr.product_id = ? 
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
