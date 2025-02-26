<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing\Deserialize\Resolve;

use Serendipity\Domain\Support\Value;
use Serendipity\Infrastructure\Adapter\Serializing\Deserialize\Chain;

class DoNothingChain extends Chain
{
    public function resolve(mixed $value): Value
    {
        return new Value($value);
    }
}
