<?php
// config/database.php

return [
    'default' => env('DB_CONNECTION', 'mysql'),
    
    'connections' => [
        'mysql' => [
            'host' => env('DB_HOST', 'localhost'),
            'database' => env('DB_DATABASE', 'my_app'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
        ],
    ],
];