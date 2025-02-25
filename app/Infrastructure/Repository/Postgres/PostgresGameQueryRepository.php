<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Postgres;

use App\Domain\Collection\GameCollection;
use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use App\Infrastructure\Repository\PostgresRepository;
use App\Infrastructure\Support\Adapter\Serializing\Serializer;
use App\Infrastructure\Support\Adapter\Serializing\SerializerFactory;
use App\Infrastructure\Support\Persistence\Generator;
use App\Infrastructure\Support\Persistence\Hyperf\HyperfDBFactory;

use function Util\Type\Cast\toArray;

class PostgresGameQueryRepository extends PostgresRepository implements GameQueryRepository
{
    /**
     * @var Serializer<Game>
     */
    protected readonly Serializer $serializer;

    public function __construct(
        Generator $generator,
        HyperfDBFactory $hyperfDBFactory,
        SerializerFactory $serializerFactory,
    ) {
        parent::__construct($generator, $hyperfDBFactory);

        $this->serializer = $serializerFactory->make(Game::class);
    }

    public function getGame(string $id): ?Game
    {
        $query = 'select id, created_at, updated_at, name, slug, data from games where id = ?';
        $bindings = [$id];
        $data = toArray($this->database->query($query, $bindings));
        if (empty($data)) {
            return null;
        }
        /** @var array<string, mixed> $datum */
        $datum = $data[0];
        return $this->serializer->serialize($datum);
    }

    public function getGames(): GameCollection
    {
        $query = 'select id, created_at, updated_at, name, slug, data from games';
        /** @var array<array<string, mixed>> $data */
        $data = toArray($this->database->query($query));
        return GameCollection::createFrom($data, $this->serializer);
    }
}
