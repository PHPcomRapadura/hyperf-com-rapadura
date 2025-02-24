<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Exception\GeneratingException;

interface GameCommandRepository
{
    /**
     * @throws GeneratingException
     */
    public function persist(GameCommand $game): string;
}
