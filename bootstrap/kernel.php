<?php
// bootstrap/kernel.php

declare(strict_types=1);

use Nexacore\Http\Kernel;

/**
 * NexaPHP HTTP Kernel Bootstrap
 * 
 * This file creates and returns the HTTP kernel instance.
 * The kernel handles the request/response lifecycle and middleware.
 */

return function (Nexacore\Foundation\Application $app) {
    // Create the HTTP kernel instance
    $kernel = new Kernel($app);
    
    // Set the application routes
    $this->loadRoutes($app);
    
    // Add application middleware
    $this->addApplicationMiddleware($app);
    
    return $kernel;
};

/**
 * Load application routes.
 * 
 * @param Nexacore\Foundation\Application $app
 * @return void
 */
function loadRoutes(Nexacore\Foundation\Application $app): void
{
    // Load web routes
    $webRoutesPath = $app->routesPath('web.php');
    if (file_exists($webRoutesPath)) {
        require $webRoutesPath;
    }
    
    // Load API routes
    $apiRoutesPath = $app->routesPath('api.php');
    if (file_exists($apiRoutesPath)) {
        require $apiRoutesPath;
    }
    
    // Load auth routes
    $authRoutesPath = $app->routesPath('auth.php');
    if (file_exists($authRoutesPath)) {
        require $authRoutesPath;
    }
    
    // Load custom routes from config
    $config = $app->get('config');
    $routeFiles = $config['routes']['files'] ?? [];
    
    foreach ($routeFiles as $routeFile) {
        $routePath = $app->routesPath($routeFile);
        if (file_exists($routePath)) {
            require $routePath;
        }
    }
}

/**
 * Add application middleware.
 * 
 * @param Nexacore\Foundation\Application $app
 * @return void
 */
function addApplicationMiddleware(Nexacore\Foundation\Application $app): void
{
    $slim = $app->getSlim();
    $config = $app->get('config');
    
    // Add global middleware from config
    $globalMiddleware = $config['middleware']['global'] ?? [];
    foreach ($globalMiddleware as $middlewareClass) {
        if (class_exists($middlewareClass)) {
            $slim->add($app->getContainer()->get($middlewareClass));
        }
    }
    
    // Add error middleware
    $displayErrorDetails = $config['app']['debug'] ?? false;
    $slim->addErrorMiddleware($displayErrorDetails, true, true);
    
    // Add CORS middleware for API requests
    $slim->add(new \Nexacore\Http\Middleware\CorsMiddleware());
    
    // Add session middleware if session service is available
    if ($app->getContainer()->has('session')) {
        $slim->add(new \Nexacore\Http\Middleware\SessionMiddleware());
    }
}