<?php
// public/index.php

declare(strict_types=1);

use Nexacore\Foundation\Nexa;
use Nexacore\Http\Kernel;
use Slim\Factory\ServerRequestCreatorFactory;

/**
 * NexaPHP Front Controller
 * 
 * This is the main entry point for all web requests to your application.
 * It bootstraps the framework and handles the request/response lifecycle.
 */

// Register the Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// Create the application instance
$app = require __DIR__ . '/../bootstrap/app.php';

// Create the HTTP kernel
$kernel = require __DIR__ . '/../bootstrap/kernel.php';
$kernel = $kernel($app);

// Create PSR-7 request from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Add the request to the container
$app->getContainer()->set('request', $request);

// Start the session if session middleware is available
if ($app->getContainer()->has('session')) {
    session_start();
}

// Handle the request through the HTTP kernel
$response = $kernel->handle($request);

// Add security headers
$response = $response
    ->withHeader('X-Frame-Options', 'SAMEORIGIN')
    ->withHeader('X-Content-Type-Options', 'nosniff')
    ->withHeader('X-XSS-Protection', '1; mode=block')
    ->withHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
    ->withHeader('X-Powered-By', 'NexaPHP');

// Send the response
(new \Slim\Http\Response($response))->send();

// Terminate the request (cleanup, logging, etc.)
$kernel->terminate($request, $response);