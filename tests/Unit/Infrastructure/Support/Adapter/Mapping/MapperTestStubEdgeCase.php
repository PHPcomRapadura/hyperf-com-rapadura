<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Adapter\Mapping;

use Countable;
use Iterator;

class MapperTestStubEdgeCase
{
    private readonly mixed $whatever;

    public function __construct(
        public readonly int|string $union,
        public readonly Iterator&Countable $intersection,
        public readonly MapperTestStubWithConstructor $nested,
        $whatever,
    ) {
        $this->whatever = $whatever;
    }

    public function getWhatever()
    {
        return $this->whatever;
    }
}
