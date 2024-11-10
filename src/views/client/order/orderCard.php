<div class="card mb-3">
    <div class="card-body">
        <?php foreach ($order['order_details'] as $index => $item): ?>
            <div style="cursor: pointer;" class="row mb-3" onclick="viewProductDetails('<?php echo $item['product_name']?>', <?php echo $item['product_id']?>)">
                <div class="col-md-8 d-flex align-items-center">
                    <img src="../<?= $item['image'] ?>" 
                         alt="<?= $item['product_name'] ?>" 
                         class="me-3" 
                         style="width: 80px; height: 80px; object-fit: cover;">
                    <div>
                        <h6 class="mb-1"><?= $item['product_name'] ?></h6>
                        <p class="mb-0">Quantity: <?= $item['quantity'] ?></p>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <?php if ($index === 0):?>
                    <div class="mb-2">
                        <span class="badge bg-<?= getStateBadgeColor($order['state']) ?>">
                            <?= ucfirst($order['state']) ?>
                        </span>
                    </div>
                    <?php endif;?>

                    <div class="fw-bold">$<?= number_format($item['price'], 2) ?></div>
                    </div>
            </div>
        <?php endforeach; ?>
        
        <hr>
        
        <div class="d-flex justify-content-between align-items-center">
            <div class="fw-bold">Total Amount: $<?= $order['total'] ?></div>
            <div>
                <?php if (in_array($order['state'], [STATE_1, STATE_2])): ?>
                    <button class="btn btn-danger" 
                            onclick="cancelOrder(<?= $order['id'] ?>)">
                        Cancel Order
                    </button>
                <?php elseif ($order['state'] === STATE_3): ?>
                    <button class="btn btn-success" 
                            onclick="confirmReceived(<?= $order['id'] ?>)">
                        Confirm Receipt
                    </button>
                <?php elseif ($order['state'] === STATE_4): ?>
                    <button class="btn btn-warning me-2" 
                            onclick="requestReturn(<?= $order['id'] ?>)">
                        Return/Refund
                    </button>
                    <button class="btn btn-primary" 
                            onclick="showReviewModal(<?= $order['id'] ?>)">
                        Leave Review
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function viewProductDetails(name, id) {
        window.location.href = `<?php echo ROOT_URL;?>/products/view?product=${convertToSlug(name)}&id=${id}`
    }

    function convertToSlug(productName) {
        let slug = productName.toLowerCase();
        slug = slug.replace(/\s+/g, '-');
        slug = slug.replace(/[^a-z0-9\-.\#]/g, '');
        return slug;
    }
</script>