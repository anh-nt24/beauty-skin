<?php

require_once "./../config/database.php";
require_once "./../config/constants.php";
require_once __DIR__ . "/Router.php";

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