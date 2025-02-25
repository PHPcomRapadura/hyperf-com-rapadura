<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Persistence;

use Backbone\Infrastructure\Persistence\Factory\HyperfDBFactory;
use Backbone\Infrastructure\Persistence\Relational\RelationalDeserializerFactory;
use Backbone\Infrastructure\Persistence\Relational\RelationalSerializerFactory;
use Hyperf\DB\DB as Database;

abstract class PostgresRepository
{
    protected readonly Database $database;

    public function __construct(
        protected readonly Generator $generator,
        protected readonly RelationalDeserializerFactory $deserializerFactory,
        protected readonly RelationalSerializerFactory $serializerFactory,
        HyperfDBFactory $hyperfDBFactory,
    ) {
        $this->database = $hyperfDBFactory->make('postgres');
    }
}
