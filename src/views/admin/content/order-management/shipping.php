<script>
    document.title = "Shipping Services";
</script>

<div class="container py-5">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Shipping Services</h5>
                <button id="addServiceBtn" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Add Service
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($shippingServices as $service): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($service['name']); ?></td>
                        <td><?php echo htmlspecialchars($service['description']); ?></td>
                        <td>$<?php echo number_format($service['price'], 2); ?></td>
                        <td style="width: 10%;">
                            <button class="btn btn-sm btn-light editServiceBtn" onclick="editService(<?php echo $service['id']; ?>)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="<?php echo ROOT_URL;?>/admin/shipping-service/delete?id=<?php echo $service['id']; ?>" class="btn btn-sm btn-light" onclick="confirm('Are you sure you want to delete this service?')">
                                <i class="bi bi-trash text-danger"></i>
                    </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- modal -->
<div class="modal fade" id="shippingServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Shipping Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="shippingServiceForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // add
    document.querySelector('#addServiceBtn').addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelector('#shippingServiceModal .modal-title').textContent = 'Add Shipping Service';
        document.getElementById('shippingServiceForm').action = '<?php echo ROOT_URL; ?>/admin/shipping-service/add';
        document.getElementById('shippingServiceForm').method = 'post';
        document.getElementById('shippingServiceModal').querySelector('input, textarea').value = '';
        new bootstrap.Modal(document.getElementById('shippingServiceModal')).show();

    });

    // edit
    function editService(id) {
        document.querySelector('#shippingServiceModal .modal-title').textContent = 'Edit Shipping Service';
        document.getElementById('shippingServiceForm').action = '<?php echo ROOT_URL; ?>/admin/shipping-service/edit?id=' + id;
        document.getElementById('shippingServiceForm').method = 'post';

        fetch('<?php echo ROOT_URL; ?>/shipping-service?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('name').value = data.name;
                document.getElementById('description').value = data.description;
                document.getElementById('price').value = data.price;
                new bootstrap.Modal(document.getElementById('shippingServiceModal')).show();
            });
    }
        
</script>