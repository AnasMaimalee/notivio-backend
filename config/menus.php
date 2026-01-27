<?php

return [
    'user' => [
        ['label' => 'Dashboard', 'icon' => 'home', 'route' => '/dashboard/user'],
        ['label' => 'My Courses', 'icon' => 'book', 'route' => '/courses'],
        ['label' => 'My Jottings', 'icon' => 'file-text', 'route' => '/jottings'],
        ['label' => 'Shared with Me', 'icon' => 'users', 'route' => '/shared'],
        ['label' => 'Favorites', 'icon' => 'star', 'route' => '/favorites'],
        ['label' => 'Profile', 'icon' => 'user', 'route' => '/profile'],
        ['label' => 'Settings', 'icon' => 'settings', 'route' => '/settings'],
    ],
    'superadmin' => [
        ['label' => 'Dashboard', 'icon' => 'home', 'route' => '/dashboard/superadmin'],
        ['label' => 'Manage Users', 'icon' => 'users', 'route' => '/admin/users'],
        ['label' => 'Manage Courses', 'icon' => 'book', 'route' => '/courses'],
        ['label' => 'Manage Jottings', 'icon' => 'file-text', 'route' => '/jottings'],
        ['label' => 'Shared Notes', 'icon' => 'share-2', 'route' => '/shared'],
        ['label' => 'Analytics', 'icon' => 'bar-chart-2', 'route' => '/admin/analytics'],
        ['label' => 'Settings', 'icon' => 'settings', 'route' => '/settings'],
    ],
];
