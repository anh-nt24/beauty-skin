<?php

require_once __DIR__ . "/../src/controllers/HomeController.php";

$homeController = new HomeController($this->db);

$this->router->get('/', function() use ($homeController) {
    $homeController->index();
});