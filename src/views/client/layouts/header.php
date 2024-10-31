<nav id="header" class="navbar navbar-default py-2 header-fix" style="background: var(--gradient-color);">
    <div class="container">
        <div class="row w-100 d-flex align-items-center">
            <div class="col-md-5">
                <div class="navbar-header">
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
                        <form class="d-flex w-100">
                            <div class="input-group w-100">
                                <input type="text" class="form-control" placeholder="What are you looking for?">
                                <button class="btn btn-outline-secondary" type="button">
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
                                    <a class="dropdown-item" href="/profile">Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/logout">Logout <i class="fa fa-sign-out"></i> </a>
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
                        <a href="/cart" class="nav-link normal-href"><i class="fa fa-shopping-cart mr-2"></i> Cart</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-md-12 col-sm-6 col-2">
                <ul class="header__product-category">
                    <li><a href="" class="normal-href">Lipstick</a></li>
                    <li><a href="" class="normal-href">Makeup Remover</a></li>
                    <li><a href="" class="normal-href">Sleeping Mask</a></li>
                    <li><a href="" class="normal-href">Toner</a></li>
                    <li><a href="" class="normal-href">Whitening</a></li>
                    <li><a href="" class="normal-href">Peeling</a></li>
                </ul>

            </div>
        </div>
    </div>
</nav>

<div class="header-remove-space" style="height:135px"></div>

<!-- hide header -->
<script>

    // track scroll position and mouse position
    const header = document.getElementById("header");
    const specificPosition = 200;

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