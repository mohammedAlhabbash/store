<?php
return [
    [
        'route' => 'categories.index',
        'icon' => 'fas fa-tachometer-alt',
        'name' => 'Dashboard',
        'badge' => '',
        'active' => 'categories.*'
    ],

    [
        'route' => 'categories.index',
        'icon' => 'nav-icon fas fa-th',
        'name' => 'Category',
        'badge' => '',
        'active' => 'categories.*'
    ],
    [
        'route' => 'products.index',
        'icon' => 'nav-icon fas fa-th',
        'name' => 'Product',
        'badge' => 'New',
        'active' => 'products.*'
    ],
    [
        'route' => 'categories.index',
        'icon' => 'nav-icon fas fa-th',
        'name' => 'Order',
        'badge' => '',
        'active' => 'orders.*'
    ]
];
