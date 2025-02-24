<?php

declare(strict_types=1);

use SleekDB\Query;

use function Hyperf\Support\env;
use function Util\Type\Cast\toFloat;

$connections = [
    'postgres' => [
        'driver' => 'pgsql',
        'read' => [
            'host' => [
                env('PGSQL_READ_DB_HOST', env('PGSQL_DB_HOST')),
            ],
            'username' => env('PGSQL_READ_DB_USERNAME', env('PGSQL_DB_USERNAME', 'root')),
            'password' => env('PGSQL_READ_DB_PASSWORD', env('PGSQL_DB_PASSWORD', 'root')),
            'port' => env('PGSQL_READ_DB_PORT', env('PGSQL_DB_PORT', 5432)),
        ],
        'write' => [
            'host' => [
                env('PGSQL_DB_HOST'),
            ],
            'username' => env('PGSQL_DB_USERNAME', 'root'),
            'password' => env('PGSQL_DB_PASSWORD', 'root'),
            'port' => env('PGSQL_DB_PORT', 5432),
        ],
        'database' => env('PGSQL_DB_DATABASE', 'hyperf-example'),
        'charset' => env('PGSQL_DB_CHARSET', 'utf8'),
        'collation' => env('PGSQL_DB_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('PGSQL_DB_PREFIX', ''),
        'schema' => env('PGSQL_DB_SCHEMA', 'public'),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 30,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => toFloat(env('PGSQL_DB_MAX_IDLE_TIME', 60)),
        ],
        'options' => [
            PDO::ATTR_TIMEOUT => 5,
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
            PDO::ATTR_STRINGIFY_FETCHES => false,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],
    'mysql' => [
        'driver' => 'mysql',
        'read' => [
            'host' => [
                env('MYSQL_READ_DB_HOST', env('MYSQL_DB_HOST')),
            ],
            'username' => env('MYSQL_READ_DB_USERNAME', env('MYSQL_DB_USERNAME', 'root')),
            'password' => env('MYSQL_READ_DB_PASSWORD', env('MYSQL_DB_PASSWORD', 'root')),
            'port' => env('MYSQL_READ_DB_PORT', env('MYSQL_DB_PORT', 3306)),
        ],
        'write' => [
            'host' => [
                env('MYSQL_DB_HOST', 'mysql'),
            ],
            'username' => env('MYSQL_DB_USERNAME', 'root'),
            'password' => env('MYSQL_DB_PASSWORD', 'root'),
            'port' => env('MYSQL_DB_PORT', 3306),
        ],
        'database' => env('MYSQL_DB_DATABASE', 'hyperf-example'),
        'charset' => env('MYSQL_DB_CHARSET', 'utf8'),
        'collation' => env('MYSQL_DB_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('MYSQL_DB_PREFIX', ''),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 30,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => toFloat(env('MYSQL_DB_MAX_IDLE_TIME', 60)),
        ],
        'options' => [
            PDO::ATTR_TIMEOUT => 5,
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
            PDO::ATTR_STRINGIFY_FETCHES => false,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],
    'sleek' => [
        'path' => sprintf('%s/storage/.sleekdb', dirname(__DIR__, 2)),
        'configuration' => [
            'auto_cache' => true,
            'cache_lifetime' => null,
            'timeout' => false,
            'primary_key' => '_id',
            'search' => [
                'min_length' => 2,
                'mode' => 'or',
                'score_key' => 'scoreKey',
                'algorithm' => Query::SEARCH_ALGORITHM['hits'],
            ],
            'folder_permissions' => 0777,
        ],
    ],
];

$connection = env('DB_CONNECTION', 'postgres');
return [
    'default' => $connections[$connection],
    ...$connections,
];
