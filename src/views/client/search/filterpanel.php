<div class="card shadow-sm">
    <div class="card-body">
        <form id="filterForm" method="GET" action="<?php echo ROOT_URL; ?>/search">
            <input type="hidden" name="query" value="<?php echo htmlspecialchars($_GET['query'] ?? ''); ?>">
            
            <!-- category -->
            <div class="mb-4">
                <h5 class="mb-3">Categories</h5>
                <div class="filter-section">
                    <?php foreach(CATEGORIES as $idx => $category): ?>
                    <div class="form-check">
                        <input class="form-check-input filter-checkbox" 
                               type="checkbox" 
                               name="category[]"
                               value="<?php echo $category?>"
                               <?php echo in_array($category, $selectedCategories ?? []) ? 'checked' : ''; ?>>
                        <label class="form-check-label d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($category); ?>
                            <span class="badge bg-light text-dark"><?php echo $searchingResult['categoryCounts'][$category] ?? 0; ?></span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="mb-3">Price Range</h5>
                <div class="filter-section">
                    <?php foreach(PRICE_LEVELS as $idx => $level): ?>
                    <div class="form-check">
                        <input class="form-check-input filter-checkbox" 
                               type="checkbox" 
                               name="priceLevel[]" 
                               value="<?php echo $level['id']; ?>"
                               <?php echo in_array($level['id'], $selectedPriceLevels ?? []) ? 'checked' : ''; ?>>
                        <label class="form-check-label d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($level['name']); ?>
                            <span class="badge bg-light text-dark"><?php echo $searchingResult['priceLevelCounts'][$idx] ?? 0; ?></span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mb-3">
                <h5 class="mb-3">Sort By</h5>
                <select class="form-select filter-checkbox" name="sort">
                    <option value="newest" <?php echo ($_GET['sort'] ?? '') === 'newest' ? 'selected' : ''; ?>>Newest</option>
                    <option value="price_asc" <?php echo ($_GET['sort'] ?? '') === 'price_asc' ? 'selected' : ''; ?>>Price: Low to High</option>
                    <option value="price_desc" <?php echo ($_GET['sort'] ?? '') === 'price_desc' ? 'selected' : ''; ?>>Price: High to Low</option>
                </select>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="clearFilters">
                    Clear All Filters
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .filter-section {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .filter-section::-webkit-scrollbar {
        width: 5px;
    }

    .filter-section::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .filter-section::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 5px;
    }

    .badge {
        font-weight: normal;
        font-size: 0.8em;
    }
</style>

<script>
    document.getElementById('clearFilters').addEventListener('click', function() {
        const form = document.getElementById('filterForm');
        const query = form.querySelector('input[name="q"]').value;
        
        form.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        
        form.querySelector('select[name="sort"]').value = 'newest';
        
        window.location.href = '/search?q=' + encodeURIComponent(query);
    });
</script>