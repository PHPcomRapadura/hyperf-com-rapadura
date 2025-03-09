<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTimeImmutable;
use Serendipity\Domain\Support\Reflective\Attributes\Managed;
use App\Domain\Entity\Command\GameCommand;

class Game extends GameCommand
{
    public function __construct(
        #[Managed(management: 'id')]
        public readonly string $id,
        #[Managed(management: 'now')]
        public readonly DateTimeImmutable $createdAt,
        #[Managed(management: 'now')]
        public readonly DateTimeImmutable $updatedAt,
        string $name,
        string $slug,
        array $data = [],
    ) {
        parent::__construct($name, $slug, $data);
    }
}
