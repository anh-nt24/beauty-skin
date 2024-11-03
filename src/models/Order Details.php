<?php

class OrderDetails {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
}