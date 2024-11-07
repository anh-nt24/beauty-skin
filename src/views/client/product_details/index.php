<?php

$productCartData = json_encode([
    'id' => $productData['id'],
    'product_name' => $productData['product_name'],
    'image' => '../' . $productData['image'][0],
    'price' => $productData['price']
]);


$isLoggedIn = isset($_COOKIE['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($productData['product_name']); ?></title>
    
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- web icon -->
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL . "/public/images/browser-logo.ico" ?>">
    
    <!-- custom style -->
    <link rel="stylesheet" href= "<?php echo ROOT_URL . "/public/css/style.css" ?>" >
</head>
<body>

    <!-- header -->
    <?php include __DIR__ .  "/../layouts/header.php"; ?>

    <!-- main content -->
     <?php include __DIR__ . "/content.php" ?>

    <!-- footer -->
    <?php include __DIR__ . "/../layouts/footer.php"; ?>

    <script>        
        let currentImageIndex = 0;
        const imagesCount = <?php echo count($productData['image']); ?>;
        const itemsPerView = 5;
        let currentSlideOffset = 0;

        function updateMainImage(thumbnailElement, index) {
            document.getElementById('mainImage').src = thumbnailElement.src;
            
            document.querySelectorAll('.thumbnail-img').forEach(img => {
                img.classList.remove('active');
            });
            thumbnailElement.classList.add('active');
            
            currentImageIndex = index;
            
            const slideIndex = Math.floor(index / itemsPerView);
            if (slideIndex !== currentSlideOffset) {
                currentSlideOffset = slideIndex;
                updateSliderPosition();
            }
        }

        function navigateImages(direction) {
            const maxOffset = Math.ceil(imagesCount / itemsPerView) - 1;
            const newOffset = currentSlideOffset + direction;
            
            if (newOffset >= 0 && newOffset <= maxOffset) {
                currentSlideOffset = newOffset;
                updateSliderPosition();
            }
        }

        function updateSliderPosition() {
            const slider = document.getElementById('thumbnailSlider');
            const slideWidth = 100 / itemsPerView;
            slider.style.transform = `translateX(-${currentSlideOffset * (slideWidth * itemsPerView)}%)`;
            
            // navigation buttons
            const prevButton = document.querySelector('.nav-button.prev');
            const nextButton = document.querySelector('.nav-button.next');
            
            if (prevButton && nextButton) {
                prevButton.disabled = currentSlideOffset === 0;
                nextButton.disabled = currentSlideOffset >= Math.ceil(imagesCount / itemsPerView) - 1;
                
                prevButton.classList.toggle('disabled', currentSlideOffset === 0);
                nextButton.classList.toggle('disabled', currentSlideOffset >= Math.ceil(imagesCount / itemsPerView) - 1);
            }
        }

        // initialize slider position
        document.addEventListener('DOMContentLoaded', function() {
            updateSliderPosition();
        });
    </script>
    
    <script>
        const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        let pendingAction = null;

        function updateQuantity(change) {
            if (!isLoggedIn) return;
            
            const quantityInput = document.getElementById('quantity');
            const maxStock = <?php echo $productData['stock']; ?>;
            let newValue = parseInt(quantityInput.value) + change;
            
            if (newValue >= 1 && newValue <= maxStock) {
                quantityInput.value = newValue;
            }
        }

        function handleLogin(event) {
            event.preventDefault();
            loginModal.hide();
            if (pendingAction) {
                handleAction(pendingAction);
                pendingAction = null;
            }
        }
    </script>


</body>
</html>