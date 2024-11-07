<?php

require_once __DIR__ . "/../models/Product.php";

class ProductController {
    private $productModel;

    public function __construct($database) {
        $this->productModel = new Product($database);
    }

    public function addProduct($postData, $fileData) {
        if (isset($postData) && isset($fileData)) {
            $productName = $postData['productName'];
            $category = $postData['category'];
            $price = $postData['price'];
            $stock = $postData['stock'];
            $description = $postData['description'];
            
            // upload images
            $imagePaths = [];
            if (!empty($fileData['productImage']['name'][0])) {
                $uploadDir = __DIR__ . "/../../upload/";

                foreach ($fileData['productImage']['tmp_name'] as $index => $tmpName) {
                    $originalName = $fileData['productImage']['name'][$index];
                    $fileExt = pathinfo($originalName, PATHINFO_EXTENSION);
                    
                    // generate a unique name
                    $uniqueName = uniqid(rand(), true) . '.' . $fileExt;
                    $targetPath = $uploadDir . $uniqueName;
                    
                    // move
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $imagePaths[] = "upload/" . $uniqueName;
                    }
                }
            }
            $images = implode(";", $imagePaths);


            // save
            $success = $this->productModel->save([
                'product_name' => $productName,
                'description' => $description,
                'price' => $price,
                'category' => CATEGORIES[$category],
                'stock' => $stock,
                'image' => $images
            ]);
            if ($success) {
                header('Location:' . ROOT_URL . '/admin/product-management/index');
                exit;
            } else {
                echo '<script>
                    alert("Error adding data. Please try again.");
                    window.location.href = window.location.href;
                </script>';
            }
        } else {
            exit;
        }
    }

    public function getAllProducts() {
        $productData = $this->productModel->findAll();
        foreach ($productData as &$product) {
            $images = explode(';', $product['image']);
            $product['image'] = $images;
        }
        return $productData;
    }

    public function getNewestProducts($page=1) {
        $productsPerPage = 4;
        $offset = ($page - 1) * $productsPerPage;

        $products = $this->productModel->findNewest($productsPerPage, $offset);

        foreach ($products as &$product) {
            $images = explode(';', $product['image']);
            $product['image'] = $images;
        }

        $hasMore = count($products) === $productsPerPage;
        header('Content-Type: application/json');
        echo json_encode(['products' => $products, 'hasMore' => $hasMore]);
    }

    public function getBestProducts($page=1) {
        $productsPerPage = 4;
        $offset = ($page - 1) * $productsPerPage;

        $products = $this->productModel->findBestSeller($productsPerPage, $offset);

        foreach ($products as &$product) {
            $images = explode(';', $product['image']);
            $product['image'] = $images;
        }

        $hasMore = count($products) === $productsPerPage;
        header('Content-Type: application/json');
        echo json_encode(['products' => $products, 'hasMore' => $hasMore]);
    }

    public function getProductDetails($productId) {
        return $this->productModel->findProductDetailsById($productId);
    }
}