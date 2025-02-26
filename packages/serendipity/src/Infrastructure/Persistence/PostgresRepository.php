<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Persistence;

use Serendipity\Infrastructure\Persistence\Factory\HyperfDBFactory;
use Serendipity\Infrastructure\Persistence\Serializing\RelationalDeserializerFactory;
use Serendipity\Infrastructure\Persistence\Serializing\RelationalSerializerFactory;
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
