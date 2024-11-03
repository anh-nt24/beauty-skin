<?php

require_once __DIR__ . "/../src/controllers/ProductController.php";

$productController = new ProductController($this->db);

$this->router->post('/admin/product-management/add', function() use($productController) {
    $productController->addProduct($_POST, $_FILES);
});

$this->router->get('/admin/product-management/index', function() use($productController) {
    $productData = $productController->getAllProducts();
    $data = [
        'current_section' => 'product-management',
        'current_subsection' => 'index'
    ];
    require_once __DIR__ . "/../src/views/admin/index.php";
});

$this->router->get('/admin/product-management/add', function() use($productController) {
    $data = [
        'current_section' => 'product-management',
        'current_subsection' => 'add'
    ];
    require_once __DIR__ . "/../src/views/admin/index.php";
});

$this->router->get('/newest-products', function() use ($productController) {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $productController->getNewestProducts($page);
});

$this->router->get('/bestseller-products', function() use ($productController) {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $productController->getBestProducts($page);
});

