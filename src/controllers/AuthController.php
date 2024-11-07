<?php

require_once __DIR__ . "/../models/Customer.php";
require_once __DIR__ . "/../models/Account.php";
require_once __DIR__ . "/../models/Admin.php";

class AuthController {
    private $account;
    private $customer;
    private $admin;

    public function __construct($db) {
        $this->account = new Account($db);
        $this->customer = new Customer($db);
        $this->admin = new Admin($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


            // insert user into the account table
            

            if ($this->account->save($email, $password)) {
                $accountData = $this->account->findByEmail($email);
                if ($accountData && isset($accountData['id'])) {
                    
                    // insert into customers table
                    if ($customerId = $this->customer->save($name, $phone, $address, $accountData['id'])) {
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
            $user = $this->account->findByEmail($email);           

            if ($user && password_verify($password, $user['password'])) {
                // successful login
                if ($user['role'] === ROLE_CLIENT) {
                    $customerData = $this->customer->findByAccountId($user['id']);
                    echo json_encode([
                        "status" => 200,
                        "message" => "Login successful",
                        "user" => [
                            "id" => $customerData['id'],
                            "name" => $customerData['name'],
                            "email" => $email,
                            "address" => $customerData['address'],
                            "role" => $user['role']
                        ]
                    ]);
                } else {
                    $adminData = $this->admin->findByAccountId($user['id']);
                    echo json_encode([
                        "status" => 200,
                        "message" => "Login successful",
                        "user" => [
                            "id" => $adminData['id'],
                            "name" => $adminData['name'],
                            "email" => $email,
                            "role" => $user['role']
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

    public function logout() {
        if (isset($_COOKIE['user'])) {
            setcookie('user', '', time() - 3600, '/');
        }
    
        if (isset($_COOKIE['cart'])) {
            setcookie('cart', '', time() - 3600, '/');
        }
    
        session_start();
        session_unset();
        session_destroy();
    
        header('Location: ' . ROOT_URL);
        exit();
    }
}