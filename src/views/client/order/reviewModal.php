<style>
    .rating {
        display: flex;
        gap: 0.5rem;
    }

    .rating input[type="radio"] {
        display: none;
    }

    .rating label {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
    }

    .rating label:hover,
    .rating label:hover ~ label {
        color: gold;
    }

    .rating input[type="radio"]:checked ~ label,
    .rating label:hover ~ label,
    .rating label:hover {
        color: gold;
    }

    .rating {
        direction: rtl;
        display: inline-flex;
    }
</style>

<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Write Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="reviewForm">
                    <input type="hidden" id="orderId" name="orderId">
                    <div id="reviewProducts">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitReviews()">Submit Reviews</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.rating').forEach(rating => {
        rating.addEventListener('mouseover', (e) => {
            if (e.target.tagName === 'LABEL') {
                const stars = Array.from(rating.querySelectorAll('label'));
                const hoverIndex = stars.indexOf(e.target);

                stars.forEach((star, index) => {
                    star.style.color = index <= hoverIndex ? 'gold' : '#ccc';
                });
            }
        });

        rating.addEventListener('mouseout', () => {
            const selected = rating.querySelector('input[type="radio"]:checked');
            const stars = Array.from(rating.querySelectorAll('label'));

            stars.forEach((star, index) => {
                star.style.color = selected && index < selected.value ? 'gold' : '#ccc';
            });
        });
    });
</script>