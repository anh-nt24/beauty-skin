<?php

    define('ROOT_URL', '/beauty-skin');
    define('UPLOAD_DIR', __DIR__ . '/uploads');
    
    define('SLIDER_IMAGES', [
        ROOT_URL . '/public/images/slider1.png',
        ROOT_URL . '/public/images/slider2.png',
        ROOT_URL . '/public/images/slider3.png',
        ROOT_URL . '/public/images/slider4.png',
    ]);

    define('ROLE_ADMIN', 'admin');
    define('ROLE_CLIENT', 'client');
    
    define('STATE_0', 'Cancel');
    define('STATE_1', 'Pending');
    define('STATE_2', 'Ready');
    define('STATE_3', 'Delivering');
    define('STATE_4', 'Completed');
    define('STATE_5', 'Return');
    define('STATE_5_0', 'NotRefund');
    define('STATE_5_1', 'Refund');

    define('CATEGORIES', [
        'Lipstick',
        'Makeup Remover',
        'Face Mask',
        'Toner',
        'Whitening',
        'Peeling'
    ]);

    
    define('PRICE_LEVELS', [
        1 => ['id' => 1, 'name' => 'Under $20', 'min' => 0, 'max' => 20],
        2 => ['id' => 2, 'name' => '$20 - $50', 'min' => 20, 'max' => 50],
        3 => ['id' => 3, 'name' => '$50 - $100', 'min' => 50, 'max' => 100],
        4 => ['id' => 4, 'name' => 'Over $100', 'min' => 100, 'max' => null]
    ]);


    define('ADMIN_PANEL', [
        "order-management" => [
            "icon" => "bi bi-cart",
            "subsections" => [
                [
                    "name" => "All Orders",
                    "url" => "index"
                ],
                [
                    "name" => "Return/Refund",
                    "url" => "return"
                ],
                [
                    "name" => "Shipping Service",
                    "url" => "shipping"
                ]
            ],
        ],

        "product-management" => [
            "icon" => "bi bi-box-seam",
            "subsections" => [
                [
                    "name" => "All Products",
                    "url" => "index"
                ],
                [
                    "name" => "Add Product",
                    "url" => "add"
                ],
                [
                    "name" => "View Product Details",
                    "url" => "view"
                ]
            ],
        ],

        "customer-management" => [
            "icon" => "bi bi-people-fill"
        ],

        "customer-service" => [
            "icon" => "bi bi-chat-heart",
            "subsections" => [
                [
                    "name" => "FaQ",
                    "url" => "index"
                ],
                [
                    "name" => "Product Ratings",
                    "url" => "rating"
                ]
            ],
        ],

        "report" => [
            "icon" => "bi bi-activity"
        ],
    ]);
?>