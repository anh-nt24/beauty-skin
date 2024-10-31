<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL . "/public/images/browser-logo.ico" ?>">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- custom style -->
    <link rel="stylesheet" href= "<?php echo ROOT_URL . "/public/css/style.css" ?>" >
    
</head>
<body>


    <!-- header -->
    <?php include __DIR__ .  "/../layouts/header.php"; ?>

    <!-- main content -->
    <main style="min-height: 200vh">
        <!-- SLIDER -->
        <?php include __DIR__ . "/slider.php" ?>

        <!-- TOP PRODUCTs -->
        <h2 class="text-center mt-4">BEST SELLERS</h2>

        <hr class="m-4">

        <!-- NEWEST PRODUCT -->
        <h2 class="text-center">NEWEST PRODUCTS</h2>

    </main>

    <!-- chat -->
     <img id="chat" width=40 src="<?php echo ROOT_URL . "/public/images/chat.png" ?>" alt="">

    <!-- footer -->
    <?php include __DIR__ . "/../layouts/footer.php"; ?>


</body>
</html>
