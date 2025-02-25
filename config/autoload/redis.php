<?php

declare(strict_types=1);

use function Hyperf\Support\env;
use function Backbone\Type\Cast\toInt;
use function Backbone\Type\Cast\toFloat;

return [
    'default' => [
        'host' => env('REDIS_HOST', 'localhost'),
        'auth' => env('REDIS_AUTH', null),
        'port' => toInt(env('REDIS_PORT', 6379)),
        'db' => toInt(env('REDIS_DB', 0)),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => toFloat(env('REDIS_MAX_IDLE_TIME', 60)),
        ],
    ],
];
