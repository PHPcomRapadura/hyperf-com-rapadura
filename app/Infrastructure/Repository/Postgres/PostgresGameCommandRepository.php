<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Postgres;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Repository\GameCommandRepository;
use Exception;
use Hyperf\DB\Exception\QueryException;
use Serendipity\Domain\Exception\ManagedException;
use Serendipity\Domain\Exception\UniqueKeyViolationException;
use Serendipity\Hyperf\Database\Relational\Support\HasPostgresUniqueConstraint;
use Serendipity\Infrastructure\Repository\PostgresRepository;

class PostgresGameCommandRepository extends PostgresRepository implements GameCommandRepository
{
    use HasPostgresUniqueConstraint;

    /**
     * @throws ManagedException
     * @throws Exception|UniqueKeyViolationException
     */
    public function persist(GameCommand $game): string
    {
        $id = $this->managed->id();
        $fields = [
            'id',
            'created_at',
            'updated_at',
            'name',
            'slug',
            'data',
        ];
        /* @noinspection SqlNoDataSourceInspection, SqlResolve */
        $query = 'insert into "games" ("id", "created_at", "updated_at", "name", "slug", "data") '
            . 'values (?, ?, ?, ?, ?, ?)';


        $bindings = $this->bindings($game, $fields, ['id' => $id]);
        try {
            $this->database->execute($query, $bindings);
        } catch (QueryException $exception) {
            $detected = $this->detectUniqueKeyViolation($exception);
            throw $detected ?? $exception;
        }
        return $id;
    }

    public function destroy(string $id): bool
    {
        /* @noinspection SqlNoDataSourceInspection, SqlResolve */
        $query = 'delete from "games" where "id" = ?';
        $affected = $this->database->execute($query, [$id]);
        return $affected > 0;
    }
}
