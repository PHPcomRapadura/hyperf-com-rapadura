<?php

declare(strict_types=1);

namespace Backbone\Test\Unit\Infrastructure\Adapter\Serializing;

class Stub
{
    public function __construct(
        public readonly string $foo,
        public readonly int $bar
    ) {
    }
}
