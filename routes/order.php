<?php

require_once __DIR__ . "/../src/controllers/OrderController.php";

$orderController = new OrderController($this->db);

$this->router->get('/admin/order-management/index', function() use($orderController) {
    $tab = isset($_GET['tab']) ? $_GET['tab'] : null;
    $orderController->getAllOrders($tab);
});