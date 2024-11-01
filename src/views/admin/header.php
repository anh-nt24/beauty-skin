<nav id="header" class="navbar navbar-default py-2" style="background: var(--gradient-color);">
    <div class="container">
        <div class="row w-100 d-flex align-items-center">
            <div class="col-md-6">
                <div class="navbar-header">
                    <div class="d-flex align-items-center">
                        <button id="sidebarToggle" class="btn text-decoration-none">
                            <i class="fa fa-list fs-4"></i>
                        </button>
                        <?php if ($current_section && $current_subsection): ?>
                            <nav aria-label="breadcrumb" class="ms-3">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <?php echo ucwords(str_replace('-', ' ', $current_section)); ?>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <?php echo $current_subsection == 'index' ? 'All' : ucfirst($current_subsection); ?>
                                    </li>
                                </ol>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <ul class="nav justify-content-end align-items-center w-100">
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
                                    <a class="dropdown-item" href="/password">Change password</a>
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
                    
                </ul>
            </div>

        </div>
    </div>
</nav>