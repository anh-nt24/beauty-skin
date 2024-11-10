<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL . "/public/images/browser-logo.ico" ?>">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- custom style -->
    <link rel="stylesheet" href="<?php echo ROOT_URL . "/public/css/style.css" ?>">

</head>

<body>


    <!-- header -->
    <?php include __DIR__ .  "/../layouts/header.php"; ?>

    <!-- content -->
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Reset Password</h4>
                    </div>
                    <div class="card-body">
                        <form id="reset-password-form" data-token="<?= $token ?>">
                            <div class="mb-3">
                                <label for="new-password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new-password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm-new-password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm-new-password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </form>
                        <div id="response-message" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include __DIR__ . "/../layouts/footer.php"; ?>

    <script>
        document.getElementById('reset-password-form').addEventListener('submit', async (event) => {
            event.preventDefault();
            const token = event.target.dataset.token;
            const newPassword = document.getElementById('new-password').value;
            const confirmNewPassword = document.getElementById('confirm-new-password').value;

            try {
                const response = await fetch(`<?php echo ROOT_URL?>/password/reset-password?token=${token}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        newPassword,
                        confirmNewPassword
                    })
                });

                const data = await response.json();

                if (data.success) {
                    document.getElementById('response-message').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                } else {
                    document.getElementById('response-message').innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('response-message').innerHTML = '<div class="alert alert-danger">An error occurred. Please try again later.</div>';
            }
        });
    </script>

</body>

</html>