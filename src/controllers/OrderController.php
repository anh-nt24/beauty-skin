<?php

require_once __DIR__ . "/../../vendor/autoload.php";

require_once __DIR__ . "/../models/Order.php";
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/Customer.php";
require_once __DIR__ . "/../models/OrderDetails.php";

use Dompdf\Dompdf;

class OrderController {
    private $orderModel;
    private $productModel;
    private $customerModel;
    private $orderDetailsModel;

    public function __construct($database) {
        $this->orderModel = new Order($database);
        $this->productModel = new Product($database);
        $this->customerModel = new Customer($database);
        $this->orderDetailsModel = new OrderDetails($database);
    }

    public function getAllOrders($state) {
        $orders = $this->orderModel->findByStatus($state);
        
        $orderData = [];
        
        foreach ($orders as $order) {
            $products = $this->orderDetailsModel->findByOrderId($order['id']);
            
            $orderData[] = [
                'id' => $order['id'],
                'order_number' => $order['order_number'],
                'products' => $products,
                'state' => $order['order_status'],
                'total' => number_format($order['total_amount'], 2),
                'created_at' => $order['order_date'],
                'note' => $order['note']
            ];
        }

        return $orderData;
    }

    public function getAllOrdersByCustomerId($customerId, $state) {
        $orders = $this->orderModel->findByCustomerIdAndStatus($customerId, $state);
        
        $orderData = [];
        
        foreach ($orders as $order) {
            $products = $this->orderDetailsModel->findByOrderId($order['id']);
            
            foreach ($products as &$product) {
                $images = explode(';', $product['image']);
                $product['image'] = $images[0];
            }

            
            $orderData[] = [
                'id' => $order['id'],
                'order_details' => $products,
                'state' => $order['order_status'],
                'total' => number_format($order['total_amount'], 2),
                'created_at' => $order['order_date'],
                'note' => $order['note']
            ];
        }
        
        return $orderData;
    }    

    public function getReturnOrder() {
        // all return
        $orders = $this->orderModel->findByStatus(STATE_5);
        
        $orderData = [];
        foreach ($orders as $order) {
            $orderData[] = [
                'id' => $order['id'],
                'order_number' => $order['order_number'],
                'customer_name' => $this->customerModel->findById($order['customer_id'])['name'],
                'reason' => $order['note'],
                'state' => STATE_5
            ];
        }

        // get refund
        $orders = $this->orderModel->findByStatus(STATE_5_1);
        foreach ($orders as $order) {
            $orderData[] = [
                'id' => $order['id'],
                'order_number' => $order['order_number'],
                'customer_name' => $this->customerModel->findById($order['customer_id'])['name'],
                'reason' => $order['note'],
                'state' => STATE_5_1
            ];
        }

        // not refund
        $orders = $this->orderModel->findByStatus(STATE_5_0);
        foreach ($orders as $order) {
            $orderData[] = [
                'id' => $order['id'],
                'order_number' => $order['order_number'],
                'customer_name' => $this->customerModel->findById($order['customer_id'])['name'],
                'reason' => $order['note'],
                'state' => STATE_5_0
            ];
        }
        return $orderData;
    }

    public function addOrder() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $customerId = $data['customerId'];
        $shippingId = $data['shippingId'];
        $shippingAddress = $data['shippingAddress'];
        $totalAmount = $data['totalAmount'];
        $orderDetails = $data['orderDetails'];
        $orderStatus = STATE_1;

        $orderId = $this->orderModel->save($customerId, $shippingId, $shippingAddress, $totalAmount, $orderStatus);
    
        if ($orderId) {
            foreach ($orderDetails as $detail) {
                $productId = $detail['id'];
                $quantity = $detail['quantity'];

                $this->orderDetailsModel->save($orderId, $productId, $quantity);

                $this->productModel->decreaseStock($productId, $quantity);
            }
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function acceptOrder() {
        $orderId = $_GET['id'] ?? null;
        
        if ($orderId) {
            $success = $this->orderModel->updateStatus($orderId, STATE_2);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function acceptRefund() {
        $orderId = $_GET['id'] ?? null;
        
        if ($orderId) {
            $success = $this->orderModel->updateStatus($orderId, STATE_5_1);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function rejectRefund() {
        $orderId = $_GET['id'] ?? null;
        
        if ($orderId) {
            $success = $this->orderModel->updateStatus($orderId, STATE_5_0);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function readyOrder() {
        $orderId = $_GET['id'] ?? null;
        
        if ($orderId) {
            $success = $this->orderModel->updateStatus($orderId, STATE_3);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function rejectOrder() {
        $orderId = $_GET['id'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);
        $reason = $data['reason'] ?? null;

        if ($orderId && $reason) {
            $success = $this->orderModel->updateStatus($orderId, STATE_0, $reason);
            
            if ($success) {
                $orderDetails = $this->orderModel->getOrderDetails($orderId);
                foreach ($orderDetails as $item) {
                    $this->productModel->increaseStock($item['product_id'], $item['quantity']);
                }
            }
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function receivedOrder() {
        $orderId = $_GET['id'] ?? null;

        if ($orderId) {
            $timestamp = date("Y-m-d H:i:s");
            $success = $this->orderModel->updateStatus($orderId, STATE_4, $timestamp);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function requestReturn() {
        $orderId = $_GET['id'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);
        $reason = $data['reason'] ?? null;

        if ($orderId && $reason) {
            $success = $this->orderModel->updateStatus($orderId, STATE_5, $reason);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function generateInvoice($orderId) {
        // get invoice data
        $invoiceData = $this->orderModel->getInvoiceData($orderId);
        
        if (!$invoiceData) {
            header('HTTP/1.0 404 Not Found');
            return 'Order not found';
        }

        $html = $this->generateInvoiceHTML($invoiceData);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Invoice-' . $invoiceData['order_info']['order_number'] . '.pdf"');
        echo $dompdf->output();
    }

    private function generateInvoiceHTML($data) {
        extract($data);
        ob_start();
        
        include dirname(__FILE__) . "/../views/admin/content/order-management/invoiceTemplate.php";
        
        return ob_get_clean();
    }
    
}

