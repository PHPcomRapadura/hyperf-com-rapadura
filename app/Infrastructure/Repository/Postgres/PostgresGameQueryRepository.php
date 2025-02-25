<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Postgres;

use App\Domain\Collection\GameCollection;
use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use App\Infrastructure\Repository\PostgresRepository;
use RuntimeException;

class PostgresGameQueryRepository extends PostgresRepository implements GameQueryRepository
{
    public function getGame(string $id): ?Game
    {
        $query = 'select id, created_at, updated_at, name, slug, data from games where id = ?';
        $bindings = [$id];
        $this->database->query($query, $bindings);
    }

    public function getGames(): GameCollection
    {
        throw new RuntimeException('Method not implemented');
    }
}
