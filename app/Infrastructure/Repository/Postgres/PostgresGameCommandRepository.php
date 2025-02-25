<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Postgres;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Exception\GeneratingException;
use App\Domain\Repository\GameCommandRepository;
use App\Infrastructure\Repository\PostgresRepository;
use App\Infrastructure\Support\Adapter\Serializing\Deserializer;
use App\Infrastructure\Support\Adapter\Serializing\DeserializerFactory;
use App\Infrastructure\Support\Persistence\Generator;
use App\Infrastructure\Support\Persistence\Hyperf\HyperfDBFactory;
use JsonException;

class PostgresGameCommandRepository extends PostgresRepository implements GameCommandRepository
{
    /**
     * @var Deserializer<GameCommand>
     */
    protected readonly Deserializer $deserializer;

    public function __construct(
        Generator $generator,
        HyperfDBFactory $databaseFactory,
        DeserializerFactory $deserializerFactory,
    ) {
        parent::__construct($generator, $databaseFactory);

        $this->deserializer = $deserializerFactory->make(GameCommand::class);
    }

    /**
     * @throws GeneratingException
     * @throws JsonException
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
        $values = [
            'id' => $id,
            'created_at' => $this->generator->now(),
            'updated_at' => $this->generator->now(),
            ...$this->deserializer->deserialize($game),
        ];
        $bindings = [];
        foreach ($fields as $field) {
            $bindings[] = $values[$field] ?? null;
        }
        $this->database->execute($query, $bindings);
        return $id;
    }
}
