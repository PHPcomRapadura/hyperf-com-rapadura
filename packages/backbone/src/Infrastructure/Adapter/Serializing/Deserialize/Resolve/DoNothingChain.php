<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter\Serializing\Deserialize\Resolve;

use Backbone\Domain\Support\Value;
use Backbone\Infrastructure\Adapter\Serializing\Deserialize\Chain;

class DoNothingChain extends Chain
{
    public function resolve(mixed $value): Value
    {
        return new Value($value);
    }
}
