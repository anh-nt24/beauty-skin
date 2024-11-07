<script>
    document.title = "View a Product";
</script>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-end mb-4">        
        <button id="editButton" class="btn btn-warning">
            <i class="bi bi-pen me-2"></i>
            Edit Product
        </button>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body px-2">
                    <form id="productForm" action="<?php echo ROOT_URL . '/admin/product-management/edit?id=' . $productData['id']?>" method="POST" enctype="multipart/form-data">
                        <!-- name -->
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name <span class="text-danger">(*)</span></label>
                            <input readonly value="<?php echo $productData['product_name']?>" type="text" class="form-control" id="productName" name="productName" required>
                        </div>

                        <!-- category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">(*)</span></label>
                            <select disabled class="form-select" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <?php foreach (array_slice(CATEGORIES, 0, 5) as $categoryIdx => $data): ?>
                                    <option <?php echo CATEGORIES[$categoryIdx] == $productData['category'] ? 'selected' : ''; ?> value="<?php echo $categoryIdx?>"><?php echo $data;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- images -->
                        <div class="mb-3">
                            <label class="form-label">Product Images <span class="text-danger">(*)</span></label>
                            <div class="row g-3">
                                <?php for($i = 1; $i <= 9; $i++): ?>
                                    <?php if (isset($productData['image'][$i-1]) && !empty($productData['image'][$i-1])):?>
                                        <!-- case: uploaded images -->
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body p-2">
                                                    <div class="mb-2">
                                                        <!-- preview -->
                                                        <img width="100px" id="preview<?= $i ?>" 
                                                            src="../../<?= htmlspecialchars($productData['image'][$i - 1]) ?>" 
                                                            alt="Preview" 
                                                            class="img-fluid mb-2">
                                                    </div>
                                                    <!-- checkbox to remove the image -->
                                                     <?php if ($i !== 1):?>
                                                        <input type="checkbox" 
                                                            id="removeImage<?= $i ?>" 
                                                            name="removeImage[]" 
                                                            value="<?= $i - 1 ?>" 
                                                            onchange="toggleImageInput(<?= $i ?>)">
                                                        <label for="removeImage<?= $i ?>" <i class="bi bi-trash text-danger"></i> </label>
                                                    <?php endif;?>
                                                    
                                                    <!-- replace the image or leaving it unchanged -->
                                                    <input type="file" class="form-control form-control-sm" 
                                                        id="productImage<?= $i ?>" 
                                                        name="productImage[]" 
                                                        accept="image/*"
                                                        onchange="previewImage(this, 'preview<?= $i ?>')">
                                                    
                                                    <!-- hidden input to store the existing image path 
                                                     if the user doesn't update the file or remove it -->
                                                    <input type="hidden" name="existingImages[]" value="<?= htmlspecialchars($productData['image'][$i - 1]) ?>">

                                                    <div class="form-text">Image <?= $i ?> (Optional)</div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <!-- case: not uploaded images -->
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
                                    <?php endif;?>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">(*)</span></label>
                            <textarea readonly class="form-control" id="description" name="description" rows="5" required><?php echo $productData['description']?></textarea>
                        </div>

                        <!-- price and stock -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price <span class="text-danger">(*)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input value="<?php echo $productData['price'];?>" readonly type="number" class="form-control" id="price" name="price" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="stock" class="form-label">Stock <span class="text-danger">(*)</span></label>
                                <input value="<?php echo $productData['stock']?>" readonly type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                        </div>

                        <!-- save -->
                        <div class="d-flex gap-2">
                            <button disabled id="saveButton" type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" onclick="window.location.reload()" class="btn btn-secondary">Reset Form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('editButton').addEventListener('click', function () {
        const formElements = document.querySelectorAll('#productForm input, #productForm select, #productForm textarea');

        formElements.forEach(element => {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.readOnly = !element.readOnly;
            } else if (element.tagName === 'SELECT') {
                element.disabled = !element.disabled;
            }
        });

        document.querySelector("#saveButton").disabled = false;
    });
    
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

    function toggleImageInput(index) {
        const fileInput = document.getElementById(`productImage${index}`);
        const preview = document.getElementById(`preview${index}`);
        const removeCheckbox = document.getElementById(`removeImage${index}`);

        if (removeCheckbox.checked) {
            fileInput.value = '';
            fileInput.disabled = true;
            preview.src = '#';
            preview.classList.add('d-none');
        } else {
            fileInput.disabled = false;
        }
    }
</script>