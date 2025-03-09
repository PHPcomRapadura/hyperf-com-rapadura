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
    public function create(GameCommand $game): string
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

    /**
     * @throws ManagedException
     */
    public function update(int|string $id, GameCommand $game): bool
    {
        $fields = [
            'updated_at',
            'name',
            'slug',
            'data',
        ];
        /* @noinspection SqlNoDataSourceInspection, SqlResolve */
        $query = 'update "games" set "updated_at" = ?, "name" = ?, "slug" = ?, "data" = ? where "id" = ?';
        $bindings = $this->bindings($game, $fields, ['id' => $id]);
        $affected = $this->database->execute($query, $bindings);
        return $affected > 0;
    }

    public function delete(int|string $id): bool
    {
        /* @noinspection SqlNoDataSourceInspection, SqlResolve */
        $query = 'delete from "games" where "id" = ?';
        $affected = $this->database->execute($query, [$id]);
        return $affected > 0;
    }
}
