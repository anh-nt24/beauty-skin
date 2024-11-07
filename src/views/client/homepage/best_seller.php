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

<div class="container py-5">
    <div class="row g-4" id="best-products-grid">
    </div>

    <div class="text-center mt-4">
        <button id="view-more" class="btn btn-md btn-outline-dark px-2">
            <span class="button-text">View More <i class="bi bi-chevron-down ms-2"></i></span>
            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                <span class="visually-hidden">Loading...</span>
            </span>
            
        </button>
    </div>
</div>

<template id="product-template">
    <div class="col-md-3 product-item new-item">
        <div class="card h-100 border-0 shadow-sm product-card">
            <img src="" class="card-img-top product-img" alt="">
            <div class="card-body">
                <h5 class="card-title product-title"></h5>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="rating"></div>
                    <h5 class="text-danger mb-0 product-price"></h5>
                </div>
            </div>
        </div>
    </div>
</template>
    

<script>
    var currentBestSellerPage = 1;
    var isLoading = false;
    var hasMoreBest = true;

    function generateStarRating(rating) {
        if (!rating || rating < 0.5) {
            return `<small class="text-muted ms-1">No reviews yet</small>`;
        }

        let starsHtml = '';
        for(let i = 1; i <= 5; i++) {
            if(rating >= i) {
                starsHtml += '<i class="bi bi-star-fill"></i>';
            } else if(rating > i - 1) {
                starsHtml += '<i class="bi bi-star-half"></i>';
            } else {
                starsHtml += '<i class="bi bi-star"></i>';
            }
        }
        starsHtml += `<small class="text-muted ms-1">${Math.round(rating * 10) / 10}</small>`;
        return starsHtml;
    }

    
    function createProductCard(product) {
        const template = document.getElementById('product-template');
        const productCard = template.content.cloneNode(true);
        
        const card = productCard.querySelector('.product-card');
        const img = productCard.querySelector('.product-img');
        const title = productCard.querySelector('.product-title');
        const rating = productCard.querySelector('.rating');
        const price = productCard.querySelector('.product-price');

        card.setAttribute('data-product-id', product.id);
        img.src = `<?php echo ROOT_URL;?>/${product.image[0]}`;
        img.alt = product.product_name;
        title.textContent = product.product_name;
        rating.innerHTML = generateStarRating(product.average_rating);
        price.textContent = `$${product.price}`;

        card.addEventListener('click', () => {
            window.location.href = `<?php echo ROOT_URL;?>/products/view?product=${convertToSlug(product.product_name)}&id=${product.id}`;
        });

        return productCard;
    }

    function convertToSlug(productName) {
        let slug = productName.toLowerCase();
        slug = slug.replace(/\s+/g, '-');
        slug = slug.replace(/[^a-z0-9\-\.]/g, '');
        return slug;
    }

    
    async function loadProducts() {
        if (isLoading || !hasMoreBest) return;

        const loadMoreBtn = document.getElementById('view-more');
        const spinner = loadMoreBtn.querySelector('.spinner-border');
        const buttonText = loadMoreBtn.querySelector('.button-text');

        try {
            isLoading = true;
            loadMoreBtn.classList.add('loading');
            spinner.classList.remove('d-none');
            buttonText.textContent = 'Loading...';

            fetch(`<?php echo ROOT_URL;?>/products/bestseller?page=${currentBestSellerPage}`, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                hasMoreBest = data.hasMore;
                if (!hasMoreBest) {
                    loadMoreBtn.style.display = 'none';
                }

                const productsGrid = document.getElementById('best-products-grid');
                data.products.forEach(product => {
                    productsGrid.appendChild(createProductCard(product));
                });

                currentBestSellerPage++;
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
    document.addEventListener('DOMContentLoaded', loadProducts);
    document.getElementById('view-more').addEventListener('click', loadProducts);
</script>
