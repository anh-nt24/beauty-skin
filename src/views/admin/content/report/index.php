
<script>
    document.title = "Admin Dashboard";
</script>

<style>
    .top-customers-table td:first-child {
        font-weight: 500;
    }

    .top-customers-table .amount {
        font-family: 'Monaco', monospace;
        font-weight: 500;
    }

    .stats-card {
        border-left: 4px solid;
    }

    .stats-card h3 {
        font-size: 1.75rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0.5rem 0;
    }

    .stats-card .trend-indicator {
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .trend-indicator.positive {
        color: #10b981;
    }
</style>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="mb-4">Sales Dashboard</h2>
            <button onclick="exportReport()" class="btn btn-primary mb-4">
                <i class="bi bi-download"></i> Export Report
            </button>
        </div>
    </div>

    <!-- stats cards -->
    <div class="row g-4 mb-4">
        <!-- total revenue -->
        <div class="col-md-3">
            <div class="card stats-card h-100 shadow-sm" style="border-left-color: #0d6efd">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Revenue</h6>
                    <h3 class="card-title">$<?php echo number_format($dashboardData['totalRevenue'], 2); ?></h3>
                </div>
            </div>
        </div>

        <!-- total customers -->
        <div class="col-md-3">
            <div class="card h-100 stats-card shadow-sm" style="border-left-color: #ffc107">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Customers</h6>
                    <h3 class="card-title"><?php echo number_format($dashboardData['customerStats']['totalCustomers']); ?></h3>
                </div>
            </div>
        </div>
        
        <!-- average order value -->
        <div class="col-md-3">
            <div class="card h-100 stats-card shadow-sm" style="border-left-color: #198754">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Avg. Order Value</h6>
                    <h3 class="card-title">$<?php echo number_format($dashboardData['customerStats']['averageOrderValue'], 2); ?></h3>
                </div>
            </div>
        </div>
        
        <!-- customer retention rate -->
        <div class="col-md-3">
            <div class="card h-100 stats-card shadow-sm" style="border-left-color: #dc3545">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Customer Retention</h6>
                    <h3 class="card-title"><?php echo $dashboardData['customerStats']['customerRetention']; ?>%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- charts -->
    <div class="row g-4 mb-4">
        <!-- revenue -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Monthly Revenue</h5>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- order status -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Order Status</h5>
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- top customers table -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Top Customers</h5>
            <div class="table-responsive">
                <table class="table table-hover top-customers-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Total Orders</th>
                            <th>Total Spent</th>
                            <th>Last Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dashboardData['customerStats']['topCustomers'] as $customer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['name']); ?></td>
                            <td><?php echo $customer['total_orders']; ?></td>
                            <td>$<?php echo number_format($customer['total_spent'], 2); ?></td>
                            <td><?php echo date('M d, Y', strtotime($customer['last_order_date'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- customer growth chart -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Customer Growth</h5>
            <canvas id="customerGrowthChart"></canvas>
        </div>
    </div>
</div>

<script>
    // initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        // monthly revenue
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column(($dashboardData['monthlyRevenue']), 'month')); ?>,
                datasets: [{
                    label: 'Monthly Revenue',
                    data: <?php echo json_encode(array_column(($dashboardData['monthlyRevenue']), 'revenue')); ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(216,120,86, 0.5)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2,
            }
        });

        // order status
        const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($dashboardData['orderStatusStats'], 'order_status')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($dashboardData['orderStatusStats'], 'count')); ?>,
                    backgroundColor: [
                        'rgb(75, 192, 192)',
                        'rgb(255, 205, 86)',
                        'rgb(255, 99, 132)',
                        'rgb(201, 29, 132)',
                        'rgb(239, 32, 192)',
                        'rgb(55, 127, 132)',
                        'rgb(54, 162, 235)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2,
            }
        });

        // customer growth chart
        const customerGrowthCtx = document.getElementById('customerGrowthChart').getContext('2d');
        console.log(<?php echo json_encode(array_column($dashboardData['customerStats']['customerGrowth'], 'new_customers')); ?>)
        new Chart(customerGrowthCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($dashboardData['customerStats']['customerGrowth'], 'month')); ?>,
                datasets: [{
                    label: 'New Customers',
                    data: <?php echo json_encode(array_column($dashboardData['customerStats']['customerGrowth'], 'new_customers')); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });



    // export function
    function exportReport() {
        window.location.href = '<?php echo ROOT_URL?>/admin/report/export';
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>