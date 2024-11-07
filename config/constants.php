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
        'Sleeping Mask',
        'Toner',
        'Whitening',
        'Peeling'
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
                    "name" => "Chat",
                    "url" => "chat"
                ],
                [
                    "name" => "Rating",
                    "url" => "rating"
                ]
            ],
        ],

        "report" => [
            "icon" => "bi bi-activity",
            "subsections" => [
                [
                    "name" => "Revenue",
                    "url" => "revenue"
                ],
                [
                    "name" => "Performance",
                    "url" => "performance"
                ]
            ],
        ],
    ]);
?>