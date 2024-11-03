<?php

$currentPath = strtok($_SERVER["REQUEST_URI"], '?');
$currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
$totalOrders = count($orderData);
?>

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
            'pending' => ['name' => 'In Progress', 'icon' => 'clock-history'],
            'ready' => ['name' => 'Ready', 'icon' => 'box-seam'],
            'delivered' => ['name' => 'Delivered', 'icon' => 'truck'],
            'completed' => ['name' => 'Completed', 'icon' => 'check-circle']
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
                            <th class="col-2 px-4">Action</th>
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
                                            <?php echo htmlspecialchars($product['name']); ?>
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
                                    <button type="button" class="btn btn-light btn-sm" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-light btn-sm" title="Order Ready">
                                        <i class="bi bi-patch-check text-success"></i>
                                    </button>
                                    <button type="button" class="btn btn-light btn-sm" title="Order Rejected">
                                        <i class="bi bi-patch-minus text-danger"></i>
                                    </button>
                                    <button type="button" class="btn btn-light btn-sm" title="Print Invoice">
                                        <i class="bi bi-printer"></i>
                                    </button>
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