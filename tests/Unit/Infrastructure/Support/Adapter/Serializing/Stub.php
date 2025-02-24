<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Adapter\Serializing;

class Stub
{
    public function __construct(
        public readonly string $foo,
        public readonly int $bar
    ) {
    }
}
