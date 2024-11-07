<?php

require_once __DIR__ . "/../src/controllers/ProductController.php";
require_once __DIR__ . "/../src/controllers/ShippingServiceController.php";

$productController = new ProductController($this->db);
$shippingServiceController = new ShippingServiceController($this->db);

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

$this->router->get('/products/newest', function() use ($productController) {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $productController->getNewestProducts($page);
});

$this->router->get('/products/bestseller', function() use ($productController) {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $productController->getBestProducts($page);
});

$this->router->get('/products/view', function() use($productController, $shippingServiceController) {
    $productId = isset($_GET['id']) ? (int)$_GET['id'] : null;
    if ($productId == null) {
        header('Location: ' . ROOT_URL);
        exit;
    }

    $productData = $productController->getProductDetails($productId);
    $shippingServices = $shippingServiceController->getAllShippingServices();
    require_once __DIR__ . "/../src/views/client/product_details/index.php";
});