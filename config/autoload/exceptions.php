<?php

declare(strict_types=1);


use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;
use Serendipity\Infrastructure\Http\Exception\Handler\AppExceptionHandler;
use Serendipity\Infrastructure\Http\Exception\Handler\ValidationExceptionHandler;

return [
    'handler' => [
        'http' => [
            ValidationExceptionHandler::class,
            HttpExceptionHandler::class,
            AppExceptionHandler::class,
        ],
    ],
];
