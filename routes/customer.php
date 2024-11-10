<?php

require_once __DIR__ . "/../src/controllers/CustomerController.php";
require_once __DIR__ . "/../src/controllers/FaQController.php";

$customerController = new CustomerController($this->db);
$faqController = new FaQController($this->db);

$this->router->get('/admin/customer-management/index', function() use($customerController) {
    $data = [
        'current_section' => 'customer-management',
        'current_subsection' => 'index'
    ];
    $customersData = $customerController->getAllCustomers();
    require_once __DIR__ . "/../src/views/admin/index.php";
});

$this->router->get('/admin/customer-service/index', function() use ($faqController) {
    $data = [
        'current_section' => 'customer-service',
        'current_subsection' => 'index'
    ];

    $faqs = $faqController->getAllFaQs();
    require_once __DIR__ . "/../src/views/admin/index.php";
});

$this->router->post('/admin/customer-service/faq/add', function() use ($faqController) {
    $faqController->addNewFaQ();
});

$this->router->post('/admin/customer-service/faq/edit', function() use ($faqController) {
    $faqController->editFaQ();
});

$this->router->post('/admin/customer-service/faq/delete', function() use ($faqController) {
    $faqController->deleteFaQ();
});