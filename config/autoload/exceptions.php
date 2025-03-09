<?php

declare(strict_types=1);


use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;
use Serendipity\Hyperf\Exception\AppExceptionHandler;
use Serendipity\Hyperf\Exception\ValidationExceptionHandler;

return [
    'handler' => [
        'http' => [
            ValidationExceptionHandler::class,
            HttpExceptionHandler::class,
            AppExceptionHandler::class,
        ],
    ],
];
