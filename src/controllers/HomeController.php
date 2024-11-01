<?php

require_once __DIR__ . '/../models/Product.php';

class HomeController {
    private $productModel;

    public function __construct($dbConnection) {
        $this->productModel = new Product($dbConnection);
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
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

        
        if (!isset($validSections[$section]) || 
            !in_array($subsection, $validSections[$section])) {
            header("Location: " . ROOT_URL . "/admin/order-management/index");
            exit;
        }

        $data = [
            'current_section' => $section,
            'current_subsection' => $subsection
        ];
        require_once __DIR__ . '/../views/admin/index.php';
    }
}
?>
