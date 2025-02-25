<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Postgres;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Repository\GameCommandRepository;
use Backbone\Domain\Exception\GeneratingException;
use Backbone\Infrastructure\Persistence\PostgresRepository;

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
        $query = 'insert into games (id, created_at, updated_at, name, slug, data) values (?, ?, ?, ?, ?, ?)';

        $bindings = $this->bindings($game, $id, $fields);
        $this->database->execute($query, $bindings);
        return $id;
    }

    private function bindings(GameCommand $game, string $id, array $fields): array
    {
        $deserialized = $this->deserializerFactory->make(GameCommand::class)
            ->deserialize($game);
        $values = [
            'id' => $id,
            'created_at' => $this->generator->now(),
            'updated_at' => $this->generator->now(),
            ...$deserialized,
        ];
        $bindings = [];
        foreach ($fields as $field) {
            $bindings[] = $values[$field] ?? null;
        }
        return $bindings;
    }
}
