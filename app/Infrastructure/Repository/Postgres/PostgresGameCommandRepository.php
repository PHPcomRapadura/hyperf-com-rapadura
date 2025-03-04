<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Postgres;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Repository\GameCommandRepository;
use Serendipity\Domain\Exception\GeneratingException;
use Serendipity\Infrastructure\Persistence\PostgresRepository;

class PostgresGameCommandRepository extends PostgresRepository implements GameCommandRepository
{
    /**
     * @throws GeneratingException
     */
    public function persist(GameCommand $game): string
    {
        $id = $this->generator->id();
        $fields = [
            'id',
            'created_at',
            'updated_at',
            'name',
            'slug',
            'data',
        ];
        $query = 'insert into "games" ("id", "created_at", "updated_at", "name", "slug", "data") ' .
                 'values (?, ?, ?, ?, ?, ?)';


        $bindings = $this->bindings($game, $fields, ['id' => $id]);
        $this->database->execute($query, $bindings);
        return $id;
    }
}
