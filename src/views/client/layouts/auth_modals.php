<!-- LOGIN FORM -->
<div class="modal fade bs-modal-md" role="dialog" tabindex="-1" id="loginModal" aria-labelledby="loginModal">
    <div id="login-overlay" class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Account Login</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6">
                        <form id="loginForm" method="POST" action="/login" novalidate="novalidate">
                            <div class="form-group">
                                <div class="form-floating mb-3">
                                    <input id="loginEmail" type="email" class="form-control" name="email" placeholder="name@example.com" required>
                                    <label for="email">Email Address</label>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-floating">
                                    <input id="loginPassword" type="password" class="form-control" name="password" placeholder="Password" required>
                                    <label for="password">Password</label>
                                    <div class="invalid-feedback">Password must be at least 6 characters long.</div>
                                </div>
                            </div>
                            <div id="loginErrorMsg" class="alert text-danger is-invalid hide d-none">* Wrong email or password</div>
                            <div class="row mt-2">
                                <div class="checkbox col-6">
                                    &nbsp;
                                    <label>
                                        <input type="checkbox" name="remember" id="remember" data-bs-toggle="tooltip" data-bs-placement="top" title="Check if this is a personal computer"> Remember login
                                    </label>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="<?php echo ROOT_URL?>/password/forgot-password" class="btn btn-default btn-block text-danger">Forgot Password? </a>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center mb-2">
                                <button type="submit" class="btn btn-success btn-block col-6" style="background: var(--gradient-color); border: none">Login</button>
                            </div>

                            <p class="text-center">You don't have an account? <a href="#" id="openRegisterModal" style="color: red;"> Sign up</a> now!</p>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <p class="px-2">Log in now for easier shopping,
                            access to the latest features,
                            and exclusive member benefits of
                            <a href="<?php echo ROOT_URL . "/"; ?>" style="color: red;">Beauty Skin</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- REGISTRATION FORM -->
<div class="modal fade bs-modal-md" role="dialog" tabindex="-1" id="registerModal" aria-labelledby="registerModal">
    <div id="login-overlay" class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Account Sign Up</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6">
                        <form id="registerForm" method="POST" action="/register" novalidate="novalidate">
                            <div class="form-group">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="name" placeholder="John Doe" required>
                                    <label for="name">Your name</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="phone" placeholder="0123456789" required>
                                    <label for="phone">Phone number</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="address" name="address" placeholder="name@example.com" required>
                                    <label for="adress">Address</label>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                    <label for="email">Email Address</label>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-floating form-floating mb-3">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                                    <label for="password">Password</label>
                                    <div class="invalid-feedback">Password must be at least 6 characters long and match the confirmation.</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-floating form-floating mb-3">
                                    <input id="confirmPassword" type="password" class="form-control" placeholder="Password" required>
                                    <label for="confirmPassword">Confirm Password</label>
                                    <div class="invalid-feedback">Passwords do not match.</div>
                                </div>
                            </div>

                            <div id="registerErrorMsg" class="alert text-danger is-invalid hide d-none">* Register failed. Check your information!</div>

                            <div class="row d-flex justify-content-center mb-2">
                                <button type="submit" class="btn btn-success btn-block col-6" style="background: var(--gradient-color); border: none">Sign up</button>
                            </div>

                            <p class="text-center">You already have an account? <a href="#" id="openLoginModal" style="color: red;"> Login </a> now!</p>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <p class="px-2">Log in now for easier shopping,
                            access to the latest features,
                            and exclusive member benefits of
                            <a href="<?php echo ROOT_URL . "/"; ?>" style="color: red;">Beauty Skin</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- handle validate data before submitting -->
<script>
    function checkEmail(email) {
        const emailPattern = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
        return emailPattern.test(email)
    }

    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const email = document.getElementById('loginEmail');
        const password = document.getElementById('loginPassword');
        
        let isValid = true;


        if (!checkEmail(email.value)) {
            email.classList.add('is-invalid');
            isValid = false;
        } else {
            email.classList.remove('is-invalid');
        }

        if (password.value.length < 6) {
            password.classList.add('is-invalid');
            isValid = false;
        } else {
            password.classList.remove('is-invalid');
        }

        if (isValid) {
            const formData = new FormData(this);
            login(formData);
        }
    });

    function login(formData) {
        fetch("<?php echo ROOT_URL . "/login";?>", {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                const user = data.user;
                document.cookie = `user=${JSON.stringify(user)}; max-age=${30 * 24 * 60 * 60}; path=/`;

                const alertHtml = `
                    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute; right: 20px; bottom: 75px; width: 25%">
                        ${data.message}
                        <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `;

                $('body').append(alertHtml);

                setTimeout(function() {
                    $('#success-alert').alert('close');
                    if (user.role === 'admin') {
                        window.location.href = "<?php echo ROOT_URL . "/admin";?>";
                    } else {
                        location.reload();
                    }
                }, 1000);
            } else {
                const errorMsg = document.getElementById('loginErrorMsg');
                errorMsg.textContent = data.message;
                errorMsg.classList.remove('d-none');
            }
        })
        .catch(error => console.error('Error:', error));
    }


    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        
        let isValid = true;


        if (!checkEmail(email.value)) {
            email.classList.add('is-invalid');
            isValid = false;
        } else {
            email.classList.remove('is-invalid');
        }

        if (password.value.length < 6) {
            password.classList.add('is-invalid');
            isValid = false;
        } else {
            password.classList.remove('is-invalid');
        }

        if (password.value !== confirmPassword.value) {
            confirmPassword.classList.add('is-invalid');
            isValid = false;
        } else {
            confirmPassword.classList.remove('is-invalid');
        }

        if (isValid) {
            const formData = new FormData(this);
            register(formData);
        }
    });

    function register(formData) {
        fetch("<?php echo ROOT_URL . "/register";?>", {
            method: 'POST',
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then(data => {
            if (data && data.status === 200) {
                const user = data.user
                document.cookie = `user=${JSON.stringify(user)}; max-age=${30 * 24 * 60 * 60}; path=/`;
                const alertHtml = `
                    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute; right: 20px; bottom: 75px; width: 25%">
                        ${data.message}
                        <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `;

                $('body').append(alertHtml);

                setTimeout(function() {
                    $('#success-alert').alert('close');
                    location.reload();
                }, 1000);
            } else {
                const errorMsg = document.getElementById('registerErrorMsg');
                errorMsg.textContent = data.message || "An error occurred during registration.";
                errorMsg.classList.remove('d-none');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorMsg = document.getElementById('registerErrorMsg');
            errorMsg.textContent = "Failed to register. Please try again.";
            errorMsg.classList.remove('d-none');
        });
    }

</script>

<!-- handle toggle between login and register -->
<script>
    document.getElementById('openRegisterModal').addEventListener('click', function(event) {
        event.preventDefault();

        // close login modal
        $('#loginModal').modal('hide');

        // open register modal
        $('#registerModal').modal('show');
    });

    document.getElementById('openLoginModal').addEventListener('click', function(event) {
        event.preventDefault();

        // close register modal
        $('#registerModal').modal('hide');

        // open login modal
        $('#loginModal').modal('show');
    });
</script>