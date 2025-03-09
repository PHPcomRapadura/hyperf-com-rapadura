<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Command\GameCommand;
use Serendipity\Domain\Exception\ManagedException;

interface GameCommandRepository
{
    /**
     * @throws ManagedException
     */
    public function create(GameCommand $game): string;

    /**
     * @throws ManagedException
     */
    public function update(int|string $id, GameCommand $game): bool;

    public function delete(int|string $id): bool;
}
