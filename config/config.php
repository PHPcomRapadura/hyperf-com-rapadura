<?php

declare(strict_types=1);

use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;

use function Hyperf\Support\env;
use function Serendipity\Type\Cast\stringify;

$logLevel = stringify(env('STDOUT_LOG_LEVEL'));

return [
    'app_name' => env('APP_NAME', 'template_name'),
    'app_env' => env('APP_ENV', 'dev'),
    'app_release' => env('APP_RELEASE', '1.0.0'),
    'scan_cacheable' => env('SCAN_CACHEABLE', false),
    StdoutLoggerInterface::class => [
        'log_level' => $logLevel
            ? explode(',', $logLevel)
            : [
                LogLevel::ALERT,
                LogLevel::CRITICAL,
                LogLevel::EMERGENCY,
                LogLevel::ERROR,
                LogLevel::WARNING,
                LogLevel::NOTICE,
                LogLevel::INFO,
                LogLevel::DEBUG,
            ],
    ],
];
