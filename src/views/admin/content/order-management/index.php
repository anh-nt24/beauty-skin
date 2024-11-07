<?php

$currentPath = strtok($_SERVER["REQUEST_URI"], '?');
$totalOrders = count($orderData);
?>

<script>
    document.title = "Order Management";
</script>

<div class="container-fluid px-4">
    <!-- search -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
                <input type="hidden" name="section" value="order-management">
                <input type="hidden" name="subsection" value="index">
                <input type="hidden" name="tab" value="<?php echo htmlspecialchars($currentTab); ?>">
                
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               placeholder="Search by Order ID..." 
                               name="search_id">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary px-4">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- tabs -->
    <ul class="nav nav-tabs nav-fill mb-4" role="tablist">
        <?php
        $tabs = [
            'all' => ['name' => 'All', 'icon' => 'grid'],
            strtolower(STATE_1) => ['name' => 'In Progress', 'icon' => 'clock-history'],
            strtolower(STATE_2) => ['name' => 'Ready', 'icon' => 'box-seam'],
            strtolower(STATE_3) => ['name' => 'Delivering', 'icon' => 'truck'],
            strtolower(STATE_4) => ['name' => 'Completed', 'icon' => 'check-circle'],
            strtolower(STATE_0) => ['name' => 'Cancel', 'icon' => 'calendar2-x'],
        ];

        foreach ($tabs as $tabKey => $tab) {
            $active = $currentTab === $tabKey ? 'active' : '';
            ?>
            <li class="nav-item" role="presentation">
                <a href="?tab=<?php echo $tabKey; ?>" 
                   class="nav-link <?php echo $active; ?> d-flex align-items-center justify-content-center">
                    <i class="bi bi-<?php echo $tab['icon']; ?> me-2"></i>
                    <?php echo $tab['name']; ?>
                </a>
            </li>
        <?php } ?>
    </ul>

    <!-- total -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-light rounded px-3 py-2">
            <span class="text-muted">Total Orders:</span>
            <span class="fw-bold ms-2"><?php echo $totalOrders; ?></span>
        </div>
    </div>

    <!-- table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr class="d-flex">
                            <th class="col-3 px-4">Order ID</th>
                            <th class="col-4 ">Products</th>
                            <th class="col-1 ">Total</th>
                            <th class="col-2 ">State</th>
                            <th id="actOrNote" class="col-2 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderData as $order): ?>
                        <tr class="d-flex">
                            <td class="col-3 px-4">
                                <span class="fw-medium">#<?php echo htmlspecialchars($order['id']); ?></span>
                                <div class="text-muted small">
                                    <?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?>
                                </div>
                            </td>
                            <td class="col-4 ">
                                <div class="d-flex flex-column gap-1">
                                    <?php foreach ($order['products'] as $product): ?>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-light text-dark me-2">
                                                <?php echo $product['quantity']; ?>x
                                            </span>
                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td class="col-1 ">
                                <span class="fw-bold text-danger">$<?php echo $order['total']; ?></span>
                            </td>
                            <td class="col-2 ">
                                <?php
                                    $stateClasses = [
                                        STATE_1 => 'bg-warning',
                                        STATE_2 => 'bg-info',
                                        STATE_3 => 'bg-primary',
                                        STATE_4 => 'bg-success'
                                    ];
                                    $stateClass = $stateClasses[$order['state']] ?? 'bg-secondary';
                                ?>
                                <span class="badge <?php echo $stateClass; ?>">
                                    <?php echo htmlspecialchars($order['state']); ?>
                                </span>
                            </td>
                            <td class="col-2 px-4">
                                <div class="btn-group">
                                    <!-- status: pending -->
                                    <?php if ($order['state'] === STATE_1): ?>
                                        <button onclick="updateReady(<?php echo $order['id']; ?>)" type="button" class="btn btn-light btn-sm" title="Order Ready">
                                            <i class="bi bi-patch-check text-success"></i>
                                        </button>
                                        <button onclick="updateReject(<?php echo $order['id']; ?>)" type="button" class="btn btn-light btn-sm" title="Order Rejected">
                                            <i class="bi bi-patch-minus text-danger"></i>
                                        </button>
                                        <button type="button" class="btn btn-light btn-sm" title="Print Invoice">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                    
                                    <!-- status: ready -->
                                    <?php elseif ($order['state'] === STATE_2): ?>
                                        <button onclick="updateDelivering(<?php echo $order['id']; ?>)" type="button" class="btn btn-light btn-sm" title="Sent for Shipping">
                                            <i class="bi bi-patch-check text-success"></i>
                                        </button>
                                        <button type="button" class="btn btn-light btn-sm" title="Print Invoice">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                    <!-- status: cancel -->
                                    <?php elseif ($order['state'] === STATE_0 || $order['state'] === STATE_4): ?>
                                        <span><?php echo $order['note'];?></span>
                                    <?php endif;?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if (!isset($orderData) || empty($orderData)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                    No orders found
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#actOrNote').textContent = <?php echo ($currentTab === strtolower(STATE_0)) ? "'Reason'" : "'Action'"; ?>;

    function updateReady(id) {
        fetch(`<?php echo ROOT_URL;?>/admin/order-management/accept-order?id=${id}`, {
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

    function updateDelivering(id) {
        fetch(`<?php echo ROOT_URL;?>/admin/order-management/ready-order?id=${id}`, {
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

    function updateReject(id) {
        const reason = prompt("Please enter the reason for rejection:");

        if (reason) {
            fetch(`<?php echo ROOT_URL;?>/admin/order-management/reject-order?id=${id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ reason: '[ADMIN]: ' + reason })
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