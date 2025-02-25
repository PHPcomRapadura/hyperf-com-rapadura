<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Adapter\Serializing\Serialize;

use App\Domain\Entity\Support\Entity;
use DateTime;

class BuilderTestStubWithConstructor extends Entity
{
    public function __construct(
        public readonly int $id,
        public readonly float $price,
        public readonly string $name,
        public readonly bool $isActive,
        public readonly BuilderTestStubWithNoConstructor $more,
        public readonly ?DateTime $createdAt,
        public readonly ?BuilderTestStubWithNoParameters $no,
        public readonly array $tags = [],
        ?string $foo = null,
    ) {
    }
}
