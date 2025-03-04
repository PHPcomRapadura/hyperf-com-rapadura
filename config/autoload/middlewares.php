<?php

declare(strict_types=1);

use Hyperf\HttpServer\CoreMiddleware;
use Hyperf\Validation\Middleware\ValidationMiddleware;
use Serendipity\Infrastructure\Http\Middleware\AppMiddleware;

return [
    'http' => [
        ValidationMiddleware::class,
        CoreMiddleware::class => AppMiddleware::class,
    ],
];
