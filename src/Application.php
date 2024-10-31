<?php

require_once "./../config/database.php";
require_once "./../config/constants.php";

class Router {
    private $routes = [];

    public function __construct() {
    }

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = str_replace("/beauty-skin", "", $_SERVER['REQUEST_URI']);

        if (isset($this->routes[$requestMethod][$requestUri])) {
            return call_user_func($this->routes[$requestMethod][$requestUri]);
        } else {
            http_response_code(404);
            include __DIR__ . "/views/error/404.php";
            exit;
        }
    }
}

class Application {
    public $db;
    public $router;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->router = new Router();

        require __DIR__ . "/../routes/web.php";
    }

    public function run() {
        $this->router->resolve();
    }
}