<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Postgres;

use App\Domain\Collection\GameCollection;
use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use Backbone\Infrastructure\Persistence\PostgresRepository;

use function Backbone\Type\Cast\toArray;

class PostgresGameQueryRepository extends PostgresRepository implements GameQueryRepository
{
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
        return $this->serializerFactory->make(Game::class)->serialize($datum);
    }

    public function getGames(): GameCollection
    {
        $query = 'select id, created_at, updated_at, name, slug, data from games';
        /** @var array<array<string, mixed>> $data */
        $data = toArray($this->database->query($query));
        return GameCollection::createFrom($data, $this->serializerFactory->make(Game::class));
    }
}
