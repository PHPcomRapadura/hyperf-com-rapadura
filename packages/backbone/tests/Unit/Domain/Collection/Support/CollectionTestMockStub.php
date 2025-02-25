<?php

declare(strict_types=1);

namespace Backbone\Test\Unit\Domain\Collection\Support;

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
