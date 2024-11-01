<?php
    $current_section = $data['current_section'] ?? 'order-management';
    $current_subsection = $data['current_subsection'] ?? 'index';
?>

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

    <style>
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            width: 270px;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        #sidebar.collapsed {
            width: 100px;
        }

        #sidebar.collapsed .sidebar-text,
        #sidebar.collapsed .subsection {
            display: none;
        }

        #sidebar.collapsed .brandname {
            display: none !important;
        }

        #sidebar.collapsed .header__web-logo {
            width: 100%;
        }

        #sidebar .admin-section:hover {
            cursor: pointer;
        }

        #content {
            transition: all 0.3s;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .content-body {
            flex-grow: 1;
        }

        .sidebar-link {
            color: #333;
            text-decoration: none;
        }
        .sidebar-link:hover {
            background-color: #f8f9fa;
        }
        .active-section {
            background-color: #e9ecef;
        }
    </style>
    
</head>
<body>

    <div class="wrapper">
        <!-- sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>


        <!-- main content -->
        <div id="content">
            <!-- header -->
            <?php include __DIR__ .  "/header.php"; ?>

            <main class="p-4 content-body">
                <?php
                    // Construct the path to the content file
                    $content_path = __DIR__ . "/content/{$current_section}/{$current_subsection}.php";
                    
                    if (file_exists($content_path)) {
                        include $content_path;
                    } else {
                        echo "<h2>Page not found</h2>";
                    }
                ?>
            </main>
            
            <!-- footer -->
            <?php include __DIR__ . "/../client/layouts/footer.php"; ?>
        </div>
    </div>


    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('content').classList.toggle('expanded');
        });
    </script>

    <script>
        function updateHeaderHeight() {
            const header = document.getElementById('header');
            const heightOffset = document.getElementById('height-offset');

            // Get the top position (y offset) of #height-offset relative to the document
            const offsetTop = heightOffset.getBoundingClientRect().top + window.scrollY;

            // Set the height of #header to match the offset
            header.style.height = `${offsetTop}px`;
        }

        // Call the function on load and on resize to ensure it stays updated
        window.addEventListener('load', updateHeaderHeight);
        window.addEventListener('resize', updateHeaderHeight);
    </script>
</body>
</html>
