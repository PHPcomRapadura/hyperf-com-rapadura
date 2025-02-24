<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Json;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Exception\GeneratingException;
use App\Domain\Repository\GameCommandRepository;
use App\Infrastructure\Support\Adapter\Serializing\Deserializer;
use App\Infrastructure\Support\Persistence\Generator;
use App\Infrastructure\Support\Persistence\SleekDB\SleekDBDatabaseFactory;
use JsonException as SerializationError;
use SleekDB\Exceptions\IdNotAllowedException;
use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\IOException;
use SleekDB\Exceptions\JsonException;

class JsonGameCommandRepository extends JsonGameRepository implements GameCommandRepository
{
    /**
     * @var Deserializer<GameCommand>
     */
    protected readonly Deserializer $deserializer;

    public function __construct(
        Generator $generator,
        SleekDBDatabaseFactory $databaseFactory,
    ) {
        parent::__construct($generator, $databaseFactory);

        $this->deserializer = new Deserializer(GameCommand::class);
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
