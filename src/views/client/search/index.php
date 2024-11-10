<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL . "/public/images/browser-logo.ico" ?>">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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

    <div class="container-fluid">
        <div class="row py-4">
            <div class="col-lg-3 filter-panel">
                <!-- filter -->
                <?php include 'filterpanel.php'; ?>
            </div>
            <div class="col-lg-9">
                <!-- main-content -->
                <?php include 'content.php'; ?>
            </div>
        </div>
    </div>


    <script>
        document.querySelectorAll('.filter-checkbox, .price-range').forEach(filter => {
            filter.addEventListener('change', () => {
                document.getElementById('filterForm').submit();
            });
        });

        document.querySelector('input[name="query"]').value = '<?php echo $searchQuery?>';
    </script>

</body>
</html>