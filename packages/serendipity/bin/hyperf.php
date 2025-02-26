#!/usr/bin/env php
<?php

declare(strict_types=1);

use Hyperf\Contract\ApplicationInterface;
use Hyperf\Di\ClassLoader;
use Psr\Container\ContainerInterface;

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
ini_set('memory_limit', '512M');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/constants.php';

error_reporting(E_ALL);
date_default_timezone_set(DEFAULT_TIMEZONE);

(static function () {
    ClassLoader::init();
    /** @var ContainerInterface $container */
    $container = require BASE_PATH . '/config/container.php';

    $application = $container->get(ApplicationInterface::class);
    $application->run();
})();
