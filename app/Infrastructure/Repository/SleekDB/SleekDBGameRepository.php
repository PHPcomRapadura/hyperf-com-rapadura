<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\SleekDB;

use App\Infrastructure\Repository\SleekDBRepository;

abstract class SleekDBGameRepository extends SleekDBRepository
{
    protected function resource(): string
    {
        return 'games';
    }
}
