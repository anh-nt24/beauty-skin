<?php

require_once __DIR__ . "/../src/controllers/ReviewController.php";

$reviewController = new ReviewController($this->db);

$this->router->post('/review-management/add', function() use($reviewController) {
    $reviewController->writeReview();
});

$this->router->get('/admin/customer-service/rating', function() use($reviewController) {
    $data = [
        'current_section' => 'customer-service',
        'current_subsection' => 'rating'
    ];

    $filters = [
        'product' => $_GET['product'] ?? '',
        'rating' => $_GET['rating'] ?? '',
        'dateRange' => $_GET['dateRange'] ?? ''
    ];

    $viewData = $reviewController->getRatingDashboard($filters);
    require_once __DIR__ . "/../src/views/admin/index.php";
});