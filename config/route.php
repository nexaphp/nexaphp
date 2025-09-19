<?php
// config/route.php

return [
    'cache' => env('ROUTE_CACHE', false),
    'files' => [
        'web.php',
        'api.php',
        'auth.php',
        'console.php', // For console commands
    ],
    
    'patterns' => [
        'id' => '[0-9]+',
        'slug' => '[a-z0-9-]+',
        'uuid' => '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}',
        'year' => '\d{4}',
        'month' => '\d{2}',
        'day' => '\d{2}',
    ],
    
    'middleware_groups' => [
        'web' => [
            'middleware.encrypt_cookies',
            'middleware.verify_csrf',
            'middleware.share_session',
        ],
        'api' => [
            'middleware.throttle:60,1',
            'middleware.force_json',
            'middleware.cors',
        ],
        'auth' => [
            'middleware.auth',
        ],
        'guest' => [
            'middleware.guest',
        ],
        'admin' => [
            'middleware.auth',
            'middleware.admin',
        ],
    ],
    
    'route_model_binding' => [
        'enabled' => true,
        'patterns' => [
            'user' => \App\Models\User::class,
            'post' => \App\Models\Post::class,
            'category' => \App\Models\Category::class,
        ],
    ],
];