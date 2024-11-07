<?php

class ShippingServices {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function save($name, $description, $price) {
        $stmt = $this->db->prepare("INSERT INTO shipping_services (name, description, price) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $description, $price]);  
    }   
    
    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM shipping_services ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM shipping_services WHERE id = ? ORDER BY id DESC");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $description, $price) {
        $stmt = $this->db->prepare("UPDATE shipping_services SET name = ?, description = ?, price = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $price, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM shipping_services WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    
}
