<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Infrastructure\Support\Persistence\Generator;
use App\Infrastructure\Support\Persistence\Hyperf\HyperfDBFactory;
use Hyperf\DB\DB as Database;

abstract class PostgresRepository
{
    protected readonly Database $database;

    public function __construct(
        protected readonly Generator $generator,
        HyperfDBFactory $hyperfDBFactory,
    ) {
        $this->database = $hyperfDBFactory->make('postgres');
    }
}
