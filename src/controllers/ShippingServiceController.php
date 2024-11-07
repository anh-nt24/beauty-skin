<?php

require_once __DIR__ . "/../models/ShippingServices.php";

class ShippingServiceController {
    private $shippingServiceController;

    public function __construct($database) {
        $this->shippingServiceController = new ShippingServices($database);
    }

    public function getAllShippingServices() {
        return $this->shippingServiceController->findAll();
    }

    public function getShippingServiceById($id) {
        header('Content-Type: application/json');
        $shippingService = $this->shippingServiceController->findById($id);
        echo json_encode($shippingService[0]);
    }

    public function addService($postData) {
        if (isset($postData)) {
            $name = $postData['name'];
            $description = $postData['description'];
            $price = $postData['price'];
            $success = $this->shippingServiceController->save($name, $description, $price);
            if ($success) {
                header('Location:' . ROOT_URL . '/admin/order-management/shipping');
                exit;
            } else {
                echo '<script>
                    alert("Error adding data. Please try again.");
                    window.location.href = window.location.href;
                </script>';
            }
        }
    }

    public function updateService($id, $putData) {
        if (isset($putData) && $id) {
            $name = $putData['name'];
            $description = $putData['description'];
            $price = $putData['price'];
            
            $success = $this->shippingServiceController->update($id, $name, $description, $price);
            if ($success) {
                header('Location:' . ROOT_URL . '/admin/order-management/shipping');
                exit;
            } else {
                echo '<script>
                    alert("Error updating data. Please try again.");
                    window.location.href = window.location.href;
                </script>';
            }
        }
    }   

    public function deleteService($id) {
        if ($id) {
            $success = $this->shippingServiceController->delete($id);
            if ($success) {
                header('Location:' . ROOT_URL . '/admin/order-management/shipping');
                exit;
            } else {
                echo '<script>
                    alert("Error deleting data. Please try again.");
                    window.location.href = window.location.href;
                </script>';
            }
        }
    }
      

    
}