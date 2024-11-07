<?php

require_once __DIR__ . "/../src/controllers/OrderController.php";
require_once __DIR__ . "/../src/controllers/ShippingServiceController.php";

$orderController = new OrderController($this->db);
$shippingServiceController = new ShippingServiceController($this->db);

$this->router->get('/admin/order-management/index', function() use($orderController) {
    $currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
    $orderData = $orderController->getAllOrders($currentTab);
    $data = [
        'current_section' => 'order-management',
        'current_subsection' => 'index'
    ];
    require_once __DIR__ . "/../src/views/admin/index.php";
});

$this->router->post('/admin/order-management/accept-order', function() use($orderController) {
    $orderController->acceptOrder();
});

$this->router->post('/admin/order-management/ready-order', function() use($orderController) {
    $orderController->readyOrder();
});

$this->router->post('/admin/order-management/reject-order', function() use($orderController) {
    $orderController->rejectOrder();
});

$this->router->post('/admin/order-management/accept-refund', function() use($orderController) {
    $orderController->acceptRefund();
});

$this->router->post('/admin/order-management/reject-refund', function() use($orderController) {
    $orderController->rejectRefund();
});

$this->router->post('/order-management/cancel-order', function() use($orderController) {
    $orderController->rejectOrder();
});

$this->router->post('/order-management/request-return', function() use($orderController) {
    $orderController->requestReturn();
});


$this->router->post('/order-management/received-order', function() use($orderController) {
    $orderController->receivedOrder();
});

$this->router->get('/admin/order-management/shipping', function() use($shippingServiceController) {
    $data = [
        'current_section' => 'order-management',
        'current_subsection' => 'shipping'
    ];
    $shippingServices = $shippingServiceController->getAllShippingServices();
    require_once __DIR__ . "/../src/views/admin/index.php";
});

$this->router->get('/admin/order-management/return', function() use($orderController) {
    $data = [
        'current_section' => 'order-management',
        'current_subsection' => 'return'
    ];
    $orderData = $orderController->getReturnOrder();
    require_once __DIR__ . "/../src/views/admin/index.php";
});

$this->router->post('/order-management/add', function() use ($orderController) {
    $orderController->addOrder();
});

$this->router->get('/orders/history', function() use($orderController) {
    $userId = isset($_COOKIE['user']) ? json_decode($_COOKIE['user'], true)['id'] : null;
    if ($userId == null) {
        header('Location: ' . ROOT_URL);
        exit;
    }
    $currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
    $orderData = $orderController->getAllOrdersByCustomerId($userId, $currentTab);
    require_once __DIR__ . "/../src/views/client/order/index.php";
});