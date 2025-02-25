<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\SleekDB;

use App\Domain\Collection\GameCollection;
use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use App\Infrastructure\Support\Adapter\Serializing\Serializer;
use App\Infrastructure\Support\Adapter\Serializing\SerializerFactory;
use App\Infrastructure\Support\Persistence\Generator;
use App\Infrastructure\Support\Persistence\SleekDB\SleekDBDatabaseFactory;
use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\IOException;

class SleekDBGameQueryRepository extends SleekDBGameRepository implements GameQueryRepository
{
    /**
     * @var Serializer<Game>
     */
    protected readonly Serializer $serializer;

    public function __construct(
        Generator $generator,
        SleekDBDatabaseFactory $databaseFactory,
        SerializerFactory $serializerFactory,
    ) {
        parent::__construct($generator, $databaseFactory);

        $this->serializer = $serializerFactory->make(Game::class);
    }

    /**
     * @throws InvalidArgumentException
     * @throws IOException
     */
    public function getGame(string $id): ?Game
    {
        $data = $this->database->findBy(['id', '=', $id]);
        if (empty($data)) {
            return null;
        }
        /** @var array<string, mixed> $datum */
        $datum = $data[0];
        return $this->serializer->serialize($datum);
    }

    /**
     * @throws IOException
     * @throws InvalidArgumentException
     */
    public function getGames(): GameCollection
    {
        /** @var array<array<string, mixed>> $data */
        $data = $this->database->findAll();
        return GameCollection::createFrom($data, $this->serializer);
    }
}
