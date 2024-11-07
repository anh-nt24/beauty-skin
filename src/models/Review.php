<?php

class Review {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function save($customerId, $productId, $rating, $review) {
        $stmt = $this->db->prepare("INSERT INTO product_reviews (customer_id, product_id, rating, review, review_date) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$customerId, $productId, $rating, $review]);
    }
}
