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
    public function persist(GameCommand $game): string;

    public function destroy(string $id): bool;
}
