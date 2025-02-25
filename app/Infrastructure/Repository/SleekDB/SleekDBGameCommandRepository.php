<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\SleekDB;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Repository\GameCommandRepository;
use Backbone\Domain\Exception\GeneratingException;
use Backbone\Infrastructure\Adapter\Serializing\Deserializer;
use Backbone\Infrastructure\Adapter\Serializing\DeserializerFactory;
use Backbone\Infrastructure\Persistence\Factory\SleekDBDatabaseFactory;
use Backbone\Infrastructure\Persistence\Generator;
use JsonException as SerializationError;
use SleekDB\Exceptions\IdNotAllowedException;
use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\IOException;
use SleekDB\Exceptions\JsonException;

class SleekDBGameCommandRepository extends SleekDBGameRepository implements GameCommandRepository
{
    /**
     * @var Deserializer<GameCommand>
     */
    protected readonly Deserializer $deserializer;

    public function __construct(
        Generator $generator,
        SleekDBDatabaseFactory $databaseFactory,
        DeserializerFactory $deserializerFactory,
    ) {
        parent::__construct($generator, $databaseFactory);

        $this->deserializer = $deserializerFactory->make(GameCommand::class);
    }

    /**
     * @throws IOException
     * @throws JsonException
     * @throws IdNotAllowedException
     * @throws InvalidArgumentException
     * @throws GeneratingException
     * @throws SerializationError
     */
    public function persist(GameCommand $game): string
    {
        $datum = $this->deserializer->deserialize($game);
        $id = $this->generator->id();
        $datum['id'] = $id;
        $datum['created_at'] = $this->generator->now();
        $datum['updated_at'] = $this->generator->now();
        $this->database->insert($datum);
        return $id;
    }
}
