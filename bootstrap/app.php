<?php
// bootstrap/app.php

declare(strict_types=1);

use Nexacore\Foundation\Nexa;
use Nexacore\Providers\ConfigServiceProvider;
use Nexacore\Providers\AppServiceProvider;
use Nexacore\Providers\DatabaseServiceProvider;
use Nexacore\Providers\AuthServiceProvider;
use Nexacore\Providers\RouteServiceProvider;
use Nexacore\Providers\LogServiceProvider;
use Nexacore\Providers\ConsoleServiceProvider;

/**
 * NexaPHP Application Bootstrap
 */

// Create the NexaPHP application instance
$app = new Nexa(dirname(__DIR__));

// Register configuration service provider first
$app->register(ConfigServiceProvider::class);

// Register logging service provider early for error handling
$app->register(LogServiceProvider::class);

// Get the configuration for service provider registration
$config = $app->get('config');

// Register core framework service providers
$app->register(AppServiceProvider::class);
$app->register(DatabaseServiceProvider::class);

// Register console service provider if running in console
if (php_sapi_name() === 'cli') {
    $app->register(ConsoleServiceProvider::class);
} else {
    // Web-specific providers
    $app->register(AuthServiceProvider::class);
    $app->register(RouteServiceProvider::class);
}

// Register application service providers from config
if (isset($config['app']['providers'])) {
    foreach ($config['app']['providers'] as $provider) {
        if (class_exists($provider)) {
            $app->register($provider);
        }
    }
}

// Set the base path for the application
$app->setBasePath(dirname(__DIR__));

// Return the application instance
return $app;