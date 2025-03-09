<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Collection\GameCollection;
use App\Domain\Entity\Game;

interface GameQueryRepository
{
    public function getGame(string $id): ?Game;

    public function getGames(array $filters = []): GameCollection;
}
