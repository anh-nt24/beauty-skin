<?php

class Router {
    private $routes = [];

    public function __construct() {
    }

    private function isAdmin() {
        if (!isset($_COOKIE['user'])) {
            return false;
        }
        
        $user = json_decode($_COOKIE['user'], true);
        return isset($user['role']) && $user['role'] === 'admin';
    }

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }
    

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function put($path, $callback) {
        $this->routes['PUT'][$path] = $callback;
    }

    public function delete($path, $callback) {
        $this->routes['DELETE'][$path] = $callback;
    }

    public function resolve() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = str_replace(ROOT_URL, "", $_SERVER['REQUEST_URI']);
        $requestUri = parse_url($requestUri, PHP_URL_PATH);
        
        if (isset($this->routes[$requestMethod][$requestUri])) {
            if (str_starts_with($requestUri, '/admin')) {
                if ($this->isAdmin()) {
                    return call_user_func($this->routes[$requestMethod][$requestUri]);
                } else {
                    header("Location: " . ROOT_URL);
                    exit;
                }
            } else {
                return call_user_func($this->routes[$requestMethod][$requestUri]);
            }
        }
    }
}