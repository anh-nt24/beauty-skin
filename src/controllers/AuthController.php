<?php

require_once __DIR__ . "/../../vendor/autoload.php";

require_once __DIR__ . "/../models/Customer.php";
require_once __DIR__ . "/../models/Account.php";
require_once __DIR__ . "/../models/Admin.php";
require_once __DIR__ . "/../models/MailService.php";

class AuthController {
    private $account;
    private $customer;
    private $admin;
    private $mailService;

    public function __construct($db) {
        $this->account = new Account($db);
        $this->customer = new Customer($db);
        $this->admin = new Admin($db);
        $this->mailService = new MailService();

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
                                "email" => $email,
                                "phone" => $phone,
                                "address" => $address
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
                            "phone" => $customerData['phone'],
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

    public function forgotPassword() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['email'])) {
            $email = $data['email'];
            $customerId = json_decode($_COOKIE['user'], true)['id'];
    
            $account = $this->account->findByEmail($email);
            if ($account) {
                $customer = $this->customer->findByAccountId($account['id']);
                if ($customer['id'] !== $customerId) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Your email is not authenticated. Check it!']);
                    exit;
                }
    
                $resetToken = $this->account->generatePasswordResetToken($account['id']);
                $this->sendPasswordResetEmail($account, $resetToken);
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Password reset instructions have been sent to your email.']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'No user found with the provided email.']);
            }
        }
    }

    protected function sendPasswordResetEmail($account, $resetToken) {
        $email = $account['email'];
        $this->mailService->sendPasswordResetEmail($email, $resetToken);
    }

    public function showResetPasswordForm() {
        $token = $_GET['token'] ?? null;
        if ($token === null) {
            header('Location: ' . ROOT_URL);
            exit;
        }

        $resetToken = $this->account->findByToken($token);
        if ($resetToken) {
            require_once __DIR__ . '/../views/client/layouts/reset_password.php';
        } else {
            echo '<script>
                alert("Your token is invalid or expired. Try again");
                window.location.href = "'. ROOT_URL .'";
            </script>';
        }
    }

    public function resetPassword() {
        $token = $_GET['token'] ?? null;
        if ($token === null) {
            header('Location: ' . ROOT_URL);
            exit;
        }

        $resetToken = $this->account->findByToken($token);
        if ($resetToken) {
            $data = json_decode(file_get_contents("php://input"), true);
            $newPassword = $data['newPassword'];
            $confirmNewPassword = $data['confirmNewPassword'];
    
            if ($newPassword === $confirmNewPassword) {
                $this->account->updatePassword($resetToken['account_id'], $newPassword);
                $this->account->expireToken($resetToken['id']);
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Password reset successfully.']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'New password and confirm password do not match.']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Invalid or expired password reset token.']);
        }
    }

    public function changePassword() {
        $customer = json_decode($_COOKIE['user'], true);
        $account = $this->account->findByEmail($customer['email']);

        $data = json_decode(file_get_contents("php://input"), true);
        $currentPassword = $data['currentPassword'];
        $newPassword = $data['newPassword'];
        $confirmNewPassword = $data['confirmNewPassword'];

        if (password_verify($currentPassword, $account['password'])) {
            if ($newPassword === $confirmNewPassword) {
                $this->account->updatePassword($account['id'], $newPassword);
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Password changed successfully.']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'New password and confirm password do not match.']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Incorrect current password.']);
        }
    }
}