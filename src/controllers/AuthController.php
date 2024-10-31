<?php

require_once __DIR__ . "/../models/Customer.php";
require_once __DIR__ . "/../models/Account.php";
require_once __DIR__ . "/../models/Admin.php";

class AuthController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


            // insert user into the account table
            $account = new Account($this->db);

            if ($account->create($email, $password)) {
                $accountData = $account->findByEmail($email);
                if ($accountData && isset($accountData['id'])) {
                    
                    // insert into customers table
                    $customer = new Customer($this->db);
                    if ($customerId = $customer->create($name, $phone, $address, $accountData['id'])) {
                        echo json_encode([
                            "status" => 200,
                            "message" => "Registration successful",
                            "user" => [
                                "id" => $customerId,
                                "name" => $name,
                                "email" => $email
                            ]
                        ]);
                    } else {
                        echo json_encode([
                            "status" => 409,
                            "message" => "Failed to add the new customer. Your information may be conflicted!"
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => 500,
                        "message" => "Internal server error"
                    ]);   
                }

            } else {
                echo json_encode([
                    "status" => 400,
                    "message" => "Registration failed"
                ]);
            }

            
            
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Invalid request method"
            ]);
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // fetch user from the account table
            $stmt = $this->db->prepare("SELECT * FROM accounts WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            

            if ($user && password_verify($password, $user['password'])) {
                // successful login
                if ($user['role'] === ROLE_CLIENT) {
                    $customer = new Customer($this->db);
                    $customerData = $customer->getCustomerByAccountId($user['id']);
                    echo json_encode([
                        "status" => 200,
                        "message" => "Login successful",
                        "user" => [
                            "id" => $customerData['id'],
                            "name" => $customerData['name'],
                            "email" => $email
                        ]
                    ]);
                } else {
                    $admin = new Admin($this->db);
                    $adminData = $admin->getAdminByAccountId($user['id']);
                    echo json_encode([
                        "status" => 200,
                        "message" => "Login successful",
                        "user" => [
                            "id" => $adminData['id'],
                            "name" => $adminData['name'],
                            "email" => $email
                        ]
                    ]);
                }
                
                
            } else {
                // failed login
                echo json_encode([
                    "status" => 400,
                    "message" => "Invalid email or password"
                ]);
            }
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Invalid request method"
            ]);
        }
    }
}