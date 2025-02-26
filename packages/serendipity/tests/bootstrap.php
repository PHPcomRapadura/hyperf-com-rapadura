<?php

declare(strict_types=1);

use Hyperf\Contract\ApplicationInterface;
use Hyperf\Di\ClassLoader;
use Swoole\Runtime;

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');

putenv('METRIC_DRIVER=noop');
putenv('TRACER_DRIVER=noop');
putenv('ERROR_TRACKER_ADAPTER=noop');
putenv('APP_ENV=test');
putenv('STDOUT_LOG_LEVEL=alert,critical,emergency,error,warning,info');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/constants.php';

error_reporting(E_ALL);
date_default_timezone_set(DEFAULT_TIMEZONE);

/* @noinspection PhpUnhandledExceptionInspection */
Runtime::enableCoroutine();
ClassLoader::init();

(static function () {
    $container = require BASE_PATH . '/config/container.php';
    $container->get(ApplicationInterface::class);
})();

sleep(1);
