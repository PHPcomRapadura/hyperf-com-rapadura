<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Adapter\Serializing\Serialize;

use Countable;
use Iterator;
use RuntimeException;

class BuilderTestStubEdgeCaseIntersection implements Iterator, Countable
{
    public function current(): mixed
    {
        throw new RuntimeException('Not implemented');
    }

    public function key(): mixed
    {
        throw new RuntimeException('Not implemented');
    }

    public function next(): void
    {
        throw new RuntimeException('Not implemented');
    }

    public function rewind(): void
    {
        throw new RuntimeException('Not implemented');
    }

    public function valid(): bool
    {
        throw new RuntimeException('Not implemented');
    }

    public function count(): int
    {
        throw new RuntimeException('Not implemented');
    }
}
