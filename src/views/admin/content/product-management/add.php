<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body px-2">
                    <form action="<?php echo ROOT_URL . '/admin/product-management/add'?>" method="POST" enctype="multipart/form-data">
                        <!-- name -->
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="productName" name="productName" required>
                        </div>

                        <!-- category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">(*)</span></label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <?php foreach (array_slice(CATEGORIES, 0, 5) as $categoryIdx => $data): ?>
                                    <option value="<?php echo $categoryIdx?>"><?php echo $data;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- images -->
                        <div class="mb-3">
                            <label class="form-label">Product Images <span class="text-danger">(*)</span></label>
                            <div class="row g-3">
                                <?php for($i = 1; $i <= 9; $i++): ?>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="mb-2">
                                                <img width="100px" id="preview<?= $i ?>" src="#" alt="Preview" class="img-fluid d-none mb-2">
                                            </div>
                                            <input type="file" class="form-control form-control-sm" 
                                                    id="productImage<?= $i ?>" 
                                                    name="productImage[]" 
                                                    accept="image/*"
                                                    <?= ($i == 1) ? 'required' : '' ?>
                                                    onchange="previewImage(this, 'preview<?= $i ?>')">
                                            <div class="form-text">Image <?= $i ?> <?= ($i == 1) ? '(Required)' : '(Optional)' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">(*)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                        </div>

                        <!-- price and stock -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price <span class="text-danger">(*)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="stock" class="form-label">Stock <span class="text-danger">(*)</span></label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                        </div>

                        <!-- save -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Add Product</button>
                            <button type="reset" class="btn btn-secondary">Reset Form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.classList.add('d-none');
        }
    }
</script>