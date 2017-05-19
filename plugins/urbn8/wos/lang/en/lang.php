<?php return [
    'plugin' => [
        'name' => 'wos',
        'description' => '',
        'created_at' => 'Created Time',
        'updated_at' => 'Updated Time',
        'title' => 'WOS',
    ],
    'event' => [
        'modeldataform' => [
            'categories' => 'Categories',
            'date' => 'Date',
            'time' => 'Time',
            'length' => 'Length',
            'pattern' => 'Pattern',
            'tabs' => [
                'contents' => 'Contents',
                'images' => 'Images',
                'location' => 'Location',
            ],
            'lat_long' => 'Latitude - Longtitude',
            'address' => 'Address',
            'thumbnail' => 'Thumbnail',
        ],
        'category' => [
            'permissions' => [
                'access' => 'Access event categories',
            ],
            'title' => 'Event categories',
            'modeldataform' => [
                'parent' => 'Parent',
            ],
        ],
        'permissions' => [
            'access' => 'Access events',
        ],
        'menu' => [
            'name' => 'Events',
        ],
    ],
    'lang' => [
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
            'excerpt' => 'Excerpt',
        ],
    ],
    'organiser' => [
        'permissions' => [
            'access' => 'Manage Organisers',
        ],
        'menu' => [
            'title' => 'Organisers',
        ],
    ],
];