<?php

return [
    'backend' => [
        'dashboard' => [
            'name'   => 'Dashboard',
            'icon'   => 'nav-icon fas fa-tachometer-alt',
            'url'    => '/dashboard*',
            'route'  => 'dashboard',
            'permission' => 'view-dashboard',
        ],
        'admin management' => [
            'name'   => 'Admin Management',
            'icon'   => 'nav-icon fas fa-users',
            'url'    => ['/admins*', '/roles*'],
            'permission' => ['view-admin', 'view-role'],

            'child-view' => [
                'admin' => [
                    'name'   => 'Admins',
                    'icon'   => 'nav-icon fas fa-user',
                    'url'    => '/admins*',
                    'route'  => 'admins.index',
                    'permission' => 'view-admin',
                ],
                'role' => [
                    'name'   => 'Roles',
                    'icon'   => 'nav-icon fas fa-user-tag',
                    'url'    => '/roles*',
                    'route'  => 'roles.index',
                    'permission' => 'view-role',
                ],
            ]
        ],
    ]
];