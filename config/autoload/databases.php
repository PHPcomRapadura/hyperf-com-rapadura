<?php

declare(strict_types=1);

use SleekDB\Query;

use function Hyperf\Support\env;
use function Backbone\Type\Cast\toFloat;

return [
    'postgres' => [
        'driver' => 'pgsql',
        'host' => env('POSTGRES_DB_HOST', 'postgres'),
        'username' => env('POSTGRES_DB_USERNAME', 'postgres'),
        'password' => env('POSTGRES_DB_PASSWORD', 'root'),
        'port' => env('POSTGRES_DB_PORT', 5432),
        'read' => [
            'host' => env('POSTGRES_DB_HOST', 'postgres'),
            'username' => env('POSTGRES_DB_USERNAME', 'postgres'),
            'password' => env('POSTGRES_DB_PASSWORD', 'root'),
            'port' => env('POSTGRES_DB_PORT', 5432),
        ],
        'write' => [
            'host' => env('PGSQL_READ_DB_HOST', env('POSTGRES_DB_HOST', 'postgres')),
            'username' => env('PGSQL_READ_DB_USERNAME', env('POSTGRES_DB_USERNAME', 'postgres')),
            'password' => env('PGSQL_READ_DB_PASSWORD', env('POSTGRES_DB_PASSWORD', 'root')),
            'port' => env('PGSQL_READ_DB_PORT', env('POSTGRES_DB_PORT', 5432)),
        ],
        'database' => env('POSTGRES_DB_NAME', 'database'),
        'charset' => env('POSTGRES_DB_CHARSET', 'utf8'),
        'collation' => env('POSTGRES_DB_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('POSTGRES_DB_PREFIX', ''),
        'schema' => env('POSTGRES_DB_SCHEMA', 'public'),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 30,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => toFloat(env('POSTGRES_DB_MAX_IDLE_TIME', 60)),
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
        'host' => env('MYSQL_DB_HOST', 'mysql'),
        'username' => env('MYSQL_DB_USERNAME', 'mysql'),
        'password' => env('MYSQL_DB_PASSWORD', 'root'),
        'port' => env('MYSQL_DB_PORT', 3306),
        'read' => [
            'host' => env('MYSQL_DB_HOST', 'mysql'),
            'username' => env('MYSQL_DB_USERNAME', 'mysql'),
            'password' => env('MYSQL_DB_PASSWORD', 'root'),
            'port' => env('MYSQL_DB_PORT', 3306),
        ],
        'write' => [
            'host' => env('MYSQL_READ_DB_HOST', env('MYSQL_DB_HOST', 'mysql')),
            'username' => env('MYSQL_READ_DB_USERNAME', env('MYSQL_DB_USERNAME', 'mysql')),
            'password' => env('MYSQL_READ_DB_PASSWORD', env('MYSQL_DB_PASSWORD', 'root')),
            'port' => env('MYSQL_READ_DB_PORT', env('MYSQL_DB_PORT', 3306)),
        ],
        'database' => env('MYSQL_DB__NAME', 'database'),
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
