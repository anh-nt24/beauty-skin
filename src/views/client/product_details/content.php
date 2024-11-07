<style>
    .gray-bg {
        background-color: #eee;
    }

    .white-bg {
        background-color: #fff;
    }

    .thumbnail-img {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
        aspect-ratio: 1;
        object-fit: cover;
    }

    .thumbnail-img:hover {
        opacity: 0.7;
    }

    .thumbnail-img.active {
        border-color: #0d6efd;
    }

    .rating-stars {
        color: #ffc107;
    }

    .quantity-controls {
        opacity: <?php echo $isLoggedIn ? '1' : '0.6'; ?>;
        pointer-events: <?php echo $isLoggedIn ? 'auto' : 'none'; ?>;
    }

    .main-image-container {
        aspect-ratio: 4/3;
        overflow: hidden;
        position: relative;
        background-color: #f8f9fa;
        border-radius: 0.375rem;
    }

    .main-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .thumbnail-container {
        position: relative;
        overflow: hidden;
    }

    .thumbnail-slider {
        display: flex;
        transition: transform 0.3s ease;
        gap: 10px;
    }

    .thumbnail-item {
        flex: 0 0 calc(20% - 8px);
        aspect-ratio: 1;
    }

    .nav-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.3s;
    }

    .nav-button:hover {
        background: white;
        box-shadow: 0 3px 8px rgba(0,0,0,0.3);
    }
    
    .nav-button.prev {
        left: 5px;
    }

    .nav-button.next {
        right: 5px;
    }

    .nav-button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .rating-stars {
        color: #ffc107;
    }

    .seperated {
        border-left: 1px solid rgba(0, 0, 0, .3);
    }

    .quantity-controls {
        opacity: <?php echo $isLoggedIn ? '1' : '0.6'; ?>;
        pointer-events: <?php echo $isLoggedIn ? 'auto' : 'none'; ?>;
    }
</style>


<div class="container-fluid p-5 gray-bg">
    <div class="card border-0">
        <div class="row white-bg card-body p-4 shadow-sm">
            <!-- images -->
            <div class="col-md-6 mb-4">
                <!-- area to  -->
                <div class="main-image-container mb-3 shadow">
                    <img src="../<?php echo htmlspecialchars($productData['image'][0]); ?>" 
                            class="main-image" 
                            id="mainImage" 
                            alt="Main Product Image">
                </div>
                
                <!-- thumbnail -->
                <?php if (count($productData['image']) > 0): ?>
                <div class="thumbnail-container mt-3">
                    <?php if (count($productData['image']) > 5): ?>
                    <button class="nav-button prev" onclick="navigateImages(-1)" disabled>
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="nav-button next" onclick="navigateImages(1)">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                    <?php endif; ?>
                    
                    <div class="thumbnail-slider" id="thumbnailSlider">
                        <?php foreach ($productData['image'] as $index => $image): ?>
                        <div class="thumbnail-item">
                            <img src="../<?php echo htmlspecialchars($image); ?>" 
                                    class="img-fluid rounded thumbnail-img <?php echo $index === 0 ? 'active' : ''; ?>" 
                                    onclick="updateMainImage(this, <?php echo $index; ?>)"
                                    alt="Product Thumbnail <?php echo $index + 1; ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
    
            <!-- product details -->
            <div class="col-md-6">
                <h1 class="mb-3"><?php echo htmlspecialchars($productData['product_name']); ?></h1>
                
                <!-- rating -->
                <div class="mb-4">
                    <span class="rating-stars">
                        <?php
                        $rating = $productData['average_rating'];
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<i class="bi bi-star-fill"></i>';
                            } elseif ($i - 0.5 <= $rating) {
                                echo '<i class="bi bi-star-half"></i>';
                            } else {
                                echo '<i class="bi bi-star"></i>';
                            }
                        }
                        ?>
                    </span>
                    <span class="ms-2 text-muted">
                        <?php echo number_format($rating, 1); ?> 
                        (<?php echo $productData['rating_count']; ?> ratings)
                    </span>
                    <span class="ms-2 p-2 text-muted seperated">
                        <?php echo $productData['purchases']; ?> purchases
                    </span>
                </div>
    
                <!-- price -->
                <h2 class="mb-4 text-danger">
                    $<?php echo number_format($productData['price'], 2); ?>
                </h2>
    
                <!-- stock status -->
                <div class="mb-3">
                    <span class="badge bg-<?php echo $productData['stock'] > 0 ? 'success' : 'danger'; ?>">
                        <?php echo $productData['stock'] > 0 ? 'In Stock' : 'Out of Stock'; ?>
                    </span>
                    <?php if ($productData['stock'] > 0): ?>
                        <span class="text-muted ms-2">(<?php echo $productData['stock']; ?> units available)</span>
                    <?php endif; ?>
                </div>
    
                <!-- quantity selection -->
                <div class="mb-4 d-flex align-items-center">
                    <label for="quantity" class="form-label mb-0">Quantity:</label>
                    <div class="input-group quantity-controls ms-2" style="width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(-1)">-</button>
                        <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="<?php echo $productData['stock']; ?>">
                        <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(1)">+</button>
                    </div>
                    <?php if (!$isLoggedIn): ?>
                        <small class="text-muted ms-1">Please login to adjust quantity</small>
                    <?php endif; ?>
                </div>
    
                <!-- cart and buy -->
                <div class="d-flex gap-2">
                    <button class="col-6 btn btn-warning" <?php echo $productData['stock'] === 0 ? 'disabled' : '' ?> <?php echo ($isLoggedIn) ? "onclick=addToCart()" : "data-toggle='modal' data-target='.bs-modal-md' data-bs-toggle='modal' data-bs-target='#loginModal'"; ?>>
                        <i class="bi bi-cart-plus"></i> Add to Cart
                    </button>
                    <button class="col-6 btn btn-danger" <?php echo $productData['stock'] === 0 ? 'disabled' : '' ?>  <?php echo ($isLoggedIn) ? "onclick=buyProduct()" : "data-toggle='modal' data-target='.bs-modal-md' data-bs-toggle='modal' data-bs-target='#loginModal'"; ?> >
                        Buy Now
                    </button>
                </div>
            </div>

            <!-- description -->
            <hr class="my-3">
            <div class="col-12">
                <h3>Description</h3>
                <div>
                    <?php echo nl2br(htmlspecialchars($productData['description'])); ?>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-3"></div>

</div>

<script>
    function addToCart() {
        const productData = JSON.parse('<?php echo $productCartData; ?>');
        const quantity = document.getElementById('quantity').value;
        const cart = JSON.parse(getCookie('cart') || '{}');

        if (cart[productData.id]) {
            cart[productData.id].quantity += quantity;
        } else {
            cart[productData.id] = {
                id: productData.id,
                product_name: productData.product_name,
                price: productData.price,
                quantity: quantity,
                image: productData.image,
            };
        }

        setCookie('cart', JSON.stringify(cart), 365);
        
        const alertHtml = `
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute; right: 20px; bottom: 75px; width: 25%">
                Your product is added to cart
                <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

        $('body').append(alertHtml);

        setTimeout(function() {
            $('#success-alert').alert('close');
            location.reload();
        }, 1000);
    }

    var checkout = null;

    function buyProduct() {
        const productData = JSON.parse('<?php echo $productCartData; ?>');
        const quantity = document.getElementById('quantity').value;
        productData.quantity = parseInt(quantity);
        const data = JSON.stringify([productData]);
        checkout = JSON.parse(data);

        const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'), {
            keyboard: true
        });
        checkoutModal.show();
    }
</script>

<?php include __DIR__ . "/checkout.php" ?>