<?php
declare(strict_types=1);

/**
 * Front Controller for NexaPHP Application
 * 
 * This is the main entry point for web requests. It bootstraps the application,
 * handles the incoming HTTP request, and sends the response.
 * 
 * @package NexaPHP
 */

// Start output buffering
ob_start();

// Measure application start time
$startTime = microtime(true);

try {
    // Bootstrap the application
    $app = require __DIR__ . '/../bootstrap/app.php';

    // Create HTTP kernel
    $kernel = $app->make(NexaCore\Http\Kernel::class);

    // Create request from globals
    $request = NexaCore\Http\Request::capture();

    // Handle the request and get response
    $response = $kernel->handle($request);

    // Send the response
    $kernel->sendResponse($response);

    // Terminate the application
    $kernel->terminate($request, $response);

} catch (Throwable $e) {
    // Handle any uncaught exceptions
    http_response_code(500);
    
    if (isset($app) && $app->isDebug()) {
        echo "<h1>Application Error</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "</p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    } else {
        echo "An error occurred. Please try again later.";
    }
    
    // Log the error if application is available
    if (isset($app) && $app->has('log')) {
        $app->make('log')->error('Uncaught Exception: ' . $e->getMessage(), [
            'exception' => $e,
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
    }
    
    exit(1);
} finally {
    // Clean output buffer
    if (ob_get_length()) {
        ob_end_clean();
    }
    
    // Log performance metrics (optional)
    if (isset($app) && $app->has('log') && $app->isDebug()) {
        $endTime = microtime(true);
        $executionTime = round(($endTime - $startTime) * 1000, 2);
        $memoryUsage = round(memory_get_peak_usage(true) / 1024 / 1024, 2);
        
        $app->make('log')->debug('Request processed', [
            'execution_time_ms' => $executionTime,
            'memory_usage_mb' => $memoryUsage,
            'url' => $_SERVER['REQUEST_URI'] ?? '',
            'method' => $_SERVER['REQUEST_METHOD'] ?? '',
        ]);
    }
}