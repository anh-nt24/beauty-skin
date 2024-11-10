<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/FaQ.php';
require_once __DIR__ . '/../models/Customer.php';

class HomeController {
    private $productModel;
    private $orderModel;
    private $customerModel;
    private $faqModel;

    public function __construct($dbConnection) {
        $this->productModel = new Product($dbConnection);
        $this->orderModel = new Order($dbConnection);
        $this->customerModel = new Customer($dbConnection);
        $this->faqModel = new FaQ($dbConnection);
    }

    public function index() {
        $products = $this->productModel->findAll();
        $faqData = $this->faqModel->findAll();
        require_once __DIR__ . '/../views/client/homepage/index.php';
    }

    public function adminDashboard() {
        $totalRevenue = $this->orderModel->getTotalRevenue();
        $monthlyRevenue = $this->orderModel->getMonthlyRevenue();
        $topProducts = $this->orderModel->getTopSellingProducts();
        $customerStats = $this->customerModel->getCustomerStats();
        $orderStatusStats = $this->orderModel->getOrderStatusStats();
        
        return [
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'topProducts' => $topProducts,
            'customerStats' => $customerStats,
            'orderStatusStats' => $orderStatusStats
        ];
    }

    public function exportData() {
        $data = $this->orderModel->getAllOrdersForExport();
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Sales Report.csv"');
        
        $output = fopen('php://output', 'w');
        
        fputcsv($output, ['Order ID', 'Customer', 'Order Number', 'Date', 'Amount', 'Status']);
        
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit();
    }
}
?>
