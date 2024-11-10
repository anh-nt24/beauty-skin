<style>
    .faq-section {
        max-width: 800px;
        margin: 0 auto;
    }

    .accordion-button {
        font-weight: 500;
        padding: 1.25rem;
        background-color: #fff;
        border: none;
        box-shadow: none !important;
    }

    .accordion-button:not(.collapsed) {
        color: #0d6efd;
        background-color: #f8f9fa;
    }

    .accordion-item {
        border: 1px solid rgba(0,0,0,.1);
        margin-bottom: 0.5rem;
        border-radius: 0.5rem !important;
        overflow: hidden;
    }

    .accordion-body {
        padding: 1.25rem;
        background-color: #f8f9fa;
        line-height: 1.6;
    }

    .faq-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .faq-header h2 {
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .faq-header p {
        color: #6c757d;
        max-width: 600px;
        margin: 0 auto;
    }

    .accordion-button::after {
        content: "\F282";
        font-family: "bootstrap-icons";
        background-image: none;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease;
    }

    .accordion-button:not(.collapsed)::after {
        content: "\F286";
        transform: rotate(0deg);
    }

    .search-box {
        position: relative;
        margin-bottom: 2rem;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .search-input {
        padding-left: 2.5rem;
        border-radius: 2rem;
        border: 1px solid rgba(0,0,0,.1);
    }

    .search-input:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
</style>

<div class="container py-5">
    <div class="faq-section">
        <div class="faq-header">
            <h2>Frequently Asked Questions</h2>
            <p>Find answers to common questions about our products and services.</p>
        </div>

        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" class="form-control search-input" id="faqSearch" 
                   placeholder="Search frequently asked questions...">
        </div>

        <div class="accordion" id="faqAccordion">
            <?php foreach (array_reverse($faqData) as $index => $faq): ?>
                <div class="accordion-item faq-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button <?php echo $index !== 0 ? 'collapsed' : ''; ?>" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#faq<?php echo $faq['id']; ?>">
                            <?php echo htmlspecialchars($faq['question']); ?>
                        </button>
                    </h2>
                    <div id="faq<?php echo $faq['id']; ?>" 
                         class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" 
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    document.getElementById('faqSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.accordion-button').textContent.toLowerCase();
            const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>