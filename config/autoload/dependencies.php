<?php

declare(strict_types=1);

use App\Domain\Repository\GameCommandRepository;
use App\Domain\Repository\GameQueryRepository;
use App\Infrastructure\Repository\SleekDB\SleekDBGameCommandRepository;
use App\Infrastructure\Repository\SleekDB\SleekDBGameQueryRepository;

return [
    GameCommandRepository::class => SleekDBGameCommandRepository::class,
    GameQueryRepository::class => SleekDBGameQueryRepository::class,
];
