<?php

class Order {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
}