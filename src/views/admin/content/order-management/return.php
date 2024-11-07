<script>
    document.title = "Return - Refund";
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Return/Refund Requests</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10%">Order ID</th>
                                <th style="width: 20%">Customer</th>
                                <th style="width: 50%">Reason</th>
                                <th style="width: 20%">Get Refund?</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orderData as $order): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['reason']); ?></td>
                                <?php if ($order['state'] == STATE_5):?>
                                    <td>
                                        <button onclick="acceptRefund(<?php echo htmlspecialchars($order['id']); ?>)" class="btn btn-sm btn-success">Approve</button>
                                        <button onclick="rejectRefund(<?php echo htmlspecialchars($order['id']); ?>)" class="btn btn-sm btn-danger">Reject</button>
                                    </td>
                                <?php elseif ($order['state'] == STATE_5_1):?>
                                    <td>
                                        <span class="p-2 badge bg-warning">Approved</span>
                                    </td>
                                <?php else:?>
                                    <td>
                                        <span class="p-2 badge bg-danger">Rejected</span>
                                    </td>
                                <?php endif;?>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (!isset($orderData) || empty($orderData)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                    No requests found
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
</div>

<script>
    function acceptRefund(id) {
        fetch(`<?php echo ROOT_URL;?>/admin/order-management/accept-refund?id=${id}`, {
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

    function rejectRefund(id) {
        fetch(`<?php echo ROOT_URL;?>/admin/order-management/reject-refund?id=${id}`, {
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
</script>