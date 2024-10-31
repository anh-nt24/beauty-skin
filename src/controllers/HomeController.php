<?php

require_once __DIR__ . '/../models/Product.php';

class HomeController {
    private $productModel;

    public function __construct($dbConnection) {
        $this->productModel = new Product($dbConnection);
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        require_once __DIR__ . '/../views/client/homepage/index.php';
    }
}
?>
