<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Deserialize\Resolve;

use App\Domain\Support\Value;
use App\Infrastructure\Support\Adapter\Serializing\Deserialize\Chain;

class DoNothingChain extends Chain
{
    public function resolve(mixed $value): Value
    {
        return new Value($value);
    }
}
