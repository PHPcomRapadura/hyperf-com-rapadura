<?php

declare(strict_types=1);

namespace Serendipity\Test\Unit\Domain\Collection\Support;

use JsonSerializable;

class CollectionTestMockStub implements JsonSerializable
{
    public function __construct(public readonly string $value)
    {
    }

    public function jsonSerialize(): array
    {
        return [];
    }
}
