<?php

return [
    [
        'name' => 'Dashboard Management',
        'permissions' => [
            'view-dashboard',
            'view-site-settings',
        ]
    ],
    [
        'name' => 'Admin Management',
        'permissions' => [
            'view-admin',
            'create-admin',
            'update-admin',
            'delete-admin',
        ]
    ],
    [
        'name' => 'Role Management',
        'permissions' => [
            'view-role',
            'create-role',
            'update-role',
            'delete-role',
            'assign-permissions',
        ]
    ],
    [
        'name' => 'User Management',
        'permissions' => [
            'view-user',
            'create-user',
            'update-user',
            'delete-user',
        ]
    ],
];