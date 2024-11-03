<div class="container py-5">
    <div class="row g-4" id="newest-products-grid">
    </div>

    <div class="text-center mt-4">
        <button id="load-more" class="btn btn-md btn-outline-dark px-2">
            <span class="button-text">View More <i class="bi bi-chevron-down ms-2"></i></span>
            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                <span class="visually-hidden">Loading...</span>
            </span>
            
        </button>
    </div>
</div>

<script>
    var currentPage = 1;
    var isLoading = false;
    var hasMore = true;
    
    async function loadNewProducts() {
        if (isLoading || !hasMore) return;

        const loadMoreBtn = document.getElementById('load-more');
        const spinner = loadMoreBtn.querySelector('.spinner-border');
        const buttonText = loadMoreBtn.querySelector('.button-text');

        try {
            isLoading = true;
            loadMoreBtn.classList.add('loading');
            spinner.classList.remove('d-none');
            buttonText.textContent = 'Loading...';

            fetch(`<?php echo ROOT_URL;?>/newest-products?page=${currentPage}`, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                hasMore = data.hasMore;
                if (!hasMore) {
                    loadMoreBtn.style.display = 'none';
                }

                const productsGrid = document.getElementById('newest-products-grid');
                data.products.forEach(product => {
                    productsGrid.appendChild(createProductCard(product));
                });

                currentPage++;
            })

        } catch (error) {
            console.error('Error loading products:', error);
            buttonText.textContent = 'Error loading products. Try again.';
        } finally {
            isLoading = false;
            loadMoreBtn.classList.remove('loading');
            spinner.classList.add('d-none');
            buttonText.innerHTML = 'View more <i class="bi bi-chevron-down ms-2"></i>';
        }
    }

    // initial
    document.addEventListener('DOMContentLoaded', loadNewProducts);
    document.getElementById('load-more').addEventListener('click', loadNewProducts);
</script>
