<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Json;

use App\Infrastructure\Support\Persistence\Generator;
use App\Infrastructure\Support\Persistence\SleekDB\SleekDBDatabaseFactory;
use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\InvalidConfigurationException;
use SleekDB\Exceptions\IOException;
use SleekDB\Store;

class JsonGameRepository
{
    protected readonly Store $database;

    /**
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws InvalidConfigurationException
     */
    public function __construct(
        protected readonly Generator $generator,
        SleekDBDatabaseFactory $databaseFactory,
    ) {
        $this->database = $databaseFactory->createFrom('games');
    }
}
