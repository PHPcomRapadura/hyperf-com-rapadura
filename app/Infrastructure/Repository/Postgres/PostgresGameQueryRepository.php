<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Postgres;

use App\Domain\Collection\GameCollection;
use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use Serendipity\Infrastructure\Repository\PostgresRepository;

class PostgresGameQueryRepository extends PostgresRepository implements GameQueryRepository
{
    public function read(string $id): ?Game
    {
        /* @noinspection SqlNoDataSourceInspection, SqlResolve */
        $query = 'select "id", "created_at", "updated_at", "name", "slug", "data" from "games" where "id" = ?';
        $bindings = [$id];
        $data = $this->database->query($query, $bindings);
        $serializer = $this->serializerFactory->make(Game::class);
        return $this->entity($serializer, $data);
    }

    public function search(array $filters = []): GameCollection
    {
        /* @noinspection SqlNoDataSourceInspection, SqlResolve */
        $query = 'select "id", "created_at", "updated_at", "name", "slug", "data" from "games"';
        $data = $this->database->query($query);
        $serializer = $this->serializerFactory->make(Game::class);
        return $this->collection($serializer, $data, GameCollection::class);
    }
}
