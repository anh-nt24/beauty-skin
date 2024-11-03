<?php

class OrderController {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAllOrders($state = null) {
        if ($state == null) {
            // get all data for all states
        } else {
            // get all data that the order_status == uppercase($state)
        }
    }
}