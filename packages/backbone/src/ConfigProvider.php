<?php

declare(strict_types=1);

namespace Backbone;

use Backbone\Infrastructure\Http\Exception\Handler\AppExceptionHandler;
use Backbone\Infrastructure\Http\Exception\Handler\ValidationExceptionHandler;
use Backbone\Infrastructure\Http\Middleware\AppMiddleware;
use Backbone\Infrastructure\Logging\EnvironmentLoggerFactory;
use Backbone\Presentation\Output\Accepted;
use Backbone\Presentation\Output\Created;
use Backbone\Presentation\Output\NoContent;
use Backbone\Presentation\Output\NotFound;
use Hyperf\HttpServer\CoreMiddleware;
use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;
use Hyperf\Validation\Middleware\ValidationMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

use function Hyperf\Support\env;
use function Backbone\Util\Type\Cast\toString;


class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                LoggerInterface::class => static function (ContainerInterface $container) {
                    return $container->get(EnvironmentLoggerFactory::class)->make(toString(env('APP_ENV')));
                },
            ],
            'exceptions' => [
                'handler' => [
                    'http' => [
                        ValidationExceptionHandler::class,
                        HttpExceptionHandler::class,
                        AppExceptionHandler::class,
                    ],
                ],
            ],
            'http' => [
                'result' => [
                    Created::class => [
                        'status' => 201,
                    ],
                    Accepted::class => [
                        'status' => 202,
                    ],
                    NoContent::class => [
                        'status' => 204,
                    ],
                    NotFound::class => [
                        'status' => 404,
                    ],
                ],
            ],
            'middlewares' => [
                'http' => [
                    CoreMiddleware::class => AppMiddleware::class,
                    ValidationMiddleware::class,
                ],
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
        ];
    }
}
