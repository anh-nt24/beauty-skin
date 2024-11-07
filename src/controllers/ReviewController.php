<?php

require_once __DIR__ . "/../models/Review.php";

class ReviewController {
    private $reviewModel;

    public function __construct($db) {
        $this->reviewModel = new Review($db);
    }

    public function writeReview() {
        $data = json_decode(file_get_contents("php://input"), true);
        $customerId = isset($_COOKIE['user']) ? json_decode($_COOKIE['user'], true)['id'] : null;

        if ($customerId && $data) {
            $success = true;
            foreach ($data as $reviewData) {
                $productId = $reviewData['productId'];
                $rating = $reviewData['data']['rate'];
                $review = $reviewData['data']['comment'];
    
                if (!$this->reviewModel->save($customerId, $productId, $rating, $review)) {
                    $success = false;
                    break;
                }
            }
    
            if ($success) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            }
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Failed to save review']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid data or customer ID']);
        }
    }
}