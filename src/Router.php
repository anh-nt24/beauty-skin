<?php

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
        
        // check no regex
        if (isset($this->routes[$requestMethod][$requestUri])) {
            return call_user_func($this->routes[$requestMethod][$requestUri]);
        }

        // regex
        foreach ($this->routes[$requestMethod] as $route => $callback) {
            if ($route[0] === '@') {
                $pattern = substr($route, 1);
    
                if (preg_match($pattern, $requestUri, $matches)) {
                    array_shift($matches);
    
                    return call_user_func_array($callback, $matches);
                }
            }
        }
    }
}