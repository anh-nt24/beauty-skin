<div class="cart-backdrop" id="cartBackdrop" onclick="handleBackdropClick(event)">
    <div class="cart-dialog shadow">
        <!-- cart header -->
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Shopping Cart</h5>
            <button class="btn btn-outline-secondary btn-sm" onclick="toggleCart()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- cart products -->
        <div class="flex-grow-1 overflow-auto" id="cartContent">
        </div>

        <!-- cart footer -->
        <div class="p-3 border-top bg-light">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <strong>Total Selected:</strong>
                    <span id="totalAmount">$0.00</span>
                </div>
                <button class="btn btn-danger" onclick="placeOrder()">
                    Place Order
                </button>
            </div>
        </div>
    </div>
</div>


<!-- cart -->
<script>
    function handleBackdropClick(event) {
        if (event.target.id === 'cartBackdrop') {
            toggleCart();
        }
    }
    
    // update quantity
    function updateQuantity(index, change, newValue = null) {
        let cartData = Object.values(JSON.parse(getCookie('cart') || '[]'));
        
        if (newValue !== null) {
            cartData[index].quantity = Math.max(1, parseInt(newValue));
        } else {
            cartData[index].quantity = Math.max(1, cartData[index].quantity + change);
        }

        setCookie('cart', JSON.stringify(cartData));
        loadCart();
        updateTotal();
    }

    function toggleSelectAll(checkbox) {
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        itemCheckboxes.forEach(item => item.checked = checkbox.checked);
        updateTotal();
    }

    function updateTotal() {
        const cartData = Object.values(JSON.parse(getCookie('cart') || '[]'));
        const totalAmount = document.getElementById('totalAmount');
        let total = 0;

        document.querySelectorAll('.item-checkbox').forEach((checkbox, index) => {
            if (checkbox.checked) {
                total += cartData[index].price * cartData[index].quantity;
            }
        });

        totalAmount.textContent = `$${total.toFixed(2)}`;
    }


    var checkout = null;
    function placeOrder() {
        const selectedItems = [];
        let cartData = JSON.parse(document.cookie.split('; ').find(row => row.startsWith('cart='))?.split('=')[1] || '{}');
        const cartArr = Object.values(cartData);

        document.querySelectorAll('.item-checkbox').forEach((checkbox, index) => {
            if (checkbox.checked) {
                selectedItems.push(cartArr[index]);
            }
        });

        if (selectedItems.length === 0) {
            alert('Please select at least one item to place order');
            return;
        }
        
        checkout = selectedItems;

        selectedItems.forEach(item => {
            delete cartData[item.id];
        });

        document.cookie = `cart=${JSON.stringify(cartData)}; path=/; max-age=${365 * 24 * 60 * 60}`;


        const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'), {
            keyboard: true
        });
        checkoutModal.show();
    }

</script>

<!-- card contents -->
<script>

    var checkout = null;

    function loadCart() {
        const cartContent = document.getElementById('cartContent');
        const userCookie = getCookie('user');
        
        if (!userCookie) {
            // user not login
            cartContent.innerHTML = `
                <div class="p-4 text-center">
                    <i class="bi bi-person-x display-4 text-secondary mb-3"></i>
                    <h5>Please Log In</h5>
                    <p class="text-muted">You need to log in to view your cart</p>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target=".bs-modal-md" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fa fa-sign-in"></i> Login
                    </a>
                </div>
            `;
            return;
        }

        // get cart data from cookie
        let cartData = JSON.parse(getCookie('cart') || '[]');
        
        if (cartData.length === 0) {
            cartContent.innerHTML = `
                <div class="p-4 text-center">
                    <i class="bi bi-cart-x display-4 text-secondary mb-3"></i>
                    <h5>Your Cart is Empty</h5>
                    <p class="text-muted">Start shopping to add items to your cart</p>
                </div>
            `;
            return;
        }


        // render cart items
        let html = `
            <div class="p-3">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                    <label class="form-check-label" for="selectAll">Select All Items</label>
                </div>
        `;
        
        Object.values(cartData).map((item, index) => {
            html += `
                    <div class="cart-item border-bottom py-3">
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input item-checkbox" type="checkbox" 
                                       value="${item.id}" onchange="updateTotal()">
                            </div>
                            <img onclick="viewDetails(${item.id}, '${item.product_name}')" src="${item.image}" class="cart-product-img rounded" alt="${item.product_name}">
                            <div class="flex-grow-1" onclick="viewDetails(${item.id}, '${item.product_name}')">
                                <h6 class="mb-1">${item.product_name}</h6>
                                <div class="text-danger mb-2">$${item.price}</div>
                                <div class="quantity-control d-flex gap-2 align-items-center">
                                    <button class="btn btn-outline-secondary btn-quantity" 
                                            onclick="updateQuantity(${index}, -1)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" class="form-control cart-quantity-input" 
                                           value="${item.quantity}" min="1"
                                           onchange="updateQuantity(${index}, 0, this.value)">
                                    <button class="btn btn-outline-secondary btn-quantity" 
                                            onclick="updateQuantity(${index}, 1)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
        });

        html += `</div>`;
        cartContent.innerHTML = html;
    }

    function viewDetails(id, name) {
        window.location.href = `<?php echo ROOT_URL;?>/products/view?product=${convertToSlug(name)}&id=${id}`
    }

    function convertToSlug(productName) {
        let slug = productName.toLowerCase();
        slug = slug.replace(/\s+/g, '-');
        slug = slug.replace(/[^a-z0-9\-.\#]/g, '');
        return slug;
    }
</script>