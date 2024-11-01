<?php

require_once __DIR__ . "/../src/controllers/HomeController.php";

$homeController = new HomeController($this->db);

function isAdmin() {
    if (!isset($_COOKIE['user'])) {
        return false;
    }
    
    $user = json_decode($_COOKIE['user'], true);
    return isset($user['role']) && $user['role'] === 'admin';
}


$this->router->get('/', function() use ($homeController) {
    if (isAdmin()) {
        header("Location:" . ROOT_URL . "/admin/order-management/index");
        exit;
    } else {
        $homeController->index();
    }
});

$this->router->get('/admin', function() {
    if (isAdmin()) {
        header("Location:" . ROOT_URL . "/admin/order-management/index");
        exit;
    } else {
        header("Location:/" . ROOT_URL);
        exit;
    }
});

function getDefaultSubsections() {
    $defaultSubsections = [];

    foreach (ADMIN_PANEL as $section => $data) {
        if (isset($data['subsections']) && !empty($data['subsections'])) {
            $defaultSubsections[$section] = $data['subsections'][0]['url'];
        }
    }

    return $defaultSubsections;
}


$this->router->get('@/^\/admin\/([^\/]+)(?:\/([^\/]+))?$/', function($section = null, $subsection = null) use ($homeController) {
    if (isAdmin()) {
        $default_subsections = getDefaultSubsections();

        if ($section === null) {
            $section = 'order-management';
        }

        if ($subsection === null) {
            $subsection = $default_subsections[$section] ?? 'index';
            header("Location: " . ROOT_URL . "/admin/{$section}/{$subsection}");
            exit;
        }

        $homeController->admin($section, $subsection);
    } else {
        header("Location:/" . ROOT_URL);
        exit;
    }
});
