<?php

declare(strict_types=1);

namespace App\Domain\Entity\Command;

use App\Domain\Entity\Support\Entity;

class GameCommand extends Entity
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly array $data = [],
    ) {
    }
}
