<?php

require_once "./../config/database.php";

class Application {
    private $routes = [];
    private $db;

    public function __construct() {
        // create a database connection
        $this->db = Database::getInstance()->getConnection();

        // get routes
        $this->routes = require_once __DIR__ . "./../config/routes.php";
    }

    public function run() {
        $requestUri = $_SERVER['REQUEST_URI'];
        $controllerAction = $this->routes[$requestUri] ?? null;

        if ($controllerAction) {
            list($controller, $method) = explode('@', $controllerAction);
            $controllerPath = __DIR__ . '/controllers/' . $controller . '.php';

            if (file_exists($controllerPath)) {
                require_once $controllerPath;
                $controllerInstance = new $controller($this->db); // Pass db to controller
                echo $controllerInstance->$method();
            } else {
                http_response_code(404);
                echo "Page not found.";
            }
        } else {
            http_response_code(404);
            echo "Page not found.";
        }
    }
}
