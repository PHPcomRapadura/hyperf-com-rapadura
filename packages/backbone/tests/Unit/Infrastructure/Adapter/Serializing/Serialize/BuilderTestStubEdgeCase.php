<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Adapter\Serializing\Serialize;

use Countable;
use Iterator;

class BuilderTestStubEdgeCase
{
    private readonly mixed $whatever;

    public function __construct(
        public readonly int|string $union,
        public readonly Countable&Iterator $intersection,
        public readonly BuilderTestStubWithConstructor $nested,
        $whatever,
    ) {
        $this->whatever = $whatever;
    }

    public function getWhatever()
    {
        return $this->whatever;
    }
}
