<script>
    document.title = "Customer Management";
</script>

<div class="container-fluid py-4">
    <!-- search -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <div class="flex-grow-1">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="text" class="form-control" 
                                        placeholder="Search by phone number..." 
                                        name="phone">
                            </div>
                        </div>
                        <button id="searchCustomerButton" type="button" class="btn btn-primary">Search</button>
                        <button id="resetCustomerButton" class="btn btn-outline-secondary">Clear</button>
                    </div>
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
                <table id="customerTableData" class="table table-hover mb-0">
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

<script>
    const phoneInput = document.querySelector('input[name="phone"]');
    const customerTableData = document.getElementById('customerTableData');

    phoneInput.addEventListener('input', function() {
        const phoneNumber = this.value.trim();
        filterCustomerTable(phoneNumber);
    });

    function filterCustomerTable(phoneNumber) {
        const tableRows = customerTableData.getElementsByTagName('tr');

        for (let i = 0; i < tableRows.length; i++) {
            const row = tableRows[i];
            const phoneCol = row.getElementsByTagName('td')[2];
            if (phoneCol) {
                const rowPhoneNumber = phoneCol.textContent.trim();
                if (rowPhoneNumber.includes(phoneNumber)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
    }
</script>