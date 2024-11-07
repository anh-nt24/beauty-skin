<?php

$states = [
    'all',
    strtolower(STATE_1),
    strtolower(STATE_2),
    strtolower(STATE_3),
    strtolower(STATE_4),
    strtolower(STATE_5),
    strtolower(STATE_0),
    ];

$currentState = $_GET['tab'] ?? 'all';

function getStateBadgeColor($state) {
    return match($state) {
        STATE_1 => 'warning',
        STATE_2 => 'info',
        STATE_3 => 'primary',
        STATE_4 => 'success',
        STATE_5 => 'danger',
        STATE_0 => 'dark',
        default => 'dark'
    };
}

$orderJSON = json_encode($orderData, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- web icon -->
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL . "/public/images/browser-logo.ico" ?>">
    
    <!-- custom style -->
    <link rel="stylesheet" href= "<?php echo ROOT_URL . "/public/css/style.css" ?>" >
</head>
<body>

    <!-- header -->
    <?php include __DIR__ .  "/../layouts/header.php"; ?>

    <!-- main content -->
    <div class="container my-2">
        <h3 class="mb-4">Order History</h3>
        <ul class="nav nav-tabs mb-4">
            <?php foreach ($states as $state): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $currentState === $state ? 'active' : '' ?>" 
                    href="?tab=<?= $state ?>">
                        <?= ucfirst($state) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="orders-container">
            <?php 
            foreach ($orderData as $order) {
                include __DIR__ . '/orderCard.php';
            }
            ?>
            <?php if (!isset($orderData) || empty($orderData)): ?>
            <div class="d-flex justify-content-center py-4">
                <div class="text-muted">
                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                    No orders found
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- review modal -->
    <?php include __DIR__ . '/reviewModal.php'; ?>

    <!-- footer -->
    <?php include __DIR__ . "/../layouts/footer.php"; ?>

    <script>
        var orderId = null;
        function showReviewModal(id) {
            orderId = id;
            const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
            document.getElementById('orderId').value = id;
            
            const products = document.getElementById('reviewProducts');
            products.innerHTML = '';

            const orders = <?php echo $orderJSON;?>;
            const order = orders.filter((item) => item.id == id)[0];


            
            order.order_details.forEach(item => {
                products.innerHTML += `
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <img src="../${item.image}" class="me-2" width="50px">
                            <h6>${item.product_name}</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="rating">
                                ${[5, 4, 3, 2, 1].map(num => `
                                    <input type="radio" 
                                        name="rating_${item.product_id}" 
                                        ${num == 5 ? 'checked' : ''}
                                        value="${num}" 
                                        id="rating_${item.product_id}_${num}">
                                    <label for="rating_${item.product_id}_${num}">&#9733;</label> <!-- Star symbol -->
                                `).join('')}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comment</label>
                            <textarea class="form-control" 
                                    name="comment_${item.product_id}" 
                                    rows="3"></textarea>
                        </div>
                    </div>
                `;
            });
            
            modal.show();
        }


        function submitReviews() {
            const form = document.getElementById('reviewForm').elements;
            
            const orders = <?php echo $orderJSON;?>;
            const order = orders.filter((item) => item.id == orderId)[0];

            let data = []

            order.order_details.forEach((item, index) => {
                const productId = item.product_id;

                data[index] = {
                    'productId': productId,
                    'data': {
                        'comment': form['comment_' + productId].value,
                        'rate': form['rating_' + productId].value.length === 0 ? 5 : parseInt(form['rating_' + productId].value)
                    }
                }

            });

            fetch('<?php echo ROOT_URL?>/review-management/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.log(error);
            });
        }

        function cancelOrder(id) {
            const reason = prompt("Are you sure you want to cancel this order? Enter the reason: ");

            if (reason) {
                fetch(`<?php echo ROOT_URL;?>/order-management/cancel-order?id=${id}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ reason: '[CUSTOMER]: ' + reason })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert("Error updating order status.");
                    }
                });
            }
        }

        function confirmReceived(id) {
            fetch(`<?php echo ROOT_URL;?>/order-management/received-order?id=${id}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert("Error updating order status.");
                    }
                });
        }

        function requestReturn(id) {
            const reason = prompt("What is the problem with this order?: ");

            if (reason) {
                fetch(`<?php echo ROOT_URL;?>/order-management/request-return?id=${id}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ reason: '[CUSTOMER]: ' + reason })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert("Error updating order status.");
                    }
                });
            }
        }
    </script>

</body>
</html>