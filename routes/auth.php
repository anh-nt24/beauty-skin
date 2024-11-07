<?php

require_once __DIR__ . "/../src/controllers/AuthController.php";

$authController = new AuthController($this->db);


$this->router->post('/register', function() use ($authController) {
    $authController->register();
});

$this->router->post('/login', function() use ($authController) {
    $authController->login();
});

$this->router->get('/logout', function() use ($authController) {
    $authController->logout();
});
