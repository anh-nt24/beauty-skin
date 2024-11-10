<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo $order_info['order_number']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .invoice-title {
            font-size: 20px;
            color: #7f8c8d;
            margin-bottom: 20px;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-section div {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f5f6fa;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-amount {
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">BeautySkin</div>
        <div class="invoice-title">INVOICE</div>
    </div>

    <div class="info-section">
        <div><strong>Invoice #:</strong> <?php echo $order_info['order_number']; ?></div>
        <div><strong>Date:</strong> <?php echo date('F d, Y', strtotime($order_info['order_date'])); ?></div>
        <div><strong>Customer:</strong> <?php echo $customer_info['name']; ?></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo $item['product_name']; ?></td>
                <td>$<?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-amount">
            Total Amount: $<?php echo number_format($order_info['total_amount'], 2); ?>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for shopping with BeautySkin!</p>
        <p>For any questions, please contact our customer service.</p>
    </div>
</body>
</html>