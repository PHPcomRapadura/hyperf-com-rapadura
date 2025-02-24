<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Command\GameCommand;
use DateTimeImmutable;

class Game extends GameCommand
{
    public function __construct(
        public readonly string $id,
        public readonly DateTimeImmutable $createdAt,
        public readonly DateTimeImmutable $updatedAt,
        string $name,
        string $slug,
        array $data = [],
    ) {
        parent::__construct($name, $slug, $data);
    }
}
