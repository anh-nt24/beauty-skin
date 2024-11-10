<nav id="header" class="navbar navbar-default py-2 header-fix" style="background: var(--gradient-color);">
    <div class="container">
        <div class="row w-100 d-flex align-items-center">
            <div class="col-md-5">
                <div class="navbar-header" style="cursor: pointer;" onclick="navigateHome()">
                    <div class="d-flex flex-row align-items-center">
                        <img src="<?php echo ROOT_URL . "/public/images/logo.png" ?>" class="header__web-logo" alt="logo">
    
                        <div class="d-flex flex-column">
                            <span class="header__brand-name">BEAUTY <span style="color: #e562c3">SKIN</span></span>
                            <span class="header__brand-description">To reach the peak of perfection!</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <ul class="nav justify-content-end align-items-center w-100">
                    <li class="nav-item flex-grow-1 me-3">
                        <form method="get" action="<?php echo ROOT_URL?>/search" class="d-flex w-100">
                            <div class="input-group w-100">
                                <input name="query" type="text" class="form-control" placeholder="What are you looking for?">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </li>

                    <?php
                        if (isset($_COOKIE['user'])) {
                            $user = json_decode($_COOKIE['user'], true);
                            $userName = htmlspecialchars($user['name']);
                        }
                    ?>


                    <?php if (isset($userName)): ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user mx-1" style="font-size: 25px"></i>
                                <span><?php echo htmlspecialchars($userName); ?></span>
                                
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#editProfileModal">Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" style="cursor: pointer;" href="<?php echo ROOT_URL?>/password/change-password">Password</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo ROOT_URL?>/orders/history">Orders History</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo ROOT_URL . '/logout'?>">Logout <i class="fa fa-sign-out"></i> </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link normal-href" data-toggle="modal" data-target=".bs-modal-md" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fa fa-sign-in"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <button class="btn nav-link normal-href" onclick="toggleCart()">
                            <i class="fa fa-shopping-cart mr-2"></i> Cart
                            <span id="cart-count" class="text-danger"></span>
                        </button>
                    </li>
                </ul>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-md-12 col-sm-6 col-2">
                <ul class="header__product-category">
                    <?php foreach (array_slice(CATEGORIES, 0, 5) as $categoryIdx => $data): ?>
                        <li><a href="<?php echo ROOT_URL?>/search?query=&category%5B%5D=<?php echo str_replace(' ', '+', $data);?>" class="normal-href"><?php echo $data; ?></a></li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>
    </div>
</nav>

<?php include_once __DIR__ . '/cart_dialog.php' ?>
<?php 
    if (isset($_COOKIE['user'])) {
        include_once __DIR__ . '/view_profile.php';
    }
?>

<div class="header-remove-space" style="height:130px"></div>

<!-- cart -->
<script>
    function toggleCart() {
        const backdrop = document.getElementById('cartBackdrop');
        backdrop.classList.toggle('show');
        if (backdrop.classList.contains('show')) {
            loadCart();
        }
    }

    function updateCartCount() {
        const cart = getCookie('cart');
        let itemCount = 0;

        if (cart) {
            try {
                const cartItems = JSON.parse(cart);
                itemCount = Object.keys(cartItems).length;
            } catch (error) {
                console.error("Error parsing cart cookie:", error);
            }
        }

        document.getElementById('cart-count').textContent = `(${itemCount})`;
    }
    updateCartCount();

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }


    function setCookie(name, value) {
        document.cookie = `${name}=${value}; path=/`;
    }
</script>

<!-- header -->
<script>
    // navigate home
    function navigateHome() {
        window.location.href = '<?php echo ROOT_URL?>/'
    }

    // track scroll position and mouse position
    const header = document.getElementById("header");
    const specificPosition = 150;

    window.addEventListener("scroll", () => {
        const scrollTop = window.scrollY;

        // start tracking if scrolled past 100px
        if (scrollTop > specificPosition) {
            // hide header when scrolling up
            header.classList.add("hidden-header");
        } else {
            header.classList.remove("hidden-header");
        }
    });

    window.addEventListener("mousemove", (event) => {
        // show header if mouse is near the top of the viewport
        if (event.clientY < specificPosition) {
            header.classList.remove("hidden-header");
        }
    });

</script>

<?php include "auth_modals.php"; ?>