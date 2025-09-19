<?php
return [
    'groups' => [
        'web' => [
            \Nexacore\Http\Middleware\EncryptCookies::class,
            \Nexacore\Http\Middleware\VerifyCsrfToken::class,
            \Nexacore\Http\Middleware\TrimStrings::class,
            \Nexacore\Http\Middleware\ShareSessionData::class,
        ],
        'api' => [
            \Nexacore\Http\Middleware\ThrottleRequests::class . ':60,1',
            \Nexacore\Http\Middleware\ForceJsonResponse::class,
            \Nexacore\Http\Middleware\CorsMiddleware::class,
        ],
    ],
    
    'route' => [
        'auth' => \Nexacore\Http\Middleware\Authenticate::class,
        'guest' => \Nexacore\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Nexacore\Http\Middleware\ThrottleRequests::class,
        'signed' => \Nexacore\Http\Middleware\ValidateSignature::class,
        'cache.headers' => \Nexacore\Http\Middleware\SetCacheHeaders::class,
        'cors' => \Nexacore\Http\Middleware\CorsMiddleware::class,
    ],
    
    'trusted' => [
        'proxies' => env('TRUSTED_PROXIES', []),
        'headers' => \Slim\Http\Factory\DecoratedResponseFactory::HEADER_X_FORWARDED_ALL,
    ],
];