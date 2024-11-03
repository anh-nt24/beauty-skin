<?php

require_once __DIR__ . "/../src/controllers/AuthController.php";

$authController = new AuthController($this->db);


$this->router->post('/register', function() use ($authController) {
    $authController->register();
});

$this->router->post('/login', function() use ($authController) {
    $authController->login();
});

$this->router->get('/logout', function() {
    if (isset($_COOKIE['user'])) {
        setcookie('user', '', time() - 3600, '/');
    }

    session_start();
    session_unset();
    session_destroy();

    header('Location: ' . ROOT_URL);
    exit();
});
