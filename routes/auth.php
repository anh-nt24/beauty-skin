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

$this->router->get('/password/change-password', function() {
    require_once __DIR__ . '/../src/views/client/layouts/change_password.php';
});

$this->router->post('/password/change-password', function() use($authController) {
    $authController->changePassword();
});

$this->router->get('/password/forgot-password', function() {
    require_once __DIR__ . '/../src/views/client/layouts/forgot_password.php';
});

$this->router->post('/password/forgot-password', function() use($authController) {
    $authController->forgotPassword();
});


$this->router->get('/password/reset-password', function() use ($authController) {
    $authController->showResetPasswordForm();
});

$this->router->post('/password/reset-password', function() use ($authController) {
    $authController->resetPassword();
});