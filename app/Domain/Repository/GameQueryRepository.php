<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Collection\GameCollection;
use App\Domain\Entity\Game;

interface GameQueryRepository
{
    public function read(string $id): ?Game;

    public function search(array $filters = []): GameCollection;
}
