<?php
    $user = json_decode($_COOKIE['user'], true);
?>


<style>
    .product-img-checkout {
        width: 60px;
        height: 60px;
        object-fit: cover;
    }
    .shipping-option {
        cursor: pointer;
        transition: all 0.2s;
    }
    .shipping-option:hover {
        background-color: #f8f9fa;
    }
    .shipping-option.selected {
        background-color: #e7f1ff;
        border-color: #0d6efd;
    }
</style>


<div class="modal fade" id="checkoutModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Your Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="checkoutForm" onsubmit="handleCheckout(event)">
                    <!-- customer -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Customer Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Shipping Address</label>
                                <textarea class="form-control" rows="3" id="shippingAddress"><?php echo htmlspecialchars($user['address']); ?></textarea>
                                <div class="form-text">You can edit the shipping address if needed.</div>
                            </div>
                        </div>
                    </div>

                    <!-- order -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Order Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody id="checkoutTable">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- shipping -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Shipping Method</h6>
                        </div>
                        <div class="card-body">
                            <?php foreach ($shippingServices as $service): ?>
                            <div class="shipping-option card mb-2" 
                                    onclick="selectShippingOption(<?php echo $service['id']; ?>, <?php echo $service['price']; ?>)">
                                <div class="card-body d-flex justify-content-between align-items-center py-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" 
                                                name="shippingMethod" 
                                                id="shipping<?php echo $service['id']; ?>"
                                                value="<?php echo $service['id']; ?>" required>
                                        <label class="form-check-label" for="shipping<?php echo $service['id']; ?>">
                                            <strong><?php echo htmlspecialchars($service['name']); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo htmlspecialchars($service['description']); ?></small>
                                        </label>
                                    </div>
                                    <div>
                                        <strong>$<?php echo number_format($service['price'], 2); ?></strong>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- total -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="subtotal">$0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span id="shippingCost">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span id="totalPrice">$0</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="checkoutForm" class="btn btn-primary">
                    Place Order
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var selectedShippingPrice;
    var subtotalAmount = 0;

    $('#checkoutModal').on('hidden.bs.modal', function (e) {
        checkout = null;
    });

    $('#checkoutModal').on('show.bs.modal', function (e) {
        selectedShippingPrice = 0;
        if (checkout) {
            subtotalAmount = checkout.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
            renderCheckoutTable(checkout, subtotalAmount);
        }
    });


    function renderCheckoutTable(data, subtotal) {
        const tableBody = document.getElementById('checkoutTable');
        const totalPriceEl = document.getElementById('totalPrice');
        const subtotalEl = document.getElementById('subtotal');

        tableBody.innerHTML = '';


        data.forEach(item => {
            const row = document.createElement('tr');

            const imgCell = document.createElement('td');
            imgCell.classList.add('w-auto');
            imgCell.innerHTML = `
                <img src="${item.image}" 
                    alt="${item.product_name}"
                    class="product-img-checkout rounded">
            `;
            
            const nameCell = document.createElement('td');
            nameCell.classList.add('align-middle');
            nameCell.innerHTML = `
                <h6 class="mb-0">${item.product_name}</h6>
                <small class="text-muted">Quantity: ${item.quantity}</small>
            `;

            const priceCell = document.createElement('td');
            priceCell.classList.add('align-middle', 'text-end');
            priceCell.innerHTML = `$${(item.price * item.quantity).toFixed(2)}`;

            row.appendChild(imgCell);
            row.appendChild(nameCell);
            row.appendChild(priceCell);

            tableBody.appendChild(row);
        });

        subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
        totalPriceEl.textContent = `$${subtotal.toFixed(2)}`;
    }
    

    $('#checkoutModal').on('hidden.bs.modal', function (e) {
        checkout = null;
    });


    function selectShippingOption(serviceId, price) {
        // update style
        document.querySelectorAll('.shipping-option').forEach(option => {
            option.classList.remove('selected');
        });
        document.querySelector(`#shipping${serviceId}`).closest('.shipping-option').classList.add('selected');
        document.querySelector(`#shipping${serviceId}`).checked = true;
        
        // update price
        selectedShippingPrice = price;
        document.getElementById('shippingCost').textContent = `$${price.toFixed(2)}`;
        document.getElementById('totalPrice').textContent = `$${(subtotalAmount + price).toFixed(2)}`;
    }

    function handleCheckout(event) {
        event.preventDefault();
        
        if (!document.querySelector('input[name="shippingMethod"]:checked')) {
            alert('Please select a shipping method');
            return;
        }

        // let orderDetails = JSON.parse(document.cookie.split('; checkout=')[1]);
        let orderDetails = checkout;
        orderDetails = orderDetails.map(item => ({
            id: item.id,
            quantity: item.quantity
        }));
        

        const formData = {
            customerId: <?php echo $user['id']?>,
            shippingId: document.querySelector('input[name="shippingMethod"]:checked').value,
            shippingAddress: document.getElementById('shippingAddress').value,
            totalAmount: subtotalAmount + selectedShippingPrice,
            orderDetails: orderDetails
        };

        bootstrap.Modal.getInstance(document.getElementById('checkoutModal')).hide();
        
        fetch("<?php echo ROOT_URL;?>/order-management/add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (response.ok) {
                window.location.href = "<?php echo ROOT_URL?>/orders/history";
            } else {
                alert("Failed to place order. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred. Please try again.");
        });

    }
</script>