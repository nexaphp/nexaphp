<?php

declare(strict_types=1);

/**
 * Console Bootstrap File for NexaPHP Application
 * 
 * This file bootstraps the console application for CLI commands.
 * 
 * @package NexaPHP
 */

// Register the auto-loader
require_once __DIR__ . '/../vendor/autoload.php';

// Create application instance
$app = NexaCore\Foundation\Application::getInstance(dirname(__DIR__));

// Load application configuration
$app->registerProvider(NexaCore\Providers\ConfigServiceProvider::class);

// Register console-specific service providers
$consoleProviders = [
    NexaCore\Providers\LogServiceProvider::class,
    NexaCore\Providers\DatabaseServiceProvider::class,
    NexaCore\Providers\FilesystemServiceProvider::class,
    NexaCore\Providers\ConsoleServiceProvider::class,
    App\Providers\AppServiceProvider::class,
];

foreach ($consoleProviders as $provider) {
    $app->registerProvider($provider);
}

// Set console exception handler
set_exception_handler(function (Throwable $e) use ($app) {
    if ($app->has('log')) {
        $app->make('log')->error($e->getMessage(), [
            'exception' => $e,
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
    }

    echo "Error: " . $e->getMessage() . PHP_EOL;
    echo "File: " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
    
    if ($app->isDebug()) {
        echo "Stack trace:" . PHP_EOL;
        echo $e->getTraceAsString() . PHP_EOL;
    }
    
    exit(1);
});

// Return the application instance
return $app;