<?php

require_once __DIR__ . "/../src/controllers/ReviewController.php";

$reviewController = new ReviewController($this->db);

$this->router->post('/review-management/add', function() use($reviewController) {
    $reviewController->writeReview();
});