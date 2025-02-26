<?php

declare(strict_types=1);

namespace Serendipity\Test\Unit\Infrastructure\Adapter\Serializing;

class Stub
{
    public function __construct(
        public readonly string $foo,
        public readonly int $bar
    ) {
    }
}
