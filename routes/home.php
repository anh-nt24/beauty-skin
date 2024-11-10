<?php

require_once __DIR__ . "/../src/controllers/HomeController.php";
require_once __DIR__ . "/../src/controllers/CustomerController.php";

$homeController = new HomeController($this->db);
$customerController = new CustomerController($this->db);

function isAdmin() {
    if (!isset($_COOKIE['user'])) {
        return false;
    }
    
    $user = json_decode($_COOKIE['user'], true);
    return isset($user['role']) && $user['role'] === 'admin';
}


$this->router->get('/', function() use ($homeController) {
    if (isAdmin()) {
        header("Location:" . ROOT_URL . "/admin/order-management/index");
        exit;
    }
    $homeController->index();
});

$this->router->get('/admin', function() {
    if (isAdmin()) {
        header("Location:" . ROOT_URL . "/admin/order-management/index");
        exit;
    } else {
        header("Location:/" . ROOT_URL);
        exit;
    }
});

$this->router->post('/update-profile', function () use ($customerController) {
    $customerId = isset($_GET['id']) ? (int)$_GET['id'] : null;
    if (!isset($customerId)) {
        header('Location: ' . ROOT_URL);
        exit;
    }
    $customerController->updateCustomerInfo($customerId);
});


$this->router->get('/admin/report/index', function() use($homeController) {
    $data = [
        'current_section' => 'report',
        'current_subsection' => 'index'
    ];

    $dashboardData = $homeController->adminDashboard();    
    require_once __DIR__ . "/../src/views/admin/index.php";
});

$this->router->get('/admin/report/export', function() use($homeController) {     
    $homeController->exportData();
});