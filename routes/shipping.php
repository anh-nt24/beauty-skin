<?php

require_once __DIR__ . "/../src/controllers/ShippingServiceController.php";

$shippingServiceController = new ShippingServiceController($this->db);

$this->router->get('/shipping-service', function() use ($shippingServiceController) {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    if ($id == null) {
        exit;
    }
    $shippingServiceController->getShippingServiceById($id);
});


$this->router->post('/admin/shipping-service/add', function() use ($shippingServiceController) {
    $shippingServiceController->addService($_POST);
});

$this->router->post('/admin/shipping-service/edit', function() use ($shippingServiceController) {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    if ($id == null) {
        exit;
    }
    $shippingServiceController->updateService($id, $_POST);
});

$this->router->get('/admin/shipping-service/delete', function() use ($shippingServiceController) {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    if ($id == null) {
        exit;
    }
    $shippingServiceController->deleteService($id);
});
