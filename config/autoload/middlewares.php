<?php

declare(strict_types=1);

use App\Infrastructure\Support\Http\Middleware\AppMiddleware;
use Hyperf\HttpServer\CoreMiddleware;
use Hyperf\Validation\Middleware\ValidationMiddleware;

return [
    'http' => [
        CoreMiddleware::class => AppMiddleware::class,
        ValidationMiddleware::class,
    ],
];
