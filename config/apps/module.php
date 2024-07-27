<?php
return [
    'module' => [
        [
            'title' => 'Người Dùng',
            'icon' => '	fas fa-users',
            'id' => 'user',
            'subModule' => [
                [
                    'title' => 'Nhóm Thành Viên',
                    'route' => "admin/user/catalogue/index"
                ],
                [
                    'title' => 'Thành Viên',
                    'route' => "admin/user/index"
                ],

            ]
        ],
        [
            'title' => 'Bài Viết',
            'icon' => 'fas fa-edit',
            'id' => 'posts',
            'subModule' => [
                [
                    'title' => 'Danh mục Bài viết',
                    'route' => 'admin/posts/category/index'
                ],
                [
                    'title' => 'Bài viết',
                    'route' => 'admin/posts/index'
                ],

            ]
        ],
        [
            'title' => 'Sản Phẩm',
            'icon' => 'fas fa-shopping-cart',
            'id' => 'product',
            'subModule' => [
                [
                    'title' => 'Danh mục Sản phẩm',
                    'route' => 'admin/product/category/index'
                ],
                [
                    'title' => 'Sản phẩm',
                    'route' => 'admin/product/index'
                ],
            ]
        ],
        [
            'title' => 'Mã giảm',
            'icon' => 'fas fa-gift',
            'id' => 'coupon',
            'subModule' => [
                [
                    'title' => 'Mã Giảm Giá',
                    'route' => 'admin/coupon/index'
                ],
            ]
        ],
        [
            'title' => 'Thuộc Tính Sản Phẩm',
            'icon' => 'fas fa-tags',
            'id' => 'attribute',
            'subModule' => [
                [
                    'title' => 'Nhóm Thuộc Tính',
                    'route' => 'admin/attribute/catalogue/index'
                ],
                [
                    'title' => 'Thuộc Tính',
                    'route' => 'admin/attribute/index'
                ],

            ]
        ],
        [
            'title' => 'Đơn Hàng',
            'icon' => 'fas fa-clipboard',
            'id' => 'order',
            'subModule' => [
                [
                    'title' => 'Đơn hàng',
                    'route' => 'admin/order/index'
                ],
            ]
        ],
        [
            'title' => 'Vận Chuyển',
            'icon' => 'fas fa-truck',
            'id' => 'feeship',
            'subModule' => [
                [
                    'title' => 'Phí Vận Chuyển',
                    'route' => 'admin/feeship/index'
                ],
            ]
        ],
        [
            'title' => 'Giao diện',
            'icon' => 'fas fa-tools',
            'id' => 'interface',
            'subModule' => [
                [
                    'title' => 'Menu',
                    'route' => "admin/interface/menu/index"
                ],
                [
                    'title' => 'Slider',
                    'route' => "admin/interface/slider/index"
                ]
            ]
        ],
    ]
]
?>
