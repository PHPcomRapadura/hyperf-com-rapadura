<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Persistence\Hyperf;

use Hyperf\DB\DB as Database;

class HyperfDBFactory
{
    public function __construct(private readonly Database $database)
    {
    }

    public function make(string $connection): Database
    {
        return $this->database::connection($connection);
    }
}
