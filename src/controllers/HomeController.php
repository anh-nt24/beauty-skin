<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/OrderController.php';

class HomeController {
    private $productModel;

    public function __construct($dbConnection) {
        $this->productModel = new Product($dbConnection);
    }

    public function index() {
        $products = $this->productModel->findAll();
        require_once __DIR__ . '/../views/client/homepage/index.php';
    }
}
?>
