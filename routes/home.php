<?php

require_once __DIR__ . "/../src/controllers/HomeController.php";

$homeController = new HomeController($this->db);

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