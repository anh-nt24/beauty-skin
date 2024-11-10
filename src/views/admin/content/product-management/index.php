<?php

$searchName = isset($_GET['name']) ? $_GET['name'] : '';
$searchCategory = isset($_GET['category']) ? $_GET['category'] : '';
$total_products = count($productData);

?>

<script>
    document.title = "Product Management";
</script>

<div class="container-fluid px-4">
    <!-- search -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <div method="GET" class="row g-3">
                <input type="hidden" name="section" value="product-management">
                <input type="hidden" name="subsection" value="index">
                
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               placeholder="Search by product name..." 
                               name="productName">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-tag"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               placeholder="Search by category..." 
                               name="productCategory">
                    </div>
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- total -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="bg-light rounded px-3 py-2">
            <span class="text-muted">Total Products:</span>
            <span class="fw-bold ms-2"><?php echo $total_products; ?></span>
        </div>
        
        <a href="<?php echo ROOT_URL?>/admin/product-management/add" class="btn btn-success">
            <i class="bi bi-plus-lg me-2"></i>
            Add New Product
        </a>
    </div>

    <!-- table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="productTableData" class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4" style="width: 45%">Product</th>
                            <th style="width: 20%">Price</th>
                            <th style="width: 10%">Stock</th>
                            <th style="width: 10%">Sold</th>
                            <th class="px-4" style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productData as $product): ?>
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <img src="<?= htmlspecialchars('/beauty-skin/' . $product['image'][0]); ?>" 
                                         class="rounded"
                                         alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                         width="50" 
                                         height="50">
                                    <div class="ms-3">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium">
                                                <?php echo htmlspecialchars($product['product_name']); ?>
                                            </span>
                                        </div>
                                        <div class="text-muted small">
                                            <span class="product-category badge bg-light text-dark me-2">
                                                <?php echo htmlspecialchars($product['category']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-medium">
                                    $<?php echo number_format($product['price'], 2); ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                    $stock_class = 'bg-success';
                                    if ($product['stock'] <= 10) {
                                        $stock_class = 'bg-danger';
                                    } elseif ($product['stock'] <= 20) {
                                        $stock_class = 'bg-warning';
                                    }
                                ?>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge <?php echo $stock_class; ?> rounded-pill">
                                        <?php echo $product['stock']; ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success">
                                        <?php echo $product['purchases']; ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-4">
                                <div class="btn-group">
                                    <button type="button" 
                                        class="btn btn-light btn-sm" 
                                        title="View Details"
                                        onclick="viewProduct(<?php echo $product['id']; ?>, '<?php echo $product['product_name']; ?>')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-light btn-sm text-danger" 
                                            title="Delete Product"
                                            onclick="deleteProduct(<?php echo $product['id']; ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if (empty($productData)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-box-seam fs-4 d-block mb-2"></i>
                                    No products found
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function convertToSlug(productName) {
            let slug = productName.toLowerCase();
            slug = slug.replace(/\s+/g, '-');
            slug = slug.replace(/[^a-z0-9\-\.]/g, '');
            return slug;
        }

        function viewProduct(id, name) {
            const href = `<?php echo ROOT_URL?>/admin/product-management/view?product=${convertToSlug(name)}&id=${id}`;
            window.location.href = href;
        }
        
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch(`<?php echo ROOT_URL;?>/admin/product-management/delete?id=${id}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert("Error deleting this product.");
                    }
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                    alert("An error occurred while processing your request.");
                });
            }
        }
    </script>

    <script>
        const productNameInp = document.querySelector('input[name="productName"]');
        const productCategoryInp = document.querySelector('input[name="productCategory"]');
        const productTableData = document.getElementById('productTableData');

        productNameInp.addEventListener('input', filterProductTable);
        productCategoryInp.addEventListener('input', filterProductTable);

        function filterProductTable() {
            const productName = productNameInp.value.toLowerCase().trim();
            const productCategory = productCategoryInp.value.toLowerCase().trim();
            const tableRows = productTableData.getElementsByTagName('tr');

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const productNameCell = row.getElementsByTagName('td')[0].textContent.toLowerCase().trim();
                const productCategoryCell = row.getElementsByTagName('td')[0].querySelector('.product-category').textContent.toLowerCase().trim();
                if (productNameCell.includes(productName) && productCategoryCell.includes(productCategory)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
    </script>
</div>