<?php

declare(strict_types=1);

namespace Backbone\Test\Unit\Infrastructure\Adapter\Serializing\Serialize;

use Backbone\Domain\Entity\Entity;
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
