<script>
    document.title = "Customer Service - Product Ratings";
</script>

<style>
    .star-rating {
        color: #ffc107;
    }

    .review-card {
        transition: transform 0.2s;
    }

    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .stats-card {
        border-left: 4px solid;
    }

    .filter-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .card-title {
        min-height: 50px;
        overflow: hidden;
        -webkit-line-clamp: 2;
        display: -webkit-box;
        line-clamp: 2; 
        -webkit-box-orient: vertical;
    }

    .card-text {
        min-height: 100px;
        overflow: hidden;
        -webkit-line-clamp: 4;
        display: -webkit-box;
        line-clamp: 4; 
        -webkit-box-orient: vertical;
    }
</style>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100" style="border-left-color: #0d6efd;">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Reviews</h5>
                    <h2 class="mb-0"><?= number_format($viewData['stats']['totalReviews']) ?></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100" style="border-left-color: #ffc107;">
                <div class="card-body">
                    <h5 class="card-title text-muted">Average Rating</h5>
                    <h2 class="mb-0">
                        <?= number_format($viewData['stats']['averageRating'], 1) ?>
                        <small class="text-warning">
                            <i class="bi bi-star-fill"></i>
                        </small>
                    </h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100" style="border-left-color: #198754;">
                <div class="card-body">
                    <h5 class="card-title text-muted">Recent Reviews</h5>
                    <h2 class="mb-0"><?= $viewData['stats']['recentReviews'] ?></h2>
                    <small class="text-muted">Last 7 days</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100" style="border-left-color: #dc3545;">
                <div class="card-body">
                    <h5 class="card-title text-muted">Products Reviewed</h5>
                    <h2 class="mb-0"><?= $viewData['stats']['totalProducts'] ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <!-- filters section -->
    <div class="filter-section mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productFilter" placeholder="Search by product name...">
            </div>
            
            <div class="col-md-4">
                <label class="form-label">Rating</label>
                <select class="form-select" id="ratingFilter">
                    <option value="">All Ratings</option>
                    <?php for($i = 5; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>"><?= $i ?> Stars</option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div class="col-md-4">
                <label class="form-label">Date Range</label>
                <select class="form-select" id="dateFilter">
                    <option value="7">Last 7 Days</option>
                    <option value="30">Last 30 Days</option>
                    <option value="90">Last 3 Months</option>
                    <option value="all">All Time</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- reviews list -->
    <div class="row" id="reviewsList">
        <?php foreach ($viewData['reviews'] as $review): ?>
        <div class="col-md-6 mb-4">
            <div class="card review-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="card-title mb-1"><?= htmlspecialchars($review['product_name']) ?></h5>
                            <div class="star-rating">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star<?= $i <= $review['rating'] ? '-fill' : '' ?>"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <small class="text-muted">
                            Order: <?= htmlspecialchars($review['order_number']) ?>
                        </small>
                    </div>
                    
                    <p class="card-text"><?= htmlspecialchars($review['review']) ?></p>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            By <?= htmlspecialchars($review['customer_name']) ?>
                        </small>
                        <small class="text-muted">
                            <?= date('M d, Y', strtotime($review['review_date'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productFilter = document.getElementById('productFilter');
        const ratingFilter = document.getElementById('ratingFilter');
        const dateFilter = document.getElementById('dateFilter');

        function applyFilters() {
            const params = new URLSearchParams(window.location.search);
            
            // Update params with filter values
            if (productFilter.value) params.set('product', productFilter.value);
            else params.delete('product');
            
            if (ratingFilter.value) params.set('rating', ratingFilter.value);
            else params.delete('rating');
            
            if (dateFilter.value !== 'all') params.set('dateRange', dateFilter.value);
            else params.delete('dateRange');

            // Redirect with new params
            window.location.href = `<?php echo ROOT_URL?>/admin/customer-service/rating?${params.toString()}`;
        }

        // Add change event listeners
        productFilter.addEventListener('input', debounce(applyFilters, 500));
        ratingFilter.addEventListener('change', applyFilters);
        dateFilter.addEventListener('change', applyFilters);

        // Set initial values from URL params
        const urlParams = new URLSearchParams(window.location.search);
        productFilter.value = urlParams.get('product') || '';
        ratingFilter.value = urlParams.get('rating') || '';
        dateFilter.value = urlParams.get('dateRange') || '7';
    });

    // debounce function for product name search
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
</script>