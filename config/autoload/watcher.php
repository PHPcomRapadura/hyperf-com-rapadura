<?php

/** @noinspection DevelopmentDependenciesUsageInspection */

declare(strict_types=1);

use Hyperf\Watcher\Driver\ScanFileDriver;

return [
    'driver' => ScanFileDriver::class,
    'bin' => PHP_BINARY,
    'watch' => [
        'dir' => ['app', 'config'],
        'file' => ['.env'],
        'scan_interval' => 2000,
    ],
    'ext' => ['.php', '.env'],
    'command' => 'vendor/devitools/hyperf-watcher/watcher.php start',
];
