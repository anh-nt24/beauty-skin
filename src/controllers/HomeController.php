<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/OrderController.php';

class HomeController {
    private $productModel;
    private $db;

    public function __construct($dbConnection) {
        $this->productModel = new Product($dbConnection);
        $this->db = $dbConnection;
    }

    public function index() {
        $products = $this->productModel->findAll();
        require_once __DIR__ . '/../views/client/homepage/index.php';
    }

    private function getValidSections() {
        $validSections = [];
    
        foreach (ADMIN_PANEL as $section => $data) {
            if (isset($data['subsections'])) {
                $validSections[$section] = array_map(function($subsection) {
                    return $subsection['url'];
                }, $data['subsections']);
            } else {
                $validSections[$section] = ["index"];
            }
        }
    
        return $validSections;
    }

    public function admin($section, $subsection) {
        $validSections = $this->getValidSections();

        $section = strtolower($section);
        $subsection = strtolower($subsection);


        if (!isset($validSections[$section]) || !in_array($subsection, $validSections[$section])) {
            $section = 'order-management';
            $subsection = 'index';
        }

        $data = [
            'current_section' => $section,
            'current_subsection' => $subsection
        ];

        switch ($section) {
            case 'order-management':
                $tab = isset($_GET['tab']) ? $_GET['tab'] : null;
                $orderController = new OrderController($this->db);
                $orderController->getAllOrders($tab);
                break;
            case 'product-management':
                # code...
                break;   
            case 'customer-management':
                # code...
                break;    
            case 'customer-service':
                # code...
                break;     
            case 'report':
                # code...
                break;

        }

        $orderData = [
            [
                'id' => 'ORD-001',
                'products' => [
                    ['name' => 'iPhone 14 Pro', 'quantity' => 1],
                    ['name' => 'AirPods Pro', 'quantity' => 2]
                ],
                'state' => 'Pending',
                'total' => '128.00',
                'created_at' => '2024-01-15 10:30:00'
            ],
            [
                'id' => 'ORD-002',
                'products' => [
                    ['name' => 'MacBook Air M2', 'quantity' => 1]
                ],
                'state' => 'Ready',
                'total' => '165.00',
                'created_at' => '2024-01-16 14:20:00'
            ],
            [
                'id' => 'ORD-003',
                'products' => [
                    ['name' => 'iPad Pro 12.9"', 'quantity' => 1],
                    ['name' => 'Apple Pencil', 'quantity' => 1],
                    ['name' => 'Magic Keyboard', 'quantity' => 1]
                ],
                'state' => 'Delivered',
                'total' => '598.00',
                'created_at' => '2024-01-17 09:15:00'
            ]
        ];
        require_once __DIR__ . '/../views/admin/index.php';
    }
}
?>
