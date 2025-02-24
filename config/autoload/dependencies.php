<?php

declare(strict_types=1);

use App\Domain\Repository\GameCommandRepository;
use App\Domain\Repository\GameQueryRepository;
use App\Infrastructure\Repository\Json\JsonGameCommandRepository;
use App\Infrastructure\Repository\Json\JsonGameQueryRepository;
use App\Infrastructure\Support\Logging\EnvironmentLoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

use function Hyperf\Support\env;
use function Util\Type\Cast\toString;

return [
    LoggerInterface::class => static function (ContainerInterface $container) {
        return $container->get(EnvironmentLoggerFactory::class)->make(toString(env('APP_ENV')));
    },
    GameCommandRepository::class => JsonGameCommandRepository::class,
    GameQueryRepository::class => JsonGameQueryRepository::class,
];
