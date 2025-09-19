<?php
// config/app.php

return [
    'name' => env('APP_NAME', 'My NexaPHP App'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost:8000'),
    
    'providers' => [
        /*
         * NexaPHP Framework Service Providers...
         */
        Nexacore\Providers\ConfigServiceProvider::class,
        Nexacore\Providers\AppServiceProvider::class,
        Nexacore\Providers\DatabaseServiceProvider::class,
        Nexacore\Providers\RouteServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
    ],
];