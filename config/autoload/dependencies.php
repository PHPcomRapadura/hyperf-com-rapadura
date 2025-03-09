<?php

declare(strict_types=1);

use App\Domain\Repository\GameCommandRepository;
use App\Domain\Repository\GameQueryRepository;
use App\Infrastructure\Repository\SleekDB\SleekDBGameCommandRepository;
use App\Infrastructure\Repository\SleekDB\SleekDBGameQueryRepository;
use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Container\ContainerInterface as Container;
use Psr\Log\LoggerInterface;
use Serendipity\Hyperf\Database\Document\HyperfSleekDBFactory;
use Serendipity\Hyperf\Database\Relational\HyperfConnectionFactory;
use Serendipity\Hyperf\Logging\GoogleCloudLoggerFactory;
use Serendipity\Hyperf\Testing\Observability\Logger\InMemory\InMemoryLogger;
use Serendipity\Infrastructure\Database\Document\SleekDBFactory;
use Serendipity\Infrastructure\Database\Relational\ConnectionFactory;

use function Hyperf\Support\env;
use function Serendipity\Type\Cast\stringify;

if (! defined('APP_ENV')) {
    define('APP_ENV', stringify(env('APP_ENV', 'dev')));
}

return [
    LoggerInterface::class => fn (Container $container) => match (APP_ENV) {
        'test' => $container->get(InMemoryLogger::class),
        'prd', 'hom', 'liv', 'stg' => $container->get(GoogleCloudLoggerFactory::class)->make(APP_ENV),
        default => $container->get(StdoutLoggerInterface::class),
    },

    SleekDBFactory::class => fn (Container $container) => (new HyperfSleekDBFactory())->make($container),
    ConnectionFactory::class => HyperfConnectionFactory::class,

    GameCommandRepository::class => SleekDBGameCommandRepository::class,
    GameQueryRepository::class => SleekDBGameQueryRepository::class,
];
