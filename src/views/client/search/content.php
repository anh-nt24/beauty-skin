<?php
    function generateStarRating($rating) {
        if (!$rating || $rating < 0.5) {
            return "<small class='text-muted ms-1'>No reviews yet</small>";
        }

        $starsHtml = '';
        for($i = 1; $i <= 5; $i++) {
            if($rating >= $i) {
                $starsHtml .= '<i class="bi bi-star-fill"></i>';
            } else if($rating > $i - 1) {
                $starsHtml .= '<i class="bi bi-star-half"></i>';
            } else {
                $starsHtml .= '<i class="bi bi-star"></i>';
            }
        }
        $starsHtml .= '<small class="text-muted ms-1">' . round($rating, 1) . '</small>';
        return $starsHtml;
    }

?>

<style>
    .product-img {
        height: 200px;
        object-fit: cover;
    }
    .rating {
        color: #ffc107;
    }
    .product-card {
        transition: transform 0.2s;
        cursor: pointer;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-title {
        height: 48px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    #view-more {
        opacity: 1;
        transition: opacity 0.3s;
    }
    #view-more.loading {
        opacity: 0.7;
        cursor: not-allowed;
    }
    .product-card.new-item {
        animation: fadeInUp 0.5s ease-out;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="mb-4">
    <?php if (isset($searchQuery) && !empty($searchQuery)):?>
        <h2 class="mb-4">
            SEARCHING RESULTS FOR "<?php echo htmlspecialchars($searchQuery); ?>"
            <small class="text-muted fs-6">(<?php echo $searchingResult['totalCount']; ?> products found)</small>
        </h2>
    <?php endif;?>

    <div class="row g-4">
    <?php foreach($searchingResult['products'] as $product): ?>
        <div class="col-md-4 product-item new-item">
            <div onclick="viewDetails(`<?php echo $product['product_name']?>`, <?php echo $product['id']?>)" class="card h-100 border-0 shadow-sm product-card">
                <img src="<?php echo htmlspecialchars($product['image'][0]); ?>" 
                    class="card-img-top product-img" 
                    alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                <div class="card-body">
                    <h5 class="card-title product-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="rating"><?php echo generateStarRating($product['average_rating'])?></div>
                        <h5 class="text-danger mb-0 product-price">$<?php echo $product['price']?></h5>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

    <?php if(empty($searchingResult)): ?>
    <div class="text-center py-5">
        <h4 class="text-muted">No products found matching your criteria</h4>
        <p>Try adjusting your filters or search terms</p>
    </div>
    <?php endif; ?>
</div>


<script>
    function convertToSlug(productName) {
        let slug = productName.toLowerCase();
        slug = slug.replace(/\s+/g, '-');
        slug = slug.replace(/[^a-z0-9\-\.]/g, '');
        return slug;
    }

    function viewDetails(name, id) {
        window.location.href = `<?php echo ROOT_URL;?>/products/view?product=${convertToSlug(name)}&id=${id}`;
    }
</script>
