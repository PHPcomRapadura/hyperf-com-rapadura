<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\SleekDB;

use Backbone\Infrastructure\Persistence\SleekDBRepository;

abstract class SleekDBGameRepository extends SleekDBRepository
{
    protected function resource(): string
    {
        return 'games';
    }
}
