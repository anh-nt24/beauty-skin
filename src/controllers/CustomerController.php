<?php

require_once __DIR__ . "/../models/Customer.php";

class CustomerController {
    private $customer;

    public function __construct($db) {
        $this->customer = new Customer($db);
    }

    public function getAllCustomers() {
        return $this->customer->findAll();
    }

    public function updateCustomerInfo($customerId) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $email = $_POST['email'];

        $success = $this->customer->update($name, $phone, $address, $email, $customerId);

        if ($success) {
            $user = [
                'id' => $customerId,
                'email' => $email,
                'name' => $name,
                'address' => $address,
                'phone' => $phone,
                'role' => ROLE_CLIENT
            ];
            setcookie("user", json_encode($user), time() + 3600 * 24 * 365, "/");
            header('Location: '.ROOT_URL);
            exit;
        } else {
            echo '<script>
                alert("Error updating data. Please try again.");
                window.location.href = window.location.href;
            </script>';
        }

    }
}
?>