<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Collection\Support;

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
