<?php

use Nexacore\Foundation\Application;

require __DIR__ . '/../vendor/autoload.php';

/**
 * ------------------------------------------------------------
 * Create The Application
 * ------------------------------------------------------------
 *
 * This script bootstraps the NexaPHP application. It loads
 * environment variables, config files, and builds the DI
 * container and Slim app.
 *
 */

$basePath = dirname(__DIR__);

/** @var Application $app */
$app = new Application($basePath);

return $app;
