<?php

declare(strict_types=1);

/**
 * Bootstrap File for NexaPHP Application
 */

// Register the auto-loader
require_once __DIR__ . '/../vendor/autoload.php';

// Create application instance
$app = new NexaCore\Foundation\Application(dirname(__DIR__));

try {
    // Load configuration first
    $app->registerProvider(NexaCore\Providers\ConfigServiceProvider::class);

    // Register core service providers
    $providers = [
        NexaCore\Providers\LogServiceProvider::class,
        NexaCore\Providers\DatabaseServiceProvider::class,
        NexaCore\Providers\SessionServiceProvider::class,
        NexaCore\Providers\ViewServiceProvider::class,
        NexaCore\Providers\AuthServiceProvider::class,
        NexaCore\Providers\RouteServiceProvider::class,
        NexaCore\Providers\MiddlewareServiceProvider::class,
    ];

    foreach ($providers as $provider) {
        $app->registerProvider($provider);
    }

    // Boot the application
    $app->boot();

} catch (Throwable $e) {
    // Handle bootstrap errors
    header('Content-Type: text/plain; charset=utf-8');
    http_response_code(500);
    
    if (($_ENV['APP_DEBUG'] ?? false) || ini_get('display_errors')) {
        echo "Bootstrap Error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
        if ($_ENV['APP_DEBUG'] ?? false) {
            echo "Trace:\n" . $e->getTraceAsString() . "\n";
        }
    } else {
        echo "Application bootstrap failed. Please try again later.";
    }
    
    exit(1);
}

return $app;