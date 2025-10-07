<?php

use Nexacore\Http\Kernel;

require __DIR__ . '/../bootstrap/app.php';

/**
 * ------------------------------------------------------------
 * Handle The HTTP Request
 * ------------------------------------------------------------
 *
 * This is the front controller for NexaPHP. All requests
 * are directed through this file and handled by the Kernel.
 *
 */

/** @var \Nexacore\Foundation\Application $app */
$app = require __DIR__ . '/../bootstrap/app.php';

// Load routes
$routesPath = $app->getPaths()['routes'];
if (file_exists($routesPath . '/web.php')) {
    require $routesPath . '/web.php';
}
if (file_exists($routesPath . '/api.php')) {
    require $routesPath . '/api.php';
}

// Initialize Kernel and handle the HTTP request
$kernel = new Kernel($app);
$kernel->handle();
