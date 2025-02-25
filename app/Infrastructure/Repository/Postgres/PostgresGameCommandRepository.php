<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Postgres;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Repository\GameCommandRepository;
use App\Infrastructure\Repository\PostgresRepository;

use function Util\Type\Json\encode;

class PostgresGameCommandRepository extends PostgresRepository implements GameCommandRepository
{
    public function persist(GameCommand $game): string
    {
        $id = $this->generator->id();
        $query = 'insert into games (id, created_at, updated_at, name, slug, data) values (?, ?, ?, ?, ?, ?)';
        $bindings = [
            $id,
            $this->generator->now(),
            $this->generator->now(),
            $game->name,
            $game->slug,
            encode($game->data),
        ];
        $this->database->execute($query, $bindings);
        return $id;
    }
}
