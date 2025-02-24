<?php

declare(strict_types=1);

use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

use function Hyperf\Support\env;

$formatter = [
    'class' => JsonFormatter::class,
    'constructor' => [],
];
if (env('APP_ENV', 'dev') === 'dev') {
    $formatter = [
        'class' => LineFormatter::class,
        'constructor' => [
            'format' => "||%datetime%||%channel%||%level_name%||%message%||%context%||%extra%\n",
            'allowInlineLineBreaks' => true,
            'includeStacktraces' => true,
        ],
    ];
}

return [
    'default' => [
        'handler' => [
            'class' => StreamHandler::class,
            'constructor' => [
                'stream' => 'php://stdout',
                'level' => Level::Info,
            ],
        ],
        'formatter' => $formatter,
    ],

    'gcloud' => [
        'batch' => false,
    ],
];
