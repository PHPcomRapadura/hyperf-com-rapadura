#!/usr/bin/env php
<?php

declare(strict_types=1);

if (! empty($argv[1]) && $argv[1] === '--version') {
    require_once __DIR__ . '/../vendor/bin/phpunit';
    exit;
}

require_once __DIR__ . '/../tests/bootstrap.php';
require_once __DIR__ . '/../vendor/bin/co-phpunit';
