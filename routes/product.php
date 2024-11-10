<?php

require_once __DIR__ . "/../src/controllers/ShippingServiceController.php";
require_once __DIR__ . "/../src/controllers/ProductController.php";
require_once __DIR__ . "/../src/controllers/ReviewController.php";

$productController = new ProductController($this->db);
$reviewController = new ReviewController($this->db);
$shippingServiceController = new ShippingServiceController($this->db);

$this->router->post('/admin/product-management/add', function() use($productController) {
    $productController->addProduct($_POST, $_FILES);
});

$this->router->post('/admin/product-management/edit', function() use($productController) {
    $productId = isset($_GET['id']) ? (int)$_GET['id'] : null;
    if ($productId == null) {
        header('Location: ' . ROOT_URL . '/admin/product-management/index');
        exit;
    }
    $productController->editProduct($productId, $_POST, $_FILES);
});

$this->router->post('/admin/product-management/delete', function() use($productController) {
    $productId = isset($_GET['id']) ? (int)$_GET['id'] : null;
    if ($productId == null) {
        header('Location: ' . ROOT_URL . '/admin/product-management/index');
        exit;
    }
    $productController->deleteProduct($productId);
});

$this->router->get('/admin/product-management/add', function() use($productController) {
    $data = [
        'current_section' => 'product-management',
        'current_subsection' => 'add'
    ];
    require_once __DIR__ . "/../src/views/admin/index.php";
});

$this->router->get('/admin/product-management/view', function() use($productController) {
    $productId = isset($_GET['id']) ? (int)$_GET['id'] : null;
    if ($productId == null) {
        header('Location: ' . ROOT_URL . '/admin/product-management/index');
        exit;
    }
    $productData = $productController->getProductDetails($productId);

    $data = [
        'current_section' => 'product-management',
        'current_subsection' => 'view'
    ];
    require_once __DIR__ . "/../src/views/admin/index.php";
});

$this->router->get('/admin/product-management/index', function() use($productController) {
    $productData = $productController->getAllProducts();
    $data = [
        'current_section' => 'product-management',
        'current_subsection' => 'index'
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

$this->router->get('/products/view', function() use($productController, 
                                                    $shippingServiceController,
                                                    $reviewController) {
    $productId = isset($_GET['id']) ? (int)$_GET['id'] : null;
    if ($productId == null) {
        header('Location: ' . ROOT_URL);
        exit;
    }

    $productData = $productController->getProductDetails($productId);
    $reviewData = $reviewController->getReviewsByProductId($productId);
    $shippingServices = $shippingServiceController->getAllShippingServices();
    require_once __DIR__ . "/../src/views/client/product_details/index.php";
});

$this->router->get('/search', function() use($productController) {
    $searchQuery = $_GET['query'] ?? '';
    $selectedCategories = isset($_GET['category']) ? $_GET['category'] : [];
    $selectedPriceLevels = isset($_GET['priceLevel']) ? array_map('intval', $_GET['priceLevel']) : [];
    $sort = $_GET['sort'] ?? 'newest';

    $searchingResult = $productController->search([
        'query' => $searchQuery,
        'categories' => $selectedCategories,
        'priceLevels' => $selectedPriceLevels,
        'sort' => $sort
    ]);
    
    require_once __DIR__ . "/../src/views/client/search/index.php";
});