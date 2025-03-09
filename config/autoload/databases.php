<?php

declare(strict_types=1);

use SleekDB\Query;

use function Hyperf\Support\env;
use function Serendipity\Type\Cast\boolify;
use function Serendipity\Type\Cast\floatify;
use function Serendipity\Type\Cast\stringify;

$connections = [
    'postgres' => [
        'driver' => 'pgsql',
        'host' => env('DB_POSTGRES_HOST', 'postgres'),
        'username' => env('DB_POSTGRES_USERNAME', 'username'),
        'password' => env('DB_POSTGRES_PASSWORD', 'password'),
        'port' => env('DB_POSTGRES_PORT', 5432),
        'read' => [
            'host' => env('DB_POSTGRES_HOST', 'postgres'),
            'username' => env('DB_POSTGRES_USERNAME', 'username'),
            'password' => env('DB_POSTGRES_PASSWORD', 'password'),
            'port' => env('DB_POSTGRES_PORT', 5432),
        ],
        'write' => [
            'host' => env('DB_PGSQL_READ_HOST', env('DB_POSTGRES_HOST', 'postgres')),
            'username' => env('DB_PGSQL_READ_USERNAME', env('DB_POSTGRES_USERNAME', 'username')),
            'password' => env('DB_PGSQL_READ_PASSWORD', env('DB_POSTGRES_PASSWORD', 'password')),
            'port' => env('DB_PGSQL_READ_PORT', env('DB_POSTGRES_PORT', 5432)),
        ],
        'database' => env('DB_POSTGRES_NAME', 'database'),
        'charset' => env('DB_POSTGRES_CHARSET', 'utf8'),
        'collation' => env('DB_POSTGRES_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('DB_POSTGRES_PREFIX', ''),
        'schema' => env('DB_POSTGRES_SCHEMA', 'public'),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 30,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => floatify(env('DB_POSTGRES_MAX_IDLE_TIME', 60)),
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
        'host' => env('DB_MYSQL_HOST', 'mysql'),
        'username' => env('DB_MYSQL_USERNAME', 'mysql'),
        'password' => env('DB_MYSQL_PASSWORD', 'root'),
        'port' => env('DB_MYSQL_PORT', 3306),
        'read' => [
            'host' => env('DB_MYSQL_HOST', 'mysql'),
            'username' => env('DB_MYSQL_USERNAME', 'mysql'),
            'password' => env('DB_MYSQL_PASSWORD', 'root'),
            'port' => env('DB_MYSQL_PORT', 3306),
        ],
        'write' => [
            'host' => env('DB_MYSQL_READ_HOST', env('DB_MYSQL_HOST', 'mysql')),
            'username' => env('DB_MYSQL_READ_USERNAME', env('DB_MYSQL_USERNAME', 'username')),
            'password' => env('DB_MYSQL_READ_PASSWORD', env('DB_MYSQL_PASSWORD', 'password')),
            'port' => env('DB_MYSQL_READ_PORT', env('DB_MYSQL_PORT', 3306)),
        ],
        'database' => env('DB_MYSQL__NAME', 'database'),
        'charset' => env('DB_MYSQL_CHARSET', 'utf8'),
        'collation' => env('DB_MYSQL_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('DB_MYSQL_PREFIX', ''),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 30,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => floatify(env('DB_MYSQL_MAX_IDLE_TIME', 60)),
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
        'path' => sprintf('%s/%s', dirname(__DIR__, 2), stringify(env('DB_SLEEK_PATH', 'storage/.sleekdb'))),
        'configuration' => [
            'auto_cache' => boolify(env('DB_SLEEK_AUTO_CACHE', true)),
            'cache_lifetime' => env('DB_SLEEK_CACHE_LIFETIME'),
            'timeout' => boolify(env('DB_SLEEK_TIMEOUT', false)),
            'primary_key' => env('DB_SLEEK_PRIMARY_KEY', '_id'),
            'search' => [
                'min_length' => 2,
                'mode' => 'or',
                'score_key' => 'scoreKey',
                'algorithm' => Query::SEARCH_ALGORITHM['hits'],
            ],
            'folder_permissions' => env('DB_SLEEK_FOLDER_PERMISSIONS', 0644),
        ],
    ],
];

$default = env('DB_CONNECTION', 'postgres');

return [
    'default' => $connections[$default] ?? $connections['postgres'],
    ...$connections,
];
