<?php
    $customersData = [
        [
            'id' => 'C001',
            'name' => 'John Doe',
            'phone' => '0123456789',
            'address' => '123 Main St, City Name, Country',
            'reg_date' => '2024-01-15',
            'total_orders' => 25,
            'success_rate' => 92
        ],
        [
            'id' => 'C002',
            'name' => 'Jane Smith',
            'phone' => '0987654321',
            'address' => '456 Oak Avenue, Town Name, Country',
            'reg_date' => '2024-02-01',
            'total_orders' => 18,
            'success_rate' => 88
        ],
        [
            'id' => 'C003',
            'name' => 'Robert Johnson',
            'phone' => '0123498765',
            'address' => '789 Pine Road, Village Name, Country',
            'reg_date' => '2024-02-20',
            'total_orders' => 7,
            'success_rate' => 10
        ],
        [
            'id' => 'C004',
            'name' => 'Mary Williams',
            'phone' => '0456789123',
            'address' => '321 Elm Street, City Name, Country',
            'reg_date' => '2024-03-05',
            'total_orders' => 12,
            'success_rate' => 75
        ],
        [
            'id' => 'C005',
            'name' => 'David Brown',
            'phone' => '0789123456',
            'address' => '654 Maple Lane, Town Name, Country',
            'reg_date' => '2024-03-15',
            'total_orders' => 5,
            'success_rate' => 80
        ]
    ];
?>

<div class="container-fluid py-4">
    <!-- search -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="" method="GET" class="d-flex gap-2">
                        <div class="flex-grow-1">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="text" class="form-control" 
                                        placeholder="Search by phone number..." 
                                        name="phone" 
                                        value="<?php echo isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : ''; ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <?php if(isset($_GET['phone'])): ?>
                            <a href="?" class="btn btn-outline-secondary">Clear</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- total -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-light rounded px-3 py-2">
            <span class="text-muted">Total Customers:</span>
            <span class="fw-bold ms-2"><?php echo count($customersData); ?></span>
        </div>
    </div>

    <!-- table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Registration Date</th>
                            <th class="text-center">Total Orders</th>
                            <th class="text-center">Success Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($customersData as $customer):
                            $rateColorClass = 'bg-success';
                            if($customer['success_rate'] < 90) {
                                $rateColorClass = 'bg-warning';
                            }
                            if($customer['success_rate'] < 50) {
                                $rateColorClass = 'bg-danger';
                            }
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['id']); ?></td>
                            <td>
                                <div class="fw-bold"><?php echo htmlspecialchars($customer['name']); ?></div>
                            </td>
                            <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" 
                                        title="<?php echo htmlspecialchars($customer['address']); ?>">
                                    <?php echo htmlspecialchars($customer['address']); ?>
                                </div>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($customer['reg_date'])); ?></td>
                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    <?php echo $customer['total_orders']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge <?php echo $rateColorClass; ?>">
                                    <?php echo $customer['success_rate']; ?>%
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>