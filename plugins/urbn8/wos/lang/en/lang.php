<?php return [
    'plugin' => [
        'name' => 'wos',
        'description' => '',
        'created_at' => 'Created Time',
        'updated_at' => 'Updated Time',
        'title' => 'WOS',
        'common' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'desc' => 'Description',
            'status' => 'Status',
            'status_options' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
        ],
    ],
    'event' => [
        'category' => [
            'permissions' => [
                'access' => 'Access event categories',
            ],
            'title' => 'Event categories',
        ],
    ],
    'biz' => [
        'type' => [
            'title' => 'Business types',
        ],
        'category' => [
            'title' => 'Business Categories',
        ],
    ],
    'lang' => [
        'biz' => [
            'type' => [
                'permissions' => [
                    'access' => 'Access business types',
                ],
            ],
            'category' => [
                'permissions' => [
                    'access' => 'Access Business Categories',
                ],
            ],
        ],
        'businesses' => [
            'permissions' => [
                'access' => 'Access Businesses',
            ],
        ],
    ],
    'common' => [
        'modeldataform' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'desc' => 'Description',
            'status' => 'Status',
            'status_options' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
        ],
    ],
    'businesses' => [
        'menu' => [
            'name' => 'Businesses',
        ],
        'tabs' => [
            'users' => [
                'name' => 'Users',
            ],
        ],
    ],
    'business_branches' => [
        'modeldataform' => [
            'business' => 'Business',
            'business_comment' => 'This branch belongs to the selected business above',
        ],
        'name' => 'Business Branches',
    ],
];