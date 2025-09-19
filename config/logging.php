<?php
// config/logging.php

use Monolog\Logger;

return [
    'default' => 'nexaphp',
    'level' => env('LOG_LEVEL', Logger::DEBUG),
    'max_files' => env('LOG_MAX_FILES', 7),
    'console' => env('LOG_CONSOLE', false),
    
    'channels' => [
        'nexaphp' => [
            'path' => 'logs/nexaphp.log',
            'level' => env('LOG_LEVEL', Logger::DEBUG),
            'max_files' => 7,
        ],
        'app' => [
            'path' => 'logs/app.log',
            'level' => Logger::INFO,
            'max_files' => 7,
        ],
        'error' => [
            'path' => 'logs/error.log',
            'level' => Logger::ERROR,
            'max_files' => 14,
        ],
        'security' => [
            'path' => 'logs/security.log',
            'level' => Logger::WARNING,
            'max_files' => 30,
        ],
        'database' => [
            'path' => 'logs/database.log',
            'level' => Logger::INFO,
            'max_files' => 7,
        ],
        'queue' => [
            'path' => 'logs/queue.log',
            'level' => Logger::INFO,
            'max_files' => 7,
        ],
    ],
    
    'handlers' => [
        // Example: Slack notifications for critical errors
        // [
        //     'type' => 'slack',
        //     'webhook_url' => env('SLACK_WEBHOOK_URL'),
        //     'channel' => '#errors',
        //     'level' => Logger::CRITICAL,
        // ],
    ],
];